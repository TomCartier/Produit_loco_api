<?php

namespace App\Controller;

use App\Form\LoginFormType;
use App\Repository\UserRepository;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    private $logger;
    private $passwordHasher;

    public function __construct(LoggerInterface $logger, UserPasswordHasherInterface $passwordHasher)
    {
        $this->logger = $logger;
        $this->passwordHasher = $passwordHasher;
    }

    #[Route('/login', name: 'app_login', methods: ['GET', 'POST'])]
    public function login(Request $request, AuthenticationUtils $authenticationUtils, UserRepository $userRepository): Response
    {
        // Crée le formulaire de connexion
        $form = $this->createForm(LoginFormType::class);
        $form->handleRequest($request);

        // Vérifie si le formulaire a été soumis
        if ($form->isSubmitted() && $form->isValid()) {
            $username = $form->get('_username')->getData();
            $password = $form->get('_password')->getData();

            $user = $userRepository->findOneByEmail($username);
            if (!$user) {
                $this->logger->info('Utilisateur non trouvé', ['username' => $username]);
                return $this->json(['error' => 'Utilisateur non trouvé'], Response::HTTP_UNAUTHORIZED);
            }

            if ($this->passwordHasher->isPasswordValid($user, $password)) {
                $this->logger->info('Connexion réussie', ['username' => $username]);
                // Retourne toutes les informations de l'utilisateur sauf le mot de passe
                // $userData = [
                //     'id' => $user->getId(),
                //     'email' => $user->getEmail(),
                //     'lastname' => $user->getLastname(),
                //     'firstname' => $user->getFirstname(),
                //     // Ajoutez d'autres champs selon les besoins
                // ];
                return $this->json(['user' => $user->toArray()]);
            } else {
                $this->logger->info('Mot de passe incorrect', ['username' => $username]);
                return $this->json(['error' => 'Mot de passe incorrect'], Response::HTTP_UNAUTHORIZED);
            }
        }

        // Affiche le formulaire de connexion si aucune donnée n'a été soumise
        return $this->render('security/login.html.twig', [
            'loginForm' => $form->createView(),
            'error' => $authenticationUtils->getLastAuthenticationError(),
            'last_username' => $authenticationUtils->getLastUsername(),
        ]);
    }

    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Le contrôleur peut être vide: il ne sera jamais exécuté!
        throw new \Exception('Don\'t forget to activate logout in security.yaml');
    }
}
