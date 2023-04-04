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

        return $this->render('main/index.html.twig', [
            'authors' => $authors,
        ]);
    }

}
