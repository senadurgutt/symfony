<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Admin\ProductRepository;
use App\Repository\Admin\CategoryRepository;

class HomeController extends AbstractController
{
//
    /**
     * @Route("/home", name="home")
     */
    public function index(ProductRepository $productRepository, CategoryRepository $categoryRepository): Response
    {
        $products = $productRepository->findAll();
        $categories = $categoryRepository->findAll();

        return $this->render('home/index.html.twig', [
            'products' => $products,
            'controller_name' => 'HomeController',
            'categories' => $categories,
        ]);
    }


    /**
     * @Route("/categories/{id}", name="categories", methods={"GET"})
     */
    public function catShow(int $id, CategoryRepository $categoryRepository,ProductRepository $productRepository): Response
    {
        $category = $categoryRepository->find($id);
        if (!$category) {
            throw $this->createNotFoundException('The category does not exist');
        }
        $products = $category->getProducts();
        return $this->render('admin/category/catshow.html.twig', [
            'category' => $category,
            'products' => $products,
        ]);
    }
}
