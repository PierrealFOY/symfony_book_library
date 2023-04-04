<?php

namespace App\Controller;

use App\Entity\Book;
use App\Entity\Author;
use App\Repository\BookRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="app_main_home", methods={"GET"})
     */
    public function home(BookRepository $bookRepository, Request $request): Response
    {
        $books = $bookRepository->findAllOrderedByReleaseDate();

        return $this->render('main/index.html.twig', [
            'books' => $books,
        ]);
    }

}
