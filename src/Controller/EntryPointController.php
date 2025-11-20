<?php

namespace App\Controller;

use App\Entity\EntryPoint;
use App\Repository\EntryPointRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class EntryPointController extends AbstractController
{
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

    #[Route('/entry-points', name: 'app_entry_point_list')]
    public function showList(EntryPointRepository $entryPointRepository): Response
    {
        $entryPoints = $entryPointRepository->findAll();

        return $this->render('entryPoint/entryPointList.html.twig', [
            'entryPoints' => $entryPoints,
        ]);
    }
}
