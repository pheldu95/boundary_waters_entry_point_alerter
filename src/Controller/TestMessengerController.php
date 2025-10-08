<?php

namespace App\Controller;

use App\Message\TestMessage;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class TestMessengerController extends AbstractController
{
    #[Route('/test-messenger', name: 'test_messenger')]
    public function testMessenger(MessageBusInterface $bus): Response
    {
        $bus->dispatch(new TestMessage('Hello from Messenger!'));
        
        return new Response('Message dispatched! Check your logs or console.');
    }
}