<?php
namespace App\MessageHandler;

use App\Message\TestMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class TestMessageHandler
{
    public function __construct(
        private LoggerInterface $logger
    ) {}

    public function __invoke(TestMessage $message)
    {
        $this->logger->info('TestMessage received!', [
            'content' => $message->getContent(),
            'timestamp' => date('Y-m-d H:i:s')
        ]);

        // You can also just dump it to see it working
        dump('Handler processing: ' . $message->getContent());
    }
}