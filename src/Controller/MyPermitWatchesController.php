<?php

namespace App\Controller;

use App\Repository\PermitWatchRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MyPermitWatchesController extends AbstractController
{
    #[Route('/permit_watches', name: 'app_my_permit_watches')]
    public function show(PermitWatchRepository $permitWatchRepository): Response
    {
        $user = $this->getUser();
        $permitWatches = $permitWatchRepository->findBy(['user' => $user]);

        return $this->render('permitWatch/myPermitWatches.html.twig', [
            'permitWatches' => $permitWatches,
        ]);
    }
}