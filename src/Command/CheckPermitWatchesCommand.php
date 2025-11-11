<?php

namespace App\Command;

use App\Message\ScrapeEntryPointForPermitMessage;
use App\Repository\PermitWatchRepository;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsCommand(
    name: 'app:check-permit-watches',
    description: 'Creates ScrapeEntryPointForPermitMessages for active permit watches.',
)]
class CheckPermitWatchesCommand extends Command
{
    public function __construct(
        private PermitWatchRepository $permitWatchRepository,
        private MessageBusInterface $bus
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {

    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $permitWatches = $this->permitWatchRepository->findAll(['isActive' => true]);

        foreach ($permitWatches as $permitWatch) {
            $this->bus->dispatch(new ScrapeEntryPointForPermitMessage($permitWatch));
            
            $io->info('Dispatching message for PermitWatch ID: ' . $permitWatch->getId());
        }

        $io->success('Finished checking permit watches.');

        return Command::SUCCESS;
    }
}
