<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request, EntityManagerInterface $manager, ArticleRepository $articleRepo): Response
    {

        if ($request->query->has('search')) {
            $articles = $articleRepo->search($request->query->get('search'));
        } else {
            $articles = $articleRepo->findAll();
        }
        return $this->render('home/index.html.twig', [
            'articles' => $articles,
        ]);
    }

    /**
     * @Route("/display/{id}", name="home")
     */
    // public function index(Request $request, EntityManagerInterface $manager, ArticleRepository $articleRepo): Response
    // {

    // if ($request->query->has('search')) {
    //     $articles = $articleRepo->search($request->query->get('search'));
    // } else {
    //     $articles = $articleRepo->findAll();
    // }
    // return $this->render('home/index.html.twig', [
    //     'articles' => $articles,
    // ]);
    //  }
}
