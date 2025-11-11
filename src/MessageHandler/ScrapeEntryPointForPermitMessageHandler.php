<?php
namespace App\MessageHandler;

use App\Message\ScrapeEntryPointForPermitMessage;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use WebScrapingClient;

#[AsMessageHandler]
class ScrapeEntryPointForPermitMessageHandler
{
    public function __construct(
        private LoggerInterface $logger
    ) {}

    public function __invoke(ScrapeEntryPointForPermitMessage $message)
    {
        $this->logger->info('ScrapeEntryPointForPermitMessage received!');
        $this->logger->info('Message received!', [
            'user' => $message->getUser()->getEmail(),
            'entryPoint' => $message->getPermitWatch()->getEntryPoint(),
            'timestamp' => date('Y-m-d H:i:s')
        ]);

        //Just to see that it's working
        dump('Handler processing: ' . $message->getPermitWatch()->getEntryPoint()->getName());
        dump('Permit target date: ' . $message->getPermitWatch()->getTargetDate()->format('Y-m-d'));

        //Todo: Use actual permit watch date in the url
        $webScrapingClient = new WebScrapingClient();
        $result = $webScrapingClient;
        $result = $webScrapingClient->scrapeJson('https://www.recreation.gov/api/permits/233396/availability/month?start_date=2026-01-01T00:00:00.000Z&commercial_acct=false');

        // dump($result);
    }
}