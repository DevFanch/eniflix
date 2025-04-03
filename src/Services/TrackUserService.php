<?php

namespace App\Services;

use Psr\Log\LoggerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class TrackUserService
{
    public function __construct(private LoggerInterface $logger) {}

    public function addLogWhenRegister(UserInterface $user)
    {
        // Record user in file
        file_put_contents('log.txt', 'User ' . $user->getUserIdentifier() . ' registered at ' . date('Y-m-d H:i:s').'\n', FILE_APPEND);
        // Record user in server Log
        $this->logger->info('User ' . $user->getUserIdentifier() . ' registered at ' . date('Y-m-d H:i:s'));
    }
}