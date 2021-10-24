<?php

namespace App\Controller;

use App\Entity\Techno;
use App\Form\TechnoType;
use App\Repository\TechnoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TechnoController extends AbstractController
{

    /**
     * @var TechnoRepository
     */
    private $repository;

    public function __construct(TechnoRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }



     /**
     * @Route("/admin/all-techno", name="all_techno")
     */
    public function allTechno(): response
    {
        $technos = $this->repository->findAll();
        return $this->render('admin/techno/all_techno.html.twig',[
            'technos' => $technos
        ]);
    }


    /**
     * @Route("/admin/techno/add-techno", name="nouvelle_techno")
     */
    public function addTechno(Request $request): response
    {
        $techno = new Techno();

        $form = $this->createForm(TechnoType::class, $techno);

        $form->handleRequest($request);


        if($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($techno);
            $this->em->flush();
             
            $this->addFlash('success', 'La techno a bien été enregistrée.');

            return $this->redirectToRoute('all_techno');
        }



        return $this->render('admin/techno/add_techno.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/techno/edit{id}", name="techno_edit", methods="GET|POST")
     */
    public function editTechno(Techno $techno, Request $request)
    {
        $form = $this->createForm(TechnoType::class, $techno);
        $form->handleRequest($request);
        $this->addFlash('success', 'La techno a bien été modifiée.');

        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            return $this-> redirectToRoute('all_techno');
        }

        return $this->render('admin/techno/edit.html.twig', [
            'techno' => $techno,
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/admin/techno/delete{id}", name="techno_delete")
     */
    public function deleteTechno(Techno $techno, Request $request)
    {
            $this->em->remove($techno);
            $this->em->flush();
            $this->addFlash('success', 'La techno a bien été supprimée.');

            return $this-> redirectToRoute('all_techno');
    }

}
