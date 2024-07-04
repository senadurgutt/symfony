<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends AbstractController
{
    /**
     * @Route("/admin/category", name="category")
     */
    public function category(): Response
    {
        return $this->render('admin/category/index.html.twig', []);
    }
}
