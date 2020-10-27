<?php

namespace CSY2028;

class Authentication
{
    private $users;
    private $usernameColumn;
    private $passwordColumn;

    //class constructor
    public function __construct(
        DatabaseTable $users,
        $usernameColumn,
        $passwordColumn
    ) {
        session_start();
        $this->users = $users;
        $this->usernameColumn = $usernameColumn;
        $this->passwordColumn = $passwordColumn;
    }

    //starts session upon log in
    public function login($username, $password)
    {
        $user = $this->users->find(
            $this->usernameColumn,
            strtolower($username)
        );
        if (!empty($user) && password_verify($password, $user[0]->password)) {
            $_SESSION['username'] = $username;
            $_SESSION['password'] = $user[0]->password;
            return true;
        } else {
            return false;
        }
    }

    //verifies if the user is logged in
    public function isLoggedIn()
    {
        if (empty($_SESSION['username'])) {
            return false;
        }

        $user = $this->users->find(
            $this->usernameColumn,
            strtolower($_SESSION['username'])
        )[0];

        if (!empty($user) && $_SESSION['password'] === $user->{$this->passwordColumn}) {
            return true;
        } else {
            return false;
        }
    }

    //returns user record
    public function getUser()
    {
        if ($this->isLoggedIn()) {
            return $this->users->find(
                $this->usernameColumn,
                strtolower($_SESSION['username'])
            )[0];
        } else {
            return false;
        }
    }
}
