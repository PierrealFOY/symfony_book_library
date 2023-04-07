<?php

namespace App\Controller\Api;

use App\Repository\BookRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\View\View;


class ApiBookController extends AbstractFOSRestController
{
    /**
     * @Route("/api/book", name="app_api_book")
     */
    public function getBooks(BookRepository $bookRepository) : Response
    {
        $view = View::create();

        $book = $bookRepository->findAll();

        $view = $this->view($book, 200);

        $view->setFormat('json');
        
        return $this->handleView($view);
    }

}
