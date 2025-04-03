<?php

namespace App\Services;

use Psr\Log\LoggerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class TrackUserService
{
    public function __construct(private LoggerInterface $logger, private MailerInterface $mailer) {}

    public function addLogWhenRegister(UserInterface $user)
    {
        // Record user in file
        file_put_contents('log.txt', 'User ' . $user->getUserIdentifier() . ' registered at ' . date('Y-m-d H:i:s').'\n', FILE_APPEND);
        // Record user in server Log
        $this->logger->info('User ' . $user->getUserIdentifier() . ' registered at ' . date('Y-m-d H:i:s'));
    }

    public function alertAdminWhenLogin(UserInterface $user) : void
    {
        $email = (new TemplatedEmail())
            ->from('survey@eniflex.com')
            ->to('robocop@eniflex.com')
            ->subject('Eniflex - Survey')
            ->htmlTemplate('emails/alertAdmin.html.twig')
            ->context([
                'user' => $user,
                'message' => 'User ' . $user->getUserIdentifier() . ' logged in at ' . date('Y-m-d H:i:s'),
            ]);

        $this->mailer->send($email);
    }
}