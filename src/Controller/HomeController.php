<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Admin\ProductRepository;
use App\Repository\Admin\CategoryRepository;

class HomeController extends AbstractController
{
//    /**
//     * @Route("/home", name="app_home")
//     */
//    public function index(): Response
//    {
//        return $this->render('/base.html.twig', [
//            'controller_name' => 'HomeController',
//        ]);
//    }

    /**
     * @Route("/home", name="home")
     */
    public function index(ProductRepository $productRepository,CategoryRepository $categoryRepository): Response
    {
        $products = $productRepository->findAll();
        $categories = $categoryRepository->findAll();

        return $this->render('home/index.html.twig', [
            'products' => $products,
            'controller_name' => 'HomeController',
            'categories' => $categories,
        ]);
    }


}
