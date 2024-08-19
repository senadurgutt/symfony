<?php

namespace App\Controller\Admin;
use App\Entity\Member;
use App\Form\MemberType;
use App\Repository\MemberRepository;
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
    public function index(MemberRepository $memberRepository)
    {
        $members = $memberRepository->findAll();

        return $this->render('admin/member/index.html.twig', [
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
