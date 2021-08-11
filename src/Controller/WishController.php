<?php

namespace App\Controller;

use App\Entity\Wish;
use App\Form\WishType;
use App\Repository\WishRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/wish")
 */
class WishController extends AbstractController
{
   /**
    * @Route("/",name="wish_home")
    */
   public function home(WishRepository $repo): Response
   {
      $wishes = $repo->findAll();
      // ['wishes'=> $wishes]
      return $this->render("wish/home.html.twig", compact('wishes'));
   }

   /**
    * @Route("/ajouter", name="wish_ajouter")
    */
   public function ajouter(Request $request): Response
   {
      $em = $this->getDoctrine()->getManager();
      $wish = new Wish();
      $pseudo = $this->getUser()->getPseudo();
      $wish->setAuthor($pseudo);
      $form = $this->createForm(WishType::class, $wish);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
         $wish->setDateCreated(new \DateTime());
         $em->persist($wish);
         $em->flush();

         return $this->redirectToRoute('wish_home');
      }
      return $this->render(
         'wish/ajouter.html.twig',
         ['formWish' => $form->createView()]
      );
   }
   /**
    * @Route("/modifier/{id}", name="wish_modifier")
    */
   public function modifier(Wish $wish, Request $request): Response
   {
      $em = $this->getDoctrine()->getManager();
      //$wish = new Wish();
      $form = $this->createForm(WishType::class, $wish);
      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
         $wish->setDateCreated(new \DateTime());
         //$em->persist($wish);
         $em->flush();

         return $this->redirectToRoute('wish_home');
      }
      return $this->render(
         'wish/modifier.html.twig',
         ['formWish' => $form->createView()]
      );
   }
   /**
    * @Route("/enlever/{id}", name="wish_enlever")
    */
   public function enlever(Wish $wish, EntityManagerInterface $em): Response
   {
      $em->remove($wish);
      $em->flush();
      return $this->redirectToRoute('wish_home');
   }
   /**
    * @Route("/author/{author}", name="wish_author")
    */
   public function author($author, WishRepository $repo): Response
   {
      //dd($author);
      $wishes = $repo->findBy(['author' => $author]);
      // ['wishes'=> $wishes]
      return $this->render("wish/home.html.twig", compact('wishes'));
   }
}
