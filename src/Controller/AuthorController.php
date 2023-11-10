<?php

namespace App\Controller;

use App\Entity\Author;
use App\Form\AuthorType;
use App\Repository\AuthorRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AuthorController extends AbstractController
{
    #[Route('/author', name: 'app_author')]
    //public function index(Request $request , AuthorRepository $authorRepository, ManagerRegistry $registry): Response
    public function index(AuthorRepository $repository): Response
    {
        return $this->render('author/index.html.twig', [
            'authors'=>$repository->listAuthorByEmail()
            //'author'=>$author,
        ]);
    }
    #[Route('/fetch', name: 'fetch')]
 public function fetch(StudentRepository $repo):Response
 {
 $result=$repo->findAll();
 return $this->render('student/test.html.twig',[
 'response' =>$result
 ]);
 }
    #[Route('/author/new',name:'app_author_new')]
    public function new(Request $request , ManagerRegistry $mr):Response
    {
        $author=new Author;
        $em=$mr->getmanager();
        $form=$this->createForm(AuthorType::class,$author);
        $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid())
         {
            $em->persist($author);
            $em->flush();
            return $this->redirectToRoute('app_author');
         }
         return $this->render('author/new.html.twig', [
            'form' => $form->createView(),
         ]);

         
    }
    #[Route('/author/edit/{id}',name:'app_author_edit')]
    public function edit(Request $request,AuthorRepository $repository , ManagerRegistry $mr):Response
    {
        $author=$repository->find($request->get('id'));
        $em=$mr->getmanager();
        $form=$this->createForm(AuthorType::class,$author);
        $form->handleRequest($request);
         if ($form->isSubmitted() && $form->isValid())
         {
            $em->persist($author);
            $em->flush();
             return $this->redirectToRoute('app_author');
         }
         return $this->render('author/edit.html.twig', [
            'form' => $form->createView(),
         ]);
    }
    #[Route('/author/delete/{id}',name:'app_author_delete')]
    public function delte(Request $request,AuthorRepository $repository , ManagerRegistry $mr):Response
    {
        $author=$repository->find($request->get('id'));
        $em=$mr->getmanager();
        $em->remove($author);
        $em->flush();
        return $this->redirectToRoute('app_author');
    }
    


    //#[Route('/author_email',name:'app_author_email')]
    //public function 
}
