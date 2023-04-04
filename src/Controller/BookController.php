<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class BookController extends AbstractController
{
    /**
     * @Route("/livre", name="app_book_list")
     */
    public function list(BookRepository $bookRepository, Request $request): Response
    {
        $books = $bookRepository->findAllOrderedByTitle($request->get('search'));

        return $this->render('book/list.html.twig', [
            'books' => $bookRepository->findAll(),
            // 'books' => $books,
        ]);
    }

    /**
     * @Route("/livre/ajouter", name="app_book_new", methods={"GET", "POST"})
     */
    public function add(Request $request, BookRepository $bookRepository): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $bookRepository->add($book, true);

            $this->addFlash('success', "Un nouveau livre a bien été ajouté !");

            return $this->redirectToRoute('app_book_list', [], Response::HTTP_SEE_OTHER);  
        }

        return $this->renderForm('book/new.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/livre/{id}", name="app_book_show")
     */
    public function show(BookRepository $bookRepository, Book $book): Response
    {

        // $book = $bookRepository->findAllOrderByTitleSearch($book);
        return $this->render('book/show.html.twig', [
            'book' => $book,
        ]);
    }

    /**
     * @Route("/livre/modifier/{id}", name="app_book_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Book $book, BookRepository $bookRepository): Response
    {

        $form = $this->createForm(BookType::class, $book);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $bookRepository->add($book, true);

            return $this->redirectToRoute('app_book_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('book/edit.html.twig', [
            'book' => $book,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/livre/supprimer/{id}", name="app_book_delete")
     */
    public function delete(Request $request, Book $book, BookRepository $bookRepository): Response
    {
        
        if ($this->isCsrfTokenValid('delete'.$book->getId(), $request->request->get('_token'))) {
            $bookRepository->remove($book, true);
        }

        $this->addFlash('danger', "Un livre a été supprimé !");

        return $this->redirectToRoute('app_book_list', [], Response::HTTP_SEE_OTHER);
    }
}
