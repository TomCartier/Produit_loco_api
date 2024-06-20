<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\CartProduct;
use App\Repository\CartProductRepository;
use App\Repository\ProductRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

#[Route('/cart', name: 'cart_')]
class CartController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/{id}', name: 'cart', methods: ['GET'])]
    public function cart($id, UserRepository $userRepository): JsonResponse
    {
        $user = $userRepository->find($id);

        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $cart = $user->getCart();

        if (!$cart) {
            $cart = new Cart();
            $cart->setUser($user);
            $cart->setDateCreation(new \DateTime());

            $this->entityManager->persist($cart);
            $this->entityManager->flush();
        }

        return new JsonResponse([
            'cart' => $cart->toArray(),
        ]);
    }

    #[Route('/{id}/valide', name: 'valide', methods: ['POST'])]
    public function valide($id, UserRepository $userRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $user = $userRepository->find($id);

        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $cart = $user->getCart();

        if ($cart) {
            foreach ($cart->getCartProducts() as $cartProduct) {
                $entityManager->remove($cartProduct);
            }

            $user->setCart(null);
            $entityManager->remove($cart);
        }

        $entityManager->flush();

        return new JsonResponse([
            'success' => true,
            'message' => 'Cart validated and removed',
        ], Response::HTTP_OK);
    }

    #[Route('/{id}/{idItem}', name: 'item', methods: ['POST'])]
    public function item(int $id, int $idItem, UserRepository $userRepository, ProductRepository $productRepository, Request $request): JsonResponse
    {
        $user = $userRepository->find($id);
        if (!$user) {
            return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $product = $productRepository->find($idItem);
        if (!$product) {
            return new JsonResponse(['error' => 'Product not found'], Response::HTTP_NOT_FOUND);
        }

        $cart = $user->getCart();

        if (!$cart) {
            $cart = new Cart();
            $cart->setUser($user);
            $cart->setDateCreation(new \DateTime());

            $this->entityManager->persist($cart);
            $this->entityManager->flush();
        }

        $data = json_decode($request->getContent(), true);
        $quantity = isset($data['quantity']) ? $data['quantity'] : 1;

        $existingCartProduct = null;
        foreach ($cart->getCartProducts() as $cartProduct) {
            if ($cartProduct->getProduct()->getId() === $product->getId()) {
                $existingCartProduct = $cartProduct;
                break;
            }
        }

        if ($existingCartProduct) {
            $existingCartProduct->setQuantity($existingCartProduct->getQuantity() + $quantity);
        } else {
            $cartProduct = new CartProduct();
            $cartProduct->setProduct($product);
            $cartProduct->setCart($cart);
            $cartProduct->setQuantity($quantity);

            $this->entityManager->persist($cartProduct);
        }

        $this->entityManager->flush();

        return new JsonResponse([
            'success' => true,
            'message' => 'Product added to cart',
        ], Response::HTTP_OK);
    }

    #[Route('/{id}/{idItem}', name: 'update_item', methods: ['PUT'])]
    public function updateItem($id, $idItem, UserRepository $userRepository, ProductRepository $productRepository, CartProductRepository $cartProductRepository, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $user = $userRepository->find($id);
            if (!$user) {
                return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
            }

            $product = $productRepository->find($idItem);
            if (!$product) {
                return new JsonResponse(['error' => 'Product not found'], Response::HTTP_NOT_FOUND);
            }

            $cartProduct = $cartProductRepository->findOneBy(['cart' => $user->getCart(), 'product' => $product]);
            if (!$cartProduct) {
                return new JsonResponse(['error' => 'Product not found in cart'], Response::HTTP_NOT_FOUND);
            }

            $data = json_decode($request->getContent(), true);
            if (isset($data['quantity'])) {
                $cartProduct->setQuantity($data['quantity']);
            }

            $entityManager->flush();

            return new JsonResponse([
                'success' => true,
                'message' => 'Product quantity updated',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/{id}/{idItem}', name: 'delete_item', methods: ['DELETE'])]
    public function deleteItem($id, $idItem, UserRepository $userRepository, ProductRepository $productRepository, CartProductRepository $cartProductRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        try {
            $user = $userRepository->find($id);
            if (!$user) {
                return new JsonResponse(['error' => 'User not found'], Response::HTTP_NOT_FOUND);
            }

            $product = $productRepository->find($idItem);
            if (!$product) {
                return new JsonResponse(['error' => 'Product not found'], Response::HTTP_NOT_FOUND);
            }

            $cartProduct = $cartProductRepository->findOneBy(['cart' => $user->getCart(), 'product' => $product]);
            if (!$cartProduct) {
                return new JsonResponse(['error' => 'Product not found in cart'], Response::HTTP_NOT_FOUND);
            }

            $entityManager->remove($cartProduct);
            $entityManager->flush();

            return new JsonResponse([
                'success' => true,
                'message' => 'Product removed from cart',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return new JsonResponse(['error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
