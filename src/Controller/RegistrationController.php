<?php

namespace App\Controller;

use App\Security\LoginFormAuthenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RegistrationController extends AbstractController
{
    public function register(LoginFormAuthenticator $authenticator, GuardAuthenticatorHandler $guardHandler, Request $request)
    {
        // ...

        // after validating the user and saving them to the database
        // authenticate the user and use onAuthenticationSuccess on the authenticator
        return $guardHandler->authenticateUserAndHandleSuccess(
            $user,          // the User object you just created
            $request,
            $authenticator, // authenticator whose onAuthenticationSuccess you want to use
            'main'          // the name of your firewall in security.yaml
        );
    }

}