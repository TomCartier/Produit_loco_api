<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserRegistrationFormType;
use App\Repository\RoleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

class RegistrationController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/register', name: 'app_register', methods: ['GET'])]
    public function register(CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        $csrfToken = $csrfTokenManager->getToken('register')->getValue();

        return $this->json(['csrf_token' => $csrfToken]);
    }

    #[Route('/register', name: 'app_register_post', methods: ['POST'])]
    public function registerPost(Request $request, UserPasswordHasherInterface $passwordHasher, RoleRepository $roleRepository, CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        $submittedToken = $request->request->get('_csrf_token');

        if (!$csrfTokenManager->isTokenValid(new CsrfToken('register', $submittedToken))) {
            return $this->json(['error' => 'Invalid CSRF token'], Response::HTTP_FORBIDDEN);
        }

        $form = $this->createForm(UserRegistrationFormType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $form->getData();

            // Hash the password
            $user->setPassword($passwordHasher->hashPassword($user, $user->getPassword()));

            // Set the user role
            $role = $roleRepository->findOneById(1);
            $user->setRole($role);

            // Set the creation date
            $user->setDateCreation(new \DateTime());

            // Persist the user to the database
            $this->entityManager->persist($user);
            $this->entityManager->flush();

            return $this->json(['success' => true]);
        }

        return $this->json(['success' => false]);
    }
}
