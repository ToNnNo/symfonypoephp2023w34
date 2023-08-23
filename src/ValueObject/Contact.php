<?php

namespace App\ValueObject;

class Contact
{

    public function __construct(
        private readonly string $firstname,
        private readonly string $lastname,
        private readonly string $email,
        private readonly string $phone
    ) {}

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }
}
