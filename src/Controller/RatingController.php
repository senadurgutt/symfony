<?php

namespace App\Controller;

use App\Entity\Admin\Product;
use App\Entity\AdminComment;
use App\Entity\Rating;
use App\Repository\Admin\CategoryRepository;
use App\Repository\AdminCommentRepository;
use App\Repository\RatingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/rating")
 */
class RatingController extends AbstractController
{
    /**
     * @Route("/index", name="rating_index", methods={"GET"})
     */
    public function index(AdminCommentRepository $adminCommentRepository,RatingRepository $RatingRepository): Response
    {

        $ratings = $RatingRepository->findAll();

        return $this->render('rating/index.html.twig', [
            'controller_name' => 'RatingController',
            'ratings' => $ratings,
        ]);
    }

    /**
     * @Route("/submit", name="rating_submit", methods={"POST"})
     */
    public function submitRating(Request $request, EntityManagerInterface $entityManager, RatingRepository $ratingRepository): JsonResponse
    {
        $productId = $request->request->get('product_id');
        $ratingValue = $request->request->get('rating');
        $member = $this->getUser();

        if (!$productId || !$ratingValue) {
            return new JsonResponse(['error' => 'Invalid data'], Response::HTTP_BAD_REQUEST);
        }

        $product = $entityManager->getRepository(Product::class)->find($productId);

        if (!$product) {
            return new JsonResponse(['error' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        // Check if the user has already rated this product
        $existingRating = $ratingRepository->findOneBy(['product' => $product, 'member' => $member]);

        if ($existingRating) {
            $existingRating->setRating($ratingValue);
        } else {
            $rating = new Rating();
            $rating->setProduct($product);
            $rating->setMember($member);
            $rating->setRating($ratingValue);
            $entityManager->persist($rating);
        }

        $entityManager->flush();

        return new JsonResponse(['success' => true]);
    }
    /**
     * @Route("/current/{productId}", name="rating_current", methods={"GET"})
     */
    public function getCurrentRating(int $productId, RatingRepository $ratingRepository): JsonResponse
    {
        $member = $this->getUser();

        $rating = $ratingRepository->findOneBy([
            'product' => $productId,
            'member' => $member
        ]);

        if ($rating) {
            return new JsonResponse(['rating' => $rating->getRating()]);
        }

        return new JsonResponse(['rating' => null]);
    }
    /**
     * @Route("/{id}", name="rating_delete", methods={"POST"})
     */
    public function delete(Request $request, Rating $rating, RatingRepository $ratingRepository): Response
    {
        // CSRF koruması - token doğrulaması
        if ($this->isCsrfTokenValid('delete'.$rating->getId(), $request->request->get('_token'))) {
            // Rating entity'sini silme
            $ratingRepository->remove($rating, true);
        }

        // Silme işlemi tamamlandıktan sonra yönlendirme
        return $this->redirectToRoute('rating_index', [], Response::HTTP_SEE_OTHER);
    }
}
