<?php
declare(strict_types=1);
namespace App\Services;

use App\Entity\PermitWatch;
use Psr\Log\LoggerInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;

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

        $email = (new Email())
            ->from('alert@entry-point-alerter.com')
            ->to($emailAddress)
            ->subject($permitWatch->getEntryPoint()->getName() . ' Permit Available!')
            ->text('A permit has become available at ' . $permitWatch->getEntryPoint()->getName() . 
                ' on ' . $permitWatch->getTargetDate()->format('Y-m-d') . '.')
        ;
        
        try {
            $this->mailer->send($email);
        } catch (TransportExceptionInterface $e) {
            if ($this->logger) {
                $this->logger->error('Failed to send permit alert email: ' . $e->getMessage());
            }
            return false;
        }

        return true;
    }
}