<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Products;
use App\Form\ProductsType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/product')]
class ProductController extends AbstractController
{
    #[Route('/create', name: 'create')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $product = new Products();

        $productForm = $this->createForm(ProductsType::class, $product);
        $productForm->handleRequest($request);

        $categoriesRepo = $entityManager->getRepository(Categories::class);
        $categories = $categoriesRepo->findAll();

        if ($productForm->isSubmitted() && $productForm->isValid()) {
            $product->setDateAdd(new \DateTime());
            $product->setDateEdit(new \DateTime());

            $idCategorie = $request->get('categories');
            $categorie = $categoriesRepo->find($idCategorie);
            $categorie->addProduct($product);

            $entityManager->persist($product);
            $entityManager->persist($categorie);
            $entityManager->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('product/index.html.twig', [
            'form' => $productForm->createView(),
            'categories' => $categories
        ]);
    }

    #[Route('/edit/{id}', name: 'edit')]
    public function edit(?Products $product, EntityManagerInterface $entityManager, Request $request): Response
    {
        $productForm = $this->createForm(ProductsType::class, $product);

        $categoriesRepo = $entityManager->getRepository(Categories::class);
        $categories = $categoriesRepo->findAll();

        $categorie = $product->getCategorie();
        $idLibelle = $categorie->getId(); // id du produit existant

        $productForm->handleRequest($request);

        if ($productForm->isSubmitted() && $productForm->isValid()) {
            $product->setDateEdit(new \DateTime());

            $idCategorie = $request->get('categories'); //id poste

            if($idCategorie != $idLibelle){
                $categorieNew = $categoriesRepo->find($idCategorie);
                $categorieNew->addProduct($product);
            }

            $entityManager->flush();
            $entityManager->persist($product);
            $entityManager->persist($categorie);
            return $this->redirectToRoute('home');
        }
        return $this->render('product/edit.html.twig', [
            'form' => $productForm->createView(),
            'categories' => $categories,
            'idLibelle' => $idLibelle
        ]);
    }

    #[Route('/delete/{id}', name: 'delete')]
    public function delete(int $id, EntityManagerInterface $entityManager, Request $request): Response
    {
        $product = $entityManager->getRepository(Products::class)->find($id);

        $productForm = $this->createForm(ProductsType::class, $product);

        $productForm->handleRequest($request);

        $product = $entityManager->getRepository(Products::class)->find($id);

        $categories = $product->getCategorie();

        foreach ($categories as $categorie){
        $product->removeCategory($categorie);
        }

        $entityManager->remove($product);
        $entityManager->flush();
        return $this->redirectToRoute('home');
    }

    #[Route('/info/{id}', name: 'info')]
    public function info(int $id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $repo = $entityManager->getRepository(Products::class);
        $product = $repo->find($id);
        $libelle = $product->getCategorie()->getLibelle();


        return $this->render('product/info.html.twig',
            [
                'product' => $product,
                'libelle' => $libelle
            ]);

    }
}
