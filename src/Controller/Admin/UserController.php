<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/user')]
class UserController extends AbstractController
{
    #[Route('/', name: 'app_user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        return $this->render('user/index.html.twig', ['users' => $users]);
    }

    #[Route('/edit-roles/{id}', name: 'app_user_update_roles', methods: ['POST'])]
    public function edit_roles(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $submittedToken = $request->getPayload()->getString('_token');
        if (!$this->isCsrfTokenValid('edit_roles' . $user->getId(), $submittedToken)) {
            throw $this->createAccessDeniedException('Invalid CSRF token');
        }

        $roles = $request->request->all('roles');
        $user->setRoles($roles);
        $entityManager->flush();

        return $this->redirectToRoute('app_user_index');
    }
}
