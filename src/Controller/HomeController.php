<?php

namespace App\Controller;

use App\Entity\AdminComment;
use App\Entity\Admin\Product;
use App\Form\AdminCommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Repository\Admin\ProductRepository;
use App\Repository\Admin\CategoryRepository;
use App\Repository\RatingRepository;
use App\Entity\Rating;
use Doctrine\ORM\EntityManagerInterface;

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
    public function productShow(Product $product, Request $request, CategoryRepository $categoryRepository, RatingRepository $ratingRepository, EntityManagerInterface $entityManager): Response
    {
        // Form oluşturma
        $comment = new AdminComment();
        $comment->setCreatedAt(new \DateTimeImmutable()); // Yorumun oluşturulma tarihini ayarlayın
        $commentForm = $this->createForm(AdminCommentType::class, $comment);
        $commentForm->handleRequest($request);
        $member = $this->getUser();
        $currentRating = null;

        // Form gönderildiğinde
        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment->setProduct($product);
            $comment->setMember($member); // Kullanıcıyı ayarlayın (eğer mevcutsa)
            $entityManager->persist($comment);
            $entityManager->flush();

            if ($request->isXmlHttpRequest()) {
                return new JsonResponse([
                    'success' => true,
                    'comment' => [
                        'member' => [
                            'name' => $comment->getMember()->getName(),
                            'surname' => $comment->getMember()->getSurname(),
                        ],
                        'comment' => $comment->getComment(),
                    ],
                ]);
            }

            $this->addFlash('success', 'Yorum başarıyla eklendi!');
            return $this->redirectToRoute('product_show', ['id' => $product->getId()]);
        }

        if ($member) {
            $rating = $ratingRepository->findOneBy([
                'product' => $product,
                'member' => $member
            ]);
            $currentRating = $rating ? $rating->getRating() : null;
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
            'current_rating' => $currentRating,
        ]);
    }

    /**
     * @Route("/rating/submit", name="rating_submit", methods={"POST"})
     */
    public function submitRating(Request $request, RatingRepository $ratingRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $productId = $request->request->get('product_id');
        $ratingValue = $request->request->get('rating');
        $member = $this->getUser();

        if ($productId && $ratingValue && $member) {
            $product = $entityManager->getRepository(Product::class)->find($productId);
            if ($product) {
                $rating = $ratingRepository->findOneBy([
                    'product' => $product,
                    'member' => $member,
                ]) ?? new Rating();

                $rating->setProduct($product);
                $rating->setMember($member);
                $rating->setRating($ratingValue);

                $entityManager->persist($rating);
                $entityManager->flush();

                return new JsonResponse(['success' => true]);
            }
        }

        return new JsonResponse(['success' => false]);
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

// Diğer use ifadeleri

    public function addComment(Request $request, Product $product, EntityManagerInterface $em): Response
    {
        $comment = new Comment();
        $commentForm = $this->createForm(CommentType::class, $comment);
        $commentForm->handleRequest($request);

        if ($commentForm->isSubmitted() && $commentForm->isValid()) {
            $comment->setProduct($product);
            $comment->setMember($this->getUser()); // Giriş yapan kullanıcıyı ayarlayın
            $em->persist($comment);
            $em->flush();

            return new JsonResponse([
                'success' => true,
                'comment' => [
                    'member' => [
                        'name' => $this->getUser()->getName(),
                        'surname' => $this->getUser()->getSurname(),
                    ],
                    'comment' => $comment->getComment(),
                ],
            ]);
        }

        return new JsonResponse(['success' => false]);
    }

}
