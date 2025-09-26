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
        $productos = [];
        $negocios = $this->getUser()->getNegocios();
        foreach ($negocios as $negocio) {
            $sucursales = $negocio->getSucursales();
            foreach ($sucursales as $sucursal) {
                $categorias = $sucursal->getCategoriaProductos();
                foreach ($categorias as $categoria) {
                    $productos = array_merge($productos, $categoria->getProductos()->toArray());
                }
            }
        }
        return $this->render('producto/index.html.twig', [
            'productos' => $productos
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

        $sucursales = [];
        foreach ($this->getUser()->getNegocios() as $negocio) {
            if (count($negocio->getSucursales()) > 1) {
                foreach ($negocio->getSucursales() as $sucursal) {
                    $sucursales[$sucursal->getNombre()] = $sucursal->getId();
                }
            }else {
                $sucursal = $negocio->getSucursales()[0];
            }
        }

        $productoForm = $this->createForm(ProductoType::class, null, [
            'categorias' => $categorias,
            'sucursales' => $sucursales,
        ]);

        $productoForm->handleRequest($request);

        if ($productoForm->isSubmitted() && $productoForm->isValid()) {
            
            $producto = $productoForm->getData();

            if ($producto->getCategoria()->getId() === 1) {
                $nombreNuevaCategoria = $productoForm->get('nueva_categoria')->getData();
                if ($sucursales != []) {
                    $sucursal = $productoForm->get('sucursal')->getData();
                }
                $categoria = new CategoriaProducto();
                $categoria->setNombre($nombreNuevaCategoria);
                $categoria->setSucursal($sucursal);
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

    #[Route('/producto/{id}/edit', name: 'app_producto_edit')]
    public function edit(
        EntityManagerInterface $entityManager,
        Request $request,
        int $id
    ): Response
    {
        return $this->redirectToRoute('app_producto_index'); 
    }

    #[Route('/producto/{id}/delete', name: 'app_producto_delete')]
    public function delete(
        EntityManagerInterface $entityManager,
        int $id
    ): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }

        $producto = $entityManager->getRepository('App\Entity\Producto')->find($id);

        if (!$producto) {
            $this->addFlash('error', 'Producto no encontrado.');
            return $this->redirectToRoute('app_producto_index');
        }

        $entityManager->remove($producto);
        $entityManager->flush();

        $this->addFlash('success', 'Producto eliminado con éxito.');
        return $this->redirectToRoute('app_producto_index');
    }
}
