<?php

namespace App\Controller;

use App\Form\UsuarioType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PerfilController extends AbstractController
{
    #[Route('/perfil', name: 'app_perfil')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response
    {
        $user = $this->getUser();

        // Clonamos el usuario para comparar luego
        $originalData = clone $user;
        
        $form = $this->createForm(UsuarioType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (
                $user->getNombre() !== $originalData->getNombre() ||
                $user->getApellido() !== $originalData->getApellido() ||
                $user->getEmail() !== $originalData->getEmail()
            ) {
                $entityManager->persist($user);
                $entityManager->flush();
                $this->addFlash('success', 'Perfil actualizado con éxito.');
            }
            return $this->redirectToRoute('app_perfil');
        }

        return $this->render('perfil/index.html.twig', [
            'registrationForm' => $form,
        ]);
    }
}
