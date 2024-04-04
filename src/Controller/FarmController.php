<?php

namespace App\Controller;

use App\Repository\FarmRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/fermes', name: 'farms_')]
class FarmController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(FarmRepository $farmRepository): JsonResponse
    {
        $farms = $farmRepository->findAll();

        $listFarms = [];
        foreach ($farms as $farm) {
            $listFarms[] = $farm->toArray();
        }

        return new JsonResponse([
            'farms' => $listFarms
        ]);
    }

    #[Route('/{id}', name: 'detail')]
    public function show($id, FarmRepository $farmRepository): Response
    {
        $farm = $farmRepository->find($id);

        if (!$farm) {
            throw $this->createNotFoundException('La ferme avec l\'identifiant ' . $id . ' n\'existe pas.');
        }

        return $this->json(['farm' => $farm->toArray()]);
    }
}
