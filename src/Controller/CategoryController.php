<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
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
        // $products = $productRepository->findAll();

        $listCategories = [];
        foreach ($categories as $category) {
            $listCategories[] = $category->toArray();
        }

        // $listProducts = [];
        // foreach ($products as $product) {
        //     $listProducts[] = $product->toArray();
        // }

        return new JsonResponse([
            // 'products' => $listProducts,
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
}
