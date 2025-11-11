<?php

namespace App\Controller;

use App\Message\ScrapeEntryPointForPermitMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class ScrapeEntryPointForPermitController extends AbstractController
{
    #[Route('/test_messenger', name: 'test_messenger')]
    public function testMessenger(MessageBusInterface $bus): Response
    {
        /** @var User $user */
        $user = $this->getUser();

        $bus->dispatch(new ScrapeEntryPointForPermitMessage($user->getPermitWatches()->last()));

        return new Response('Message dispatched! Check your logs or console. Permit watch entry point: ' . $user->getPermitWatches()->last()->getEntryPoint()->getName());
    }
}