<?php

namespace App\Controller;

use App\Repository\CategorieRepository;
use App\Repository\FarmRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
    public function index(FarmRepository $farmRepository, CategorieRepository $categorieRepository, ProductRepository $productRepository): Response
    {

        $farms = $farmRepository->findAll();
        $categories = $categorieRepository->findAll();
        $products = $productRepository->findAll();

        return $this->render('home/index.html.twig', [
            'farms' => $farms,
            'categories' => $categories,
            'products' => $products,
        ]);
    }
}
