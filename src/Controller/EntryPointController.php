<?php

namespace App\Controller;

use App\Entity\EntryPoint;
use App\Repository\EntryPointRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class EntryPointController extends AbstractController
{
    #[Route('/entry_points', name: 'app_entry_points')]
    public function getCollection(EntryPointRepository $entryPointRepository): Response
    {
        $entryPoints = $entryPointRepository->findAll();
        return $this->render('entryPoint/entryPoints.html.twig', [
            'entryPoints' => $entryPoints,
        ]);
    }

    #[Route('/entry_points/{id<\d+>}', name: 'app_entry_point')]
    public function getOne(int $id, EntryPointRepository $entryPointRepository)
    {
        $entryPoint = $entryPointRepository->findOneBy(['number' => $id]);

        return $this->render('entryPoint/entryPoint.html.twig', [
            'entryPoint' => $entryPoint,
        ]);
    }
}