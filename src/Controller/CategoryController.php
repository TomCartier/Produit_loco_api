<?php
// src/Controller/CategoryController.php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/categories', name: 'categories_')]
class CategoryController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(ProductRepository $productRepository, CategoryRepository $categoryRepository): JsonResponse
    {
        $categories = $categoryRepository->findAll();

        $listCategories = [];
        foreach ($categories as $category) {
            $listCategories[] = $category->toArray();
        }

        return new JsonResponse([
            'categories' => $listCategories
        ]);
    }

    #[Route('/{id}', name: 'detail')]
    public function show($id, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->find($id);

        if (!$category) {
            throw $this->createNotFoundException('La catégorie avec l\'identifiant ' . $id . ' n\'existe pas.');
        }

        return $this->json(['category' => $category->toArray()]);
    }

    #[Route('/{id}/image', name: 'category_image')]
    public function showImage(int $id, CategoryRepository $categoryRepository): Response
    {
        $category = $categoryRepository->find($id);
        if (!$category) {
            throw $this->createNotFoundException('Category not found');
        }

        $picture = $category->getPicture();
        if (!$picture) {
            throw $this->createNotFoundException('Image not found');
        }

        // Convertir le BLOB en chaîne de caractères
        $pictureContent = stream_get_contents($picture);
        if ($pictureContent === false) {
            throw new \RuntimeException('Failed to read image content');
        }

        return new Response($pictureContent, 200, [
            'Content-Type' => 'image/png', // Changez ceci selon le type de l'image
            'Content-Disposition' => 'inline; filename="category_image.png"',
        ]);
    }
}
