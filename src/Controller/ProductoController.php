<?php

namespace App\Controller;

use App\Entity\CategoriaProducto;
use App\Form\ProductoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductoController extends AbstractController
{
    #[Route('/producto', name: 'app_producto_index')]
    public function index(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }
        return $this->render('producto/index.html.twig', [
        ]);
    }

    #[Route('/producto/create', name: 'app_producto_create')]
    public function create(
        EntityManagerInterface $entityManager,
        Request $request
    ): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $categorias = [];
        foreach ($entityManager->getRepository(CategoriaProducto::class)->findAll() as $cat) {
            $categorias[$cat->getNombre()] = $cat->getId();
        }

        $productoForm = $this->createForm(ProductoType::class, null, [
            'categorias' => $categorias,
        ]);

        $productoForm->handleRequest($request);

        if ($productoForm->isSubmitted() && $productoForm->isValid()) {
            
            $producto = $productoForm->getData();

            if ($producto->getCategoria()->getId() === 1) {
                $nombreNuevaCategoria = $productoForm->get('nueva_categoria')->getData();
                $categoria = new CategoriaProducto();
                $categoria->setNombre($nombreNuevaCategoria);
                $entityManager->persist($categoria);
                $entityManager->flush();
                $producto->setCategoria($categoria);
            }

            $entityManager->persist($producto);
            $entityManager->flush();

            $this->addFlash('success', 'Producto creado con éxito.');
            return $this->redirectToRoute('app_producto_index');
        }

        return $this->render('producto/create.html.twig', [
            'productoForm' => $productoForm,
        ]);
    }
}
