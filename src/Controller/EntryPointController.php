<?php

namespace App\Controller;

use App\Entity\EntryPoint;
use App\Repository\EntryPointRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EntryPointController extends AbstractController
{
    #[Route('/entry_points', name: 'app_entry_points_list')]
    public function list(EntryPointRepository $entryPointRepository): Response
    {
        $entryPoints = $entryPointRepository->findAll();
        return $this->render('entryPoint/entryPoints.html.twig', [
            'entryPoints' => $entryPoints,
        ]);
    }

    #[Route('/entry-point/{id}', name: 'app_entry_point_show', requirements: ['id' => '[A-Za-z0-9]+'])]
    public function show(int $id, EntryPointRepository $entryPointRepository)
    {
        $entryPoint = $entryPointRepository->findOneBy(['number' => $id]);

        if (!$entryPoint) {
            throw $this->createNotFoundException('Entry Point not found');
        }

        return $this->render('entryPoint/entryPoint.html.twig', [
            'entryPoint' => $entryPoint,
        ]);
    }
}