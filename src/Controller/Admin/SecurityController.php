<?php
////
////namespace App\Controller\Admin;
////
////use App\Entity\Member;
////use App\Form\MemberType;
////use Symfony\Component\Form\Extension\Core\Type\TextType;
////use Symfony\Component\Form\Extension\Core\Type\PasswordType;
////use App\Repository\Admin\CategoryRepository;
////use App\Repository\Admin\ProductRepository;
////use Doctrine\ORM\EntityManagerInterface;
////use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
////use Symfony\Component\HttpFoundation\Request;
////use Symfony\Component\HttpFoundation\Response;
////use Symfony\Component\Routing\Annotation\Route;
////use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
////
////class SecurityController extends AbstractController
////{
////    private $entityManager;
////
////    public function __construct(EntityManagerInterface $entityManager)
////    {
////        $this->entityManager = $entityManager;
////    }
////
////    /**
////     * @Route("/home", name="home")
////     */
////    public function index(ProductRepository $productRepository, CategoryRepository $categoryRepository): Response
////    {
////        $products = $productRepository->findAll();
////        $categories = $categoryRepository->findAll();
////
////        return $this->render('home/index.html.twig', [
////            'products' => $products,
////            'controller_name' => 'HomeController',
////            'categories' => $categories,
////        ]);
////    }
////
////    /**
////     * @Route("/register", name="member_form")
////     */
////    public function register(Request $request, CategoryRepository $categoryRepository): Response
////    {
////        $member = new Member();
////        $form = $this->createForm(MemberType::class, $member, [
////            'csrf_protection' => true,
////        ]);
////        $form->handleRequest($request);
////        $categories = $categoryRepository->findAll();
////
////        if ($form->isSubmitted() && $form->isValid()) {
////            $this->entityManager->persist($member);
////            $this->entityManager->flush();
////
////            // Kullanıcıyı otomatik olarak giriş yapabilirsiniz
////            return $this->redirectToRoute('app_login');
////        }
////
////        return $this->render('admin/member/form.html.twig', [
////            'form' => $form->createView(),
////            'categories' => $categories,
////        ]);
////    }
////
////    /**
////     * @Route("/login", name="app_login")
////     */
////    public function login(AuthenticationUtils $authenticationUtils, CategoryRepository $categoryRepository): Response
////    {
////        $error = $authenticationUtils->getLastAuthenticationError();
////        $lastUsername = $authenticationUtils->getLastUsername();
////
////        if ($this->getUser()) {
////            return $this->redirectToRoute('home');
////        }
////
////        // Login formu oluştur
////        $form = $this->createFormBuilder()
////            ->add('_username', TextType::class, [
////                'label' => 'Email Adresi',
////                'attr' => ['class' => 'form-control', 'placeholder' => 'Email Adresi']
////            ])
////            ->add('_password', PasswordType::class, [
////                'label' => 'Şifre',
////                'attr' => ['class' => 'form-control', 'placeholder' => 'Şifre']
////            ])
////            ->getForm();
////        $categories = $categoryRepository->findAll();
////        return $this->render('admin/member/login.html.twig', [
////            'form' => $form->createView(),
////            'last_username' => $lastUsername,
////            'error' => $error,
////            'categories' => $categories,
////        ]);
////    }
////}
//namespace App\Controller\Admin;
//
//use App\Entity\Member;
//use App\Form\MemberType;
//use App\Repository\Admin\CategoryRepository;
//use App\Repository\Admin\ProductRepository;
//use Doctrine\ORM\EntityManagerInterface;
//use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Annotation\Route;
//use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
//use Symfony\Component\PasswordHasher\Hasher\PasswordHasherInterface;
//use Symfony\Component\Form\Extension\Core\Type\TextType;
//use Symfony\Component\Form\Extension\Core\Type\PasswordType;
//
//class SecurityController extends AbstractController
//{
//    private $passwordHasher;
//    private $entityManager;
//
//    public function __construct(PasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager)
//    {
//        $this->passwordHasher = $passwordHasher;
//        $this->entityManager = $entityManager;
//    }
//
//    /**
//     * @Route("/home", name="home")
//     */
//    public function index(ProductRepository $productRepository, CategoryRepository $categoryRepository): Response
//    {
//        $products = $productRepository->findAll();
//        $categories = $categoryRepository->findAll();
//
//        return $this->render('home/index.html.twig', [
//            'products' => $products,
//            'controller_name' => 'HomeController',
//            'categories' => $categories,
//        ]);
//    }
//
//    /**
//     * @Route("/register", name="member_form")
//     */
//    public function register(Request $request, CategoryRepository $categoryRepository): Response
//    {
//        $member = new Member();
//        $form = $this->createForm(MemberType::class, $member, [
//            'csrf_protection' => true,
//        ]);
//        $form->handleRequest($request);
//        $categories = $categoryRepository->findAll();
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            // Encode the password here
//            $encodedPassword = $this->passwordHasher->hashPassword($member, $member->getPassword());
//            $member->setPassword($encodedPassword);
//
//            $this->entityManager->persist($member);
//            $this->entityManager->flush();
//
//            return $this->redirectToRoute('app_login');
//        }
//
//        return $this->render('admin/member/register.html.twig', [
//            'form' => $form->createView(),
//            'categories' => $categories,
//        ]);
//    }
//
//    /**
//     * @Route("/login", name="app_login")
//     */
//    public function login(AuthenticationUtils $authenticationUtils, CategoryRepository $categoryRepository): Response
//    {
//        $error = $authenticationUtils->getLastAuthenticationError();
//        $lastUsername = $authenticationUtils->getLastUsername();
//
//        if ($this->getUser()) {
//            return $this->redirectToRoute('home');
//        }
//
//        $form = $this->createFormBuilder()
//            ->add('email', TextType::class, [
//                'label' => 'Email Adresi',
//                'attr' => ['class' => 'form-control', 'placeholder' => 'Email Adresi']
//            ])
//            ->add('password', PasswordType::class, [
//                'label' => 'Şifre',
//                'attr' => ['class' => 'form-control', 'placeholder' => 'Şifre']
//            ])
//            ->getForm();
//
//        $categories = $categoryRepository->findAll();
//
//        return $this->render('admin/member/login.html.twig', [
//            'form' => $form->createView(),
//            'last_username' => $lastUsername,
//            'error' => $error,
//            'categories' => $categories,
//        ]);
//    }
//}


namespace App\Controller\Admin;

use App\Entity\Member;
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
    public function login(AuthenticationUtils $authenticationUtils, CategoryRepository $categoryRepository): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        if ($this->getUser()) {
            return $this->redirectToRoute('home');
        }

        $form = $this->createFormBuilder()
            ->add('_username', TextType::class, [
                'label' => 'Email Adresi',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Email Adresi']
            ])
            ->add('_password', PasswordType::class, [
                'label' => 'Şifre',
                'attr' => ['class' => 'form-control', 'placeholder' => 'Şifre']
            ])
            ->getForm();

        $categories = $categoryRepository->findAll();

        return $this->render('admin/member/login.html.twig', [
            'form' => $form->createView(),
            'last_username' => $lastUsername,
            'error' => $error,
            'categories' => $categories,
        ]);
    }

}
