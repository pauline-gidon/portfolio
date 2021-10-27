<?php

namespace App\Controller;

use App\Repository\ProjetRepository;
use App\Entity\Projet;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SiteController extends AbstractController
{
    /**
     * @var ProjetRepository
     */
    private $repository;

    public function __construct(ProjetRepository $repository)
    {
        $this->repository = $repository;
    }
    /**
     * @Route("/", name="site")
     */
    public function index(): Response
    {
        $projets = $this->repository->findAll();

        return $this->render('site/index.html.twig',[
            'projets' => $projets
        ]);
    }


}
