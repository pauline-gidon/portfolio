<?php

namespace App\Controller;

use App\Entity\Projet;
use App\Entity\Techno;
use App\Form\ProjetType;
use App\Form\TechnoType;
use App\Repository\ProjetRepository;
use App\Repository\TechnoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class AdminController extends AbstractController
{
    /**
     * @var ProjetRepository
     */
    private $repository;

    public function __construct(ProjetRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }


    /**
     * @Route("/admin", name="admin_index")
     */
    public function index(): Response
    {
        return $this->render('admin/home_admin.html.twig');
    }



     /**
     * @Route("/admin/projet/all-projet", name="all_projet")
     */
    public function allProjet(): response
    {
        $projets = $this->repository->findAll();
        dump($projets);
        return $this->render('admin/projet/all_projet.html.twig',[
            'projets' => $projets
        ]);
    }


    /**
     * @Route("/admin/projet/add-projet", name="nouveau_projet")
     */
    public function addProjet(Request $request, SluggerInterface $slugger): response
    {
        $projet = new Projet();

        $form = $this->createForm(ProjetType::class, $projet);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {
            $mediafile = $form->get('media')->getData();
            if ($mediafile) {
                $originalFilename = pathinfo($mediafile->getClientOriginalName(), PATHINFO_FILENAME);
  
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$mediafile->guessExtension();


                try {
                    $mediafile->move(
                        $this->getParameter('media_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $projet->setmedia($newFilename);
            }
            $this->em->persist($projet);
            $this->em->flush();
             
            $this->addFlash('success', 'Le projet a bien été enregistrée.');

            return $this->redirectToRoute('all_projet');
        }

        return $this->render('admin/projet/add_projet.html.twig', [
            'form' => $form->createView()
        ]);

    }

    /**
     * @Route("/admin/projet/edit{id}", name="projet_edit", methods="GET|POST")
     */
    public function editprojet(Projet $projet, Request $request, SluggerInterface $slugger)
    {
        $form = $this->createForm(ProjetType::class, $projet);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $mediafile = $form->get('media')->getData();

            if ($mediafile) {

                $fileremove = $projet->getmedia();

                if($fileremove){
      
                    unlink($this->getParameter('media_directory')."/".$fileremove);
                }
            
                $originalFilename = pathinfo($mediafile->getClientOriginalName(), PATHINFO_FILENAME);
  
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$mediafile->guessExtension();


                try {
                    $mediafile->move(
                        $this->getParameter('media_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                $projet->setmedia($newFilename);
            }
            $this->em->flush();
            $this->addFlash('success', 'La projet a bien été modifiée.');

            return $this-> redirectToRoute('all_projet');
        }

        return $this->render('admin/projet/edit.html.twig', [
            'projet' => $projet,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/projet/delete{id}", name="projet_delete")
     */
    public function deleteTechno(Projet $projet, Request $request)
    {
            $fileremove = $projet->getmedia();

            if($fileremove){

                unlink($this->getParameter('media_directory')."/".$fileremove);
            }
            $this->em->remove($projet);
            $this->em->flush();
            $this->addFlash('success', 'Le projet a bien été supprimé.');

            return $this-> redirectToRoute('all_projet');
    }


}
