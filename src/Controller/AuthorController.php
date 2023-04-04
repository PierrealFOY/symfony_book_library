<?php

namespace App\Controller;

use App\Entity\Author;
use App\Repository\AuthorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;


class AuthorController extends AbstractController
{
    /**
     * @Route("/auteur", name="app_author_list", methods={"GET"})
     */
    public function list(AuthorRepository $authorRepository, Request $request): Response
    {

        $authors = $authorRepository->findAllOrderedByTitle($request->get('search'));

        return $this->render('author/list.html.twig', [
            'authors' => $authors,
        ]);
    }

    /**
     * @Route("/auteur/ajouter", name="app_author_new", methods={"GET", "POST"})
     */
    public function add(Request $request, AuthorRepository $authorRepository): Response
    {
        $author = new author();
        $form = $this->createForm(AuthorType::class, $author);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $authorRepository->add($author, true);

            $this->addFlash('success', "Un nouveau auteur a bien été ajouté !");

            return $this->redirectToRoute('app_author_list', [], Response::HTTP_SEE_OTHER);  
        }

        return $this->renderForm('author/new.html.twig', [
            'author' => $author,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/auteur/{id}", name="app_author_show")
     */
    public function show(AuthorRepository $authorRepository, author $author): Response
    {

        // $author = $authorRepository->findAllOrderByTitleSearch($author);
        return $this->render('author/show.html.twig', [
            'author' => $author,
        ]);
    }

    /**
     * @Route("/auteur/modifier/{id}", name="app_author_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, author $author, AuthorRepository $authorRepository): Response
    {

        $form = $this->createForm(AuthorType::class, $author);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $authorRepository->add($author, true);

            return $this->redirectToRoute('app_author_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('author/edit.html.twig', [
            'author' => $author,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/auteur/supprimer/{id}", name="app_author_delete")
     */
    public function delete(Request $request, author $author, AuthorRepository $authorRepository): Response
    {
        
        if ($this->isCsrfTokenValid('delete'.$author->getId(), $request->request->get('_token'))) {
            $authorRepository->remove($author, true);
        }

        $this->addFlash('danger', "Un auteur a été supprimé !");

        return $this->redirectToRoute('app_author_list', [], Response::HTTP_SEE_OTHER);
    }

}
