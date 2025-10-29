<?php

namespace App\Controller;

use App\Entity\PermitWatch;
use App\Form\PermitWatchType;
use App\Repository\PermitWatchRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PermitWatchController extends AbstractController
{
    #[Route('/permit_watch/new', name: 'app_permit_watch_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $permitWatch = new PermitWatch();
        $form = $this->createForm(PermitWatchType::class, $permitWatch);
        
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Set the current user
            $permitWatch->setUser($this->getUser());
            $permitWatch->setIsActive(true);
            
            $em->persist($permitWatch);
            $em->flush();
            
            $this->addFlash('success', 'Permit watch created successfully!');
            
            return $this->redirectToRoute('app_homepage');
        }
        
        return $this->render('permitWatch/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/permit_watches', name: 'app_my_permit_watches')]
    public function show(PermitWatchRepository $permitWatchRepository): Response
    {
        $user = $this->getUser();
        $permitWatches = $permitWatchRepository->findBy(['user' => $user]);

        return $this->render('permitWatch/permitWatches.html.twig', [
            'permitWatches' => $permitWatches,
        ]);
    }
}