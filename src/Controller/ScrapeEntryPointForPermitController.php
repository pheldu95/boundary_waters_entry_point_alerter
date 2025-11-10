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
        $bus->dispatch(new ScrapeEntryPointForPermitMessage($this->getUser()->getPermitWatches()->first(), $this->getUser()));

        return new Response('Message dispatched! Check your logs or console. Permit watch entry point: ' . $this->getUser()->getPermitWatches()->first()->getEntryPoint()->getName());
    }
}