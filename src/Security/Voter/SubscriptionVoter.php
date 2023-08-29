<?php

namespace App\Security\Voter;

use App\Entity\Book;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\InMemoryUser;

class SubscriptionVoter extends Voter
{
    public const EDIT = 'BOOK_EDIT';
    public const VIEW = 'BOOK_VIEW';

    public function __construct(
        private readonly Security $security
    )
    {
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        // replace with your own logic
        // https://symfony.com/doc/current/security/voters.html
        return in_array($attribute, [self::EDIT, self::VIEW])
            && $subject instanceof Book;
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        if ($this->security->isGranted("ROLE_ADMIN")) {
            return true;
        }

        $user = $token->getUser();

        // if the user is anonymous, do not grant access
        if (!$user instanceof InMemoryUser) {
            return false;
        }

        // si l'utilisateur n'est l'utilisateur "user"
        if ($user->getUserIdentifier() != 'user') {
            return false;
        }

        return true;
    }
}
