<?php

namespace App\Controller;

use App\Entity\Provincia;
use App\Entity\Localidad;
use App\Form\NegocioType;
use App\Repository\LocalidadRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/negocio', name: 'app_negocio')]
final class NegocioController extends AbstractController
{
    #[Route('/', name: '_index')]
    public function index(): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }else{
            $negocios = $this->getUser()->getNegocios();
            return $this->render('negocio/index.html.twig', [
                'negocios' => $negocios,
            ]);
        }
    }

    #[Route('/create', name: '_create')]
    public function create(
        Request $request,
        EntityManagerInterface $entityManager,
        LocalidadRepository $localidadRepository
    ): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        }else{
            $negocioForm = $this->createForm(NegocioType::class);
            
            $negocioForm->handleRequest($request);

            if ($negocioForm->isSubmitted() && $negocioForm->isValid()) {

                $negocio = $negocioForm->getData();
                $negocio->addResponsable($this->getUser());
                $entityManager->persist($negocio);

                $sucursal = $negocioForm->get('sucursal')->getData();
                $sucursal->setNegocio($negocio);
                $entityManager->persist($sucursal);

                $entityManager->flush();

                $this->addFlash('success', 'Negocio y sucursal creados con éxito.');
                return $this->redirectToRoute('app_negocio_index');
            }

            return $this->render('negocio/create.html.twig', [
                'negocioForm' => $negocioForm,
            ]);
        }
    }

    #[Route('/ajax/provincias', name: 'ajax_provincias')]
    public function provinciasPorPais(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $paisId = $request->query->get('pais_id');
        $provincias = $em->getRepository(Provincia::class)
            ->findBy(['pais' => $paisId]);

        $data = [];
        foreach ($provincias as $provincia) {
            $data[] = [
                'id' => $provincia->getId(),
                'nombre' => $provincia->getNombre(),
            ];
        }
        return new JsonResponse($data);
    }

    #[Route('/ajax/localidades', name: 'ajax_localidades')]
    public function localidadesPorProvincia(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $provinciaId = $request->query->get('provincia_id');
        $localidades = $em->getRepository(Localidad::class)
            ->findBy(['provincia' => $provinciaId]);

        $data = [];
        foreach ($localidades as $localidad) {
            $data[] = [
                'id' => $localidad->getId(),
                'nombre' => $localidad->getNombre(),
            ];
        }
        return new JsonResponse($data);
    }
}
