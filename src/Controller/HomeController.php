<?php

namespace App\Controller;

use App\Entity\AdminComment;
use App\Entity\Admin\Product;
use App\Form\AdminCommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\Admin\ProductRepository;
use App\Repository\Admin\CategoryRepository;


class HomeController extends AbstractController
{
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
     * @Route("/categories/{id}", name="categories", requirements={"id"="\d+"})
     */
    public function productCategoriesShow(int $id, CategoryRepository $categoryRepository, ProductRepository $productRepository): Response
    {
        $category = $categoryRepository->find($id);
        $categories = $categoryRepository->findAll();

        if (!$category) {
            throw $this->createNotFoundException('The category does not exist');
        }
        $products = $category->getProducts();

        return $this->render('categories.html.twig', [
            'category' => $category,
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/product/{id}", name="product_show", methods={"GET", "POST"})
     */
    public function productshow(Product $product, Request $request, CategoryRepository $categoryRepository): Response
    {
        // Form oluşturma
        $comment = new AdminComment();
        $comment->setCreatedAt(new \DateTimeImmutable()); // Yorumun oluşturulma tarihini ayarlayın
        $commentForm = $this->createForm(AdminCommentType::class, $comment);
        $commentForm->handleRequest($request);

        // Form gönderildiğinde
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment->setProduct($product);
            $comment->setUser($this->getUser()); // Kullanıcıyı ayarlayın (eğer mevcutsa)
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($comment);
            $entityManager->flush();

            $this->addFlash('success', 'Yorum başarıyla eklendi!');
            return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
        }

        // Ürünün yorumlarını al
        $comments = $product->getComments();
        $categories = $categoryRepository->findAll();

        // Ürünün kategorisini al
        $category = $product->getCategory();

        return $this->render('product_show.html.twig', [
            'product' => $product,
            'categories' => $categories,
            'comments' => $comments,
            'comment_form' => $commentForm->createView(),
            'category' => $category, // Kategori değişkenini template'e gönder
        ]);
    }


    /**
     * @Route("/base", name="base")
     */
    public function base(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('base.html.twig', [
            'categories' => $categories,
        ]);
    }

}
