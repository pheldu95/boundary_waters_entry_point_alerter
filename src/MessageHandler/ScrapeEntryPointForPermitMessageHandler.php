<?php
namespace App\MessageHandler;

use App\Message\ScrapeEntryPointForPermitMessage;
use App\Services\SendPermitAlertEmail;
use Psr\Log\LoggerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use App\Services\WebScrapingClient;

#[AsMessageHandler]
class ScrapeEntryPointForPermitMessageHandler
{
    public function __construct(
        private LoggerInterface $logger,
        private SendPermitAlertEmail $sendPermitAlertEmail
    ) {}

    public function __invoke(ScrapeEntryPointForPermitMessage $message)
    {
        $this->logger->info('ScrapeEntryPointForPermitMessage received!');
        $this->logger->info('Message received!', [
            'entryPoint' => $message->getPermitWatch()->getEntryPoint(),
            'timestamp' => date('Y-m-d H:i:s')
        ]);

        //Just to see that it's working
        dump('Handler processing: ' . $message->getPermitWatch()->getEntryPoint()->getName());
        dump('Permit target date: ' . $message->getPermitWatch()->getTargetDate()->format('Y-m-d'));

        //Todo: Use actual permit watch date in the url
        $webScrapingClient = new WebScrapingClient();

        // commenting out for now so we aren't scraping their site too much during testing
        // $result = $webScrapingClient;
        // $result = $webScrapingClient->scrapeJson('https://www.recreation.gov/api/permits/233396/availability/month?start_date=2026-01-01T00:00:00.000Z&commercial_acct=false');

        $this->sendPermitAlertEmail->sendPermitAlert($message->getPermitWatch());
    }
}