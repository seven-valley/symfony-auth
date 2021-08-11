<?php

namespace App\Controller;

use App\Repository\CategRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function home(CategRepository $repoCateg): Response
    {
       // $categs = $repoCateg->findAll();
        $categs = $repoCateg->findByPublished();
        // compact('categs')  OU ['categs'=> $categs]
        return $this->render('main/home.html.twig', compact('categs'));
    }
    /**
     * @Route("/about-us", name="about")
     */
    public function about(): Response
    {
        return $this->render('main/about.html.twig');
    }
}
