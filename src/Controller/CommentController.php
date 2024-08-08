<?php

namespace App\Controller;

use App\Entity\AdminComment;
use App\Form\AdminCommentType;
use App\Repository\Admin\CategoryRepository;
use App\Repository\AdminCommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/comment")
 */
class CommentController extends AbstractController
{
    /**
     * @Route("/", name="comment_index", methods={"GET"})
     */
    public function index(AdminCommentRepository $adminCommentRepository, CategoryRepository $categoryRepository): Response
    {
        $comments = $adminCommentRepository->findAll();
        $categories = $categoryRepository->findAll(); // Kategorileri alın

        return $this->render('comment/index.html.twig', [
            'admin_comments' => $adminCommentRepository->findAll(),
            'categories' => $categories, // Kategorileri şablona ekleyin
            'comments' => $comments,
        ]);
    }

    /**
     * @Route("/new", name="comment_new", methods={"GET", "POST"})
     */
    public function new(Request $request, AdminCommentRepository $adminCommentRepository): Response
    {
        $adminComment = new AdminComment();
        $form = $this->createForm(AdminCommentType::class, $adminComment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adminCommentRepository->add($adminComment, true);

            return $this->redirectToRoute('comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comment/new.html.twig', [
            'admin_comment' => $adminComment,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="comment_show", methods={"GET"})
     */
    public function show(AdminComment $adminComment): Response
    {
        return $this->render('comment/show.html.twig', [
            'admin_comment' => $adminComment,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="comment_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, AdminComment $adminComment, AdminCommentRepository $adminCommentRepository): Response
    {
        $form = $this->createForm(AdminCommentType::class, $adminComment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $adminCommentRepository->add($adminComment, true);

            return $this->redirectToRoute('comment_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('comment/edit.html.twig', [
            'admin_comment' => $adminComment,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="comment_delete", methods={"POST"})
     */
    public function delete(Request $request, AdminComment $adminComment, AdminCommentRepository $adminCommentRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$adminComment->getId(), $request->request->get('_token'))) {
            $adminCommentRepository->remove($adminComment, true);
        }

        return $this->redirectToRoute('comment_index', [], Response::HTTP_SEE_OTHER);

    }
}
