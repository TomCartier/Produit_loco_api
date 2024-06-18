<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/produits', name: 'products_')]
class ProductController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(ProductRepository $productRepository): JsonResponse
    {
        $products = $productRepository->findAll();

        $listProducts = [];
        foreach ($products as $product) {
            $listProducts[] = $product->toArray();
        }

        return new JsonResponse([
            'products' => $listProducts
        ]);
    }

    #[Route('/{id}', name: 'detail')]
    public function show($id, ProductRepository $productRepository): Response
    {
        $product = $productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Le produit avec l\'identifiant ' . $id . ' n\'existe pas.');
        }

        return $this->json(['product' => $product->toArray()]);
    }

    #[Route('/{id}/image', name: 'product_image')]
    public function showImage(int $id, ProductRepository $productRepository): Response
    {
        $product = $productRepository->find($id);
        if (!$product) {
            throw $this->createNotFoundException('product not found');
        }

        $picture = $product->getPicture();
        if (!$picture) {
            throw $this->createNotFoundException('Image not found');
        }

        // Convertir le BLOB en chaîne de caractères
        $pictureContent = stream_get_contents($picture);
        if ($pictureContent === false) {
            throw new \RuntimeException('Failed to read image content');
        }

        return new Response($pictureContent, 200, [
            'Content-Type' => 'image/png',
            'Content-Disposition' => 'inline; filename="product_image.png"',
        ]);
    }
}
