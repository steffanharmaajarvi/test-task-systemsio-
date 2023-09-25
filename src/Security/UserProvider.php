<?php

namespace App\Security;

use Lexik\Bundle\JWTAuthenticationBundle\Security\User\JWTUserInterface;

/**
 * @method string getUserIdentifier()
 */
final class UserProvider implements JWTUserInterface
{
    private string $username;
    private string $email;
    private array $roles = [];

    public function __construct($username, array $roles, $email)
    {
        $this->username = $username;
        $this->roles = $roles;
        $this->email = $email;
    }

    public static function createFromPayload($username, array $payload)
    {

        return new self(
            $username,
            [], // Added by default
            $payload['username']  // Custom
        );
    }

    public function getRoles()
    {
        return [];
    }

    public function getPassword()
    {
        return '';
    }

    public function getSalt()
    {
        return '';
    }

    public function eraseCredentials()
    {
//        $this->roles = [];
//        $this->email = '';
//        $this->username = '';
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function __call($name, $arguments)
    {

    }
}