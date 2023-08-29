<?php

namespace App\Service;

use Psr\Log\LoggerInterface;

class RandomMessage
{

    private array $messages = [
        "On n'est heureux que par l'amour.",
        "Il faudrait essayer d'être heureux, ne serait-ce que pour donner l'exemple.",
        "J'ai décidé d'être heureux c'est meilleur pour la santé.",
        "Soyez heureux, tel est le secret du bonheur !",
        "Seul celui qui est heureux peut répandre le bonheur autour de lui."
    ];

    public function __construct(
        private readonly LoggerInterface $logger
    )
    {
    }

    public function getMessage(): string
    {
        $key = array_rand($this->messages);
        $message = $this->messages[$key];

        $this->logger->info(sprintf("La clé choisie est: %s; Le message retourné est: %s", $key, $message));

        return $message;
    }
}
