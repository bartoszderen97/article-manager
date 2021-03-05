<?php

require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/DbConnection.php';

use Delight\Auth\AttemptCancelledException;
use Delight\Auth\Auth;
use Delight\Auth\AuthError;
use Delight\Auth\EmailNotVerifiedException;
use Delight\Auth\InvalidEmailException;
use Delight\Auth\InvalidPasswordException;
use Delight\Auth\NotLoggedInException;
use Delight\Auth\TooManyRequestsException;
use Delight\Auth\UserAlreadyExistsException;
use Rakit\Validation\Validator;


class AuthController
{
    private Auth $auth;
    public const AUTH_SUCCESS = "OK";
    public function __construct()
    {
        $db = new DbConnection();
        $this->auth = new Auth($db->getConnection());
    }

    /**
     * @param string $username
     * @param string $email
     * @param string $password
     * @return array|string
     */
    public function registerUser(string $username, string $email, string $password)
    {
        $validator = new Validator();
        $validation = $validator->validate($_POST, [
            'username'              => 'required|alpha_num',
            'email'                 => 'required|email',
            'password'              => 'required|min:6',
            'password_confirm'      => 'required|same:password'
        ]);

        if ($validation->fails()) {
            $errors = $validation->errors();
            var_dump($errors->firstOfAll());
            return $errors->firstOfAll();
        }

        try {
            $this->auth->register($email, $password, $username);
            return self::AUTH_SUCCESS;
        }
        catch (InvalidEmailException $e) {
            return 'Invalid email address';
        }
        catch (InvalidPasswordException $e) {
            return 'Invalid password';
        }
        catch (UserAlreadyExistsException $e) {
            return'User already exists';
        }
        catch (TooManyRequestsException $e) {
            return 'Too many requests';
        }
        catch (AuthError $e) {
            return 'Auth error';
        }
    }

    /**
     * @param string $email
     * @param string $password
     * @return array|string
     */
    public function loginUser(string $email, string $password)
    {
        $validator = new Validator();
        $validation = $validator->validate($_POST, [
            'email'                 => 'required|email',
            'password'              => 'required|min:6'
        ]);

        if ($validation->fails()) {
            $errors = $validation->errors();
            return $errors->firstOfAll();
        }

        try {
            $this->auth->login($email, $password);
            return self::AUTH_SUCCESS;
        }
        catch (InvalidEmailException $e) {
            return 'Wrong email address';
        }
        catch (InvalidPasswordException $e) {
            return 'Wrong password';
        }
        catch (EmailNotVerifiedException $e) {
            return 'Email not verified';
        }
        catch (TooManyRequestsException $e) {
            return 'Too many requests';
        }
        catch (AttemptCancelledException $e) {
            return 'Attempt cancelled';
        }
        catch (AuthError $e) {
            return 'Auth error';
        }
    }

    public function logoutUser(): string
    {
        try {
            $this->auth->logOutEverywhere();
            return self::AUTH_SUCCESS;
        }
        catch (NotLoggedInException $e) {
            return 'Not logged in';
        }
        catch (AuthError $e) {
            return 'Auth error';
        }
    }

    public function isUserLoggedIn(): bool
    {
        return $this->auth->isLoggedIn();
    }

}