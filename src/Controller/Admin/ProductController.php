<?php
namespace App\Controller\Admin;

use App\Entity\Admin\Product;
use App\Form\Admin\ProductType;
use App\Repository\Admin\ProductRepository;
use App\Repository\Admin\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('admin/product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="product_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ProductRepository $productRepository, CategoryRepository $categoryRepository): Response
    {
        $product = new Product();
        $catlist = $categoryRepository->findAll();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepository->add($product, true);
            return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/product/new.html.twig', [
            'product' => $product,
            'form' => $form,
            'catlist' => $catlist,
        ]);
    }

    /**
     * @Route("/{id}", name="product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('admin/product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="product_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Product $product, ProductRepository $productRepository, CategoryRepository $categoryRepository): Response
    {
        $catlist = $categoryRepository->findAll();
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepository->add($product, true);
            $this->addFlash('success', 'Kayıt güncelleme başarılı');

            return $this->redirectToRoute('product_edit', ['id' => $product->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/product/edit.html.twig', [
            'product' => $product,
            'catlist' => $catlist,
            'form' => $form,
        ]);
    }
    /**
     * @Route("/imgedit/{id}", name="product_imgedit", methods={"GET", "POST"})
     */
    public function imgedit(Request $request, Product $product, $id, ProductRepository $productRepository): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $productRepository->save($product, true);
            return $this->redirectToRoute('product_imgedit', ['id' => id], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/product/imgedit.html.twig', [
            'product' => $product,
            'form' => $form,
            'id' => $id,
        ]);
    }


    /**
     * @Route("/iupdate/{id}", name="product_iupdate", methods={"POST"})
     */
    public function iupdate(Request $request, Product $product, $id, ProductRepository $productRepository): Response
    {
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);

        /* @var $file File */
        $file = $request->files->get('image');
        $fileName = $this->generateUniqueFileName() . '.' . $file->getExtension();

        try {
            $file->move(
                $this->getParameter('images_directory'), // services.yaml da tanımladım
                $fileName
            );
        } catch (FileException $e) {
            throw new FileException("File upload error");
        }
        $product->setImage($fileName);
        $em = $this->getDoctrine()->getManager();
        $em->persist($product);
        $em->flush();
        return $this->redirectToRoute('product_imgedit', ['id' => $product->getId()]);
    }

    /**
     * @return string
     */
    public function generateUniqueFileName()
    {
        return md5(uniqid());
    }


    /**
     * @Route("/{id}", name="product_delete", methods={"POST"})
     */
    public function delete(Request $request, Product $product, ProductRepository $productRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
            $productRepository->remove($product, true);
        }

        return $this->redirectToRoute('product_index', [], Response::HTTP_SEE_OTHER);
    }


}