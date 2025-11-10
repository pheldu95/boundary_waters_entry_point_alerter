<?php
namespace App\MessageHandler;

use App\Message\ScrapeEntryPointForPermitMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class ScrapeEntryPointForPermitMessageHandler
{
    public function __construct(
        private LoggerInterface $logger
    ) {}

    public function __invoke(ScrapeEntryPointForPermitMessage $message)
    {
        $this->logger->emergency('ScrapeEntryPointForPermitMessage received!');
        $this->logger->info('Message received!', [
            'user' => $message->getUser()->getEmail(),
            'entryPoint' => $message->getPermitWatch()->getEntryPoint(),
            'timestamp' => date('Y-m-d H:i:s')
        ]);

        //You can also just dump it to see it working
        dump('Handler processing: ' . $message->getPermitWatch()->getEntryPoint()->getName());
    }
}