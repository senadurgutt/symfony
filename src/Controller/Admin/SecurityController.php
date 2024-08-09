<?php
namespace App\Controller\Admin;

use App\Entity\Member;
use App\Form\LoginFormType;
use App\Form\MemberType;
use App\Repository\Admin\CategoryRepository;
use App\Repository\Admin\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class SecurityController extends AbstractController
{
    private $passwordHasher;
    private $entityManager;

    public function __construct(UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager)
    {
        $this->passwordHasher = $passwordHasher;
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/register", name="member_form")
     */
    public function register(Request $request, CategoryRepository $categoryRepository): Response
    {
        $member = new Member();
        $form = $this->createForm(MemberType::class, $member, [
            'csrf_protection' => true,
        ]);
        $form->handleRequest($request);
        $categories = $categoryRepository->findAll();

        if ($form->isSubmitted() && $form->isValid()) {
            $encodedPassword = $this->passwordHasher->hashPassword($member, $member->getPassword());
            $member->setPassword($encodedPassword);

            $this->entityManager->persist($member);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('admin/member/register.html.twig', [
            'form' => $form->createView(),
            'categories' => $categories,
        ]);
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $form = $this->createForm(LoginFormType::class);

        return $this->render('admin/member/login.html.twig', [
            'form' => $form->createView(),
            'last_username' => $authenticationUtils->getLastUsername(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
        ]);
    }


    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}
