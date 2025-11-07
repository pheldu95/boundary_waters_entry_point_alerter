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

            return $this->redirectToRoute('app_my_permit_watches');
        }

        return $this->render('permitWatch/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/permit_watches', name: 'app_my_permit_watches')]
    public function show(PermitWatchRepository $permitWatchRepository): Response
    {
        $user = $this->getUser();
        $permitWatches = $permitWatchRepository->findBy(
            ['user' => $user],
            ['targetDate' => 'ASC', 'createdAt' => 'DESC']
        );

        return $this->render('permitWatch/permitWatches.html.twig', [
            'permitWatches' => $permitWatches,
        ]);
    }

    #[Route('/permit_watch/delete/{id}', name: 'app_permit_watch_delete')]
    public function delete(Request $request, PermitWatch $permitWatch, EntityManagerInterface $em): Response
    {
        if (!$this->isCsrfTokenValid('delete' . $permitWatch->getId(), $request->request->get('_token'))) {
            throw $this->createAccessDeniedException('Invalid CSRF token.');
        }

        //Ensure the permit watch belongs to the current user
        if ($permitWatch->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException('You do not have permission to delete this permit watch.');
        }

        $em->remove($permitWatch);
        $em->flush();

        $this->addFlash('success', 'Permit watch deleted successfully!');

        return $this->redirectToRoute('app_my_permit_watches');
    }
}
