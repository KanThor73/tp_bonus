<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\SousCategories;
use App\Form\CategoriesType;
use App\Form\SousCategoriesType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategorieController extends AbstractController
{
    #[Route('/categorie', name: 'create_categorie')]
    public function createCategorie( Request $request, EntityManagerInterface $entityManager): Response
    {
        $categorie = new Categories();

        $categorieForm = $this->createForm(CategoriesType::class, $categorie);


        $categorieRepo = $entityManager->getRepository(Categories::class);
        $categories = $categorieRepo->findAll();


        $categorieForm->handleRequest($request);

        if ($categorieForm->isSubmitted() && $categorieForm->isValid()) {
            $entityManager->getEventManager();
            $entityManager->persist($categorie);
            $entityManager->flush();
            return $this->redirectToRoute('create_categorie');
        }
        return $this->render('categorie/index.html.twig', [
            'form' => $categorieForm->createView(),
            'categories' => $categories,
        ]);
    }

    #[Route('/sous-categorie/{id}', name: 'create_sous-categorie')]
    public function createSousCategorie(Categories $categorie, Request $request, EntityManagerInterface $entityManager): Response
    {
        $sousCategorie = new SousCategories();


        $sousCategoriesForm = $this->createForm(SousCategoriesType::class, $sousCategorie);
        $categorieRepo = $entityManager->getRepository(Categories::class);

        $sousCategories = $categorie->

        // faire une requete pour n'afficher que les souscat de la cat selec

        $sousCategoriesForm->handleRequest($request);

        if ($sousCategoriesForm->isSubmitted() && $sousCategoriesForm->isValid()) {
            $entityManager->persist($sousCategorie);
            $entityManager->flush();
        }
        return $this->render('categorie/sous-categorie.html.twig', [
            'sousCatForm' => $sousCategoriesForm->createView(),
            'sousCategories' => $sousCategories
        ]);
    }
}
