<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class SendEmail
{

    public function __construct(
        private readonly MailerInterface $mailer,
        private readonly RandomMessage $randomMessage,
        private readonly string $receiver
    ){}

    public function send(): string
    {
        // récupérer le message
        $message = $this->randomMessage->getMessage();

        // construire l'email
        $email = (new TemplatedEmail())
            ->from('noreply@dawan.fr')
            ->to(new Address($this->receiver))
            ->subject("Formation Symfony: Les services")
            ->textTemplate('email/message.txt.twig')
            ->context(['message' => $message]);

        // envoyer l'email
        $this->mailer->send($email);

        return $message;
    }

}
