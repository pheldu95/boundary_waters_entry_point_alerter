<?php
declare(strict_types=1);
namespace App\Services;

use App\Entity\PermitWatch;
use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mime\Address;

class SendPermitAlertEmail
{
    public function __construct(
        private MailerInterface $mailer, 
        private ?LoggerInterface $logger = null
    )
    {
        
    }

    /**
     * Send a permit alert email.
     * 
     * @param PermitWatch  $permitWatch
     *
     * @return bool
     */
    public function sendPermitAlert(PermitWatch $permitWatch): bool
    {
        $emailAddress = $permitWatch->getUser()->getEmail();

        $this->logger->info('Sending permit alert email to ' . $emailAddress);

        $email = (new TemplatedEmail())
            ->from(new Address('alert@entry-point-alerter.com', 'Entry Point Alerter'))
            ->to($emailAddress)
            ->subject($permitWatch->getEntryPoint()->getName() . ' Permit Available!')
            ->textTemplate('/email/permit_alert.txt.twig')
            ->context([
                'entryPointName' => $permitWatch->getEntryPoint()->getName(),
                'targetDate' => $permitWatch->getTargetDate()->format('Y-m-d')
            ])
        ;
        
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            if ($this->logger) {
                $this->logger->error('Failed to send permit alert email: ' . $e->getMessage());
            }
            return false;
        }

        $this->logger->info('Sent permit alert email to ' . $emailAddress);
        return true;
    }
}