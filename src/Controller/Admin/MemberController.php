<?php

namespace App\Controller\Admin;

use App\Entity\Member;
use App\Form\MemberType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MemberController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/admin/member/index", name="member_index")
     */
    public function index()
    {
        $members = $this->entityManager->getRepository(Member::class)->findAll();

        return $this->render('admin/member/index.html.twig', [
            'members' => $members,
        ]);
    }
    /**
     * @Route("/admin/member/form", name="member_form")
     */
    public function form(Request $request)
    {
        $members = $this->entityManager->getRepository(Member::class)->findAll();

        // Formu oluştur
        $form = $this->createForm(MemberType::class);
        $form->handleRequest($request);

        // Form verisi ile işleme
        if ($form->isSubmitted() && $form->isValid()) {
            $member = $form->getData();
            $this->entityManager->persist($member);
            $this->entityManager->flush();

            return $this->redirectToRoute('member_form');
        }

        return $this->render('admin/member/form.html.twig', [
            'form' => $form->createView(),
            'members' => $members,
            'csrf_protection'=>false,
        ]);
    }



    /**
     * @Route("/admin/member/edit/{id}", name="member_edit")
     */
    public function edit(Request $request, $id): Response
    {
        echo "Dzenleme Mensüüsü";
        exit();

        $member = $this->entityManager->getRepository(Member::class)->find($id);

        if (!$member) {
            throw $this->createNotFoundException('Üye bulunamadı: ' . $id);
        }

        // Handle edit form submission or display edit form

        // Replace this with your edit logic
        return $this->render('admin/member/form_edit.html.twig', [
            'member' => $member,
        ]);
    }

    /**
     * @Route("/admin/member/delete/{id}", name="member_delete", methods={"POST"})
     */
    public function delete(Request $request, $id): Response
    {
        $member = $this->entityManager->getRepository(Member::class)->find($id);

        if (!$member) {
            throw $this->createNotFoundException('Üye bulunamadı: ' . $id);
        }

        $entityManager = $this->entityManager;
        $entityManager->remove($member);
        $entityManager->flush();

        return $this->redirectToRoute('member_index'); // Redirect to member list page after deletion
    }
}
