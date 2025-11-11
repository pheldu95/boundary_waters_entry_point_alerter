<?php
namespace App\Message;

use App\Entity\PermitWatch;
use App\Entity\User;

class ScrapeEntryPointForPermitMessage
{
    public function __construct(
        private PermitWatch $permitWatch
    ) {
    }

    public function getPermitWatch(): PermitWatch
    {
        return $this->permitWatch;
    }
}