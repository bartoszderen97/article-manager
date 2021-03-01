<?php

require __DIR__.'/../vendor/autoload.php';
use Delight\Auth\AttemptCancelledException;
use Delight\Auth\Auth;
use Delight\Auth\AuthError;
use Delight\Auth\EmailNotVerifiedException;
use Delight\Auth\InvalidEmailException;
use Delight\Auth\InvalidPasswordException;
use Delight\Auth\NotLoggedInException;
use Delight\Auth\TooManyRequestsException;
use Delight\Auth\UserAlreadyExistsException;

require_once 'DbConnection.php';

class AuthController
{
    private Auth $auth;

    public function __construct()
    {
        $db = new DbConnection();
        $this->auth = new Auth($db->getConnection());
    }

    /**
     * @param string $username
     * @param string $email
     * @param string $password
     */
    public function registerUser(string $username, string $email, string $password)
    {
        try {
            $this->auth->register($email, $password, $username);
        }
        catch (InvalidEmailException $e) {
            die('Invalid email address');
        }
        catch (InvalidPasswordException $e) {
            die('Invalid password');
        }
        catch (UserAlreadyExistsException $e) {
            die('User already exists');
        }
        catch (TooManyRequestsException $e) {
            die('Too many requests');
        }
        catch (AuthError $e) {
            die('Auth error');
        }
    }

    public function loginUser(string $email, string $password)
    {
        try {
            $this->auth->login($email, $password);
        }
        catch (InvalidEmailException $e) {
            die('Wrong email address');
        }
        catch (InvalidPasswordException $e) {
            die('Wrong password');
        }
        catch (EmailNotVerifiedException $e) {
            die('Email not verified');
        }
        catch (TooManyRequestsException $e) {
            die('Too many requests');
        }
        catch (AttemptCancelledException $e) {
            die('Attempt cancelled');
        }
        catch (AuthError $e) {
            die('Auth error');
        }
    }

    public function logoutUser()
    {
        try {
            $this->auth->logOutEverywhere();
        }
        catch (NotLoggedInException $e) {
            die('Not logged in');
        }
        catch (AuthError $e) {
            die('Auth error');
        }
    }

    public function isUserLoggedIn(): bool
    {
        return $this->auth->isLoggedIn();
    }

}