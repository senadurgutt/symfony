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
     * @Route("/register", name="member_form")
     */
    public function form(Request $request): Response
    {
        $members = $this->entityManager->getRepository(Member::class)->findAll();

        $member = new Member();
        // Formu oluştur
        $form = $this->createForm(MemberType::class, $member, [
            'csrf_protection' => false,
        ]);
        $form->handleRequest($request);

        // Form verisi ile işleme
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($member);
            $this->entityManager->flush();

            return $this->redirectToRoute('member_index');
        }

        return $this->render('admin/member/form.html.twig', [
            'form' => $form->createView(),
            'members' => $members,
        ]);
    }

    /**
     * @Route("/admin/member/delete/{id}", name="member_delete")
     */
    public function delete(Request $request, $id): Response
    {

        $member = $this->entityManager->getRepository(Member::class)->find($id);

        $entityManager = $this->entityManager;
        $entityManager->remove($member);
        $entityManager->flush();

        return $this->redirectToRoute('member_index'); // Redirect to member list page after deletion

 }
}
