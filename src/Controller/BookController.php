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
            'book' => 'bookRepository->findAll()',
            // 'books' => $books,
        ]);
    }

    /**
     * @Route("/livre/ajouter", name="app_book_add", methods={"GET", "POST"})
     */
    public function add(Request $request, BookRepository $bookRepository): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            $bookRepository->add($book, true);

            return $this->redirectToRoute('app_book_list', [], Response::HTTP_SEE_OTHER);  
        }

        return $this->redirectToRoute('book/new.html.twig', [
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

        $form = $this->createForm(BookType::class, (new Book()));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $bookRepository->add($book, true);

            return $this->redirectToRoute('app_book_list', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('book/edit.html.twig', [
            // 'book' => $book,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/livre/supprimer/{id}", name="app_book_delete")
     */
    public function delete(Book $book, BookRepository $bookRepository): Response
    {
        $bookRepository->delete($book, true);

        return $this->redirectToRoute('app_book_list', [], Response::HTTP_SEE_OTHER);
    }
}
