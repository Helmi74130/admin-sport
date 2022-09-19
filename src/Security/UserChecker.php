<?php

namespace App\Security;

use Symfony\Component\Security\Core\Exception\CustomUserMessageAuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{

    public function checkPreAuth(UserInterface $user)
    {
        if ($user->isIsActive() == false) {
            throw new CustomUserMessageAuthenticationException("Vous n'avez plus accès à votre compte, veuillez contacter un administrateur !");
        }
    }

    public function checkPostAuth(UserInterface $user)
    {

    }
}