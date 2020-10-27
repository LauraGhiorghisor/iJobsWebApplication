<?php
require 'Jjobs/Controllers/Login.php';

class LoginTest extends \PHPUnit\Framework\TestCase
{
    private $controller;
    private $authentication;

    public function setUp()
    {
        $this->pdo = new \PDO('mysql:host=v.je;dbname=job', 'student', 'student');
    }
    public function testNull()
    {
        $data = [
            'user' => [
                'username' => '',
                'password' => ''
            ]
        ];
        $error = 1;
        $this->controller = new \Jjobs\Controllers\Login(null, null, [], $data['user']);

        $errors = $this->controller->validateLogin($data['user'], $error);
        $this->assertEquals(count($errors), 3);
    }

    public function test2aNull()
    {
        $data = [
            'user' => [
                'username' => 'user',
                'password' => ''
            ]
        ];
        $error = 1;
        $this->controller = new \Jjobs\Controllers\Login(null, null, [], $data['user']);

        $errors = $this->controller->validateLogin($data['user'], $error);
        $this->assertEquals(count($errors), 2);
    }

    public function test2bNull()
    {
        $data = [
            'user' => [
                'username' => '',
                'password' => 'pass'
            ]
        ];
        $error = 1;
        $this->controller = new \Jjobs\Controllers\Login(null, null, [], $data['user']);

        $errors = $this->controller->validateLogin($data['user'], $error);
        $this->assertEquals(count($errors), 2);
    }


    public function test2cNull()
    {
        $data = [
            'user' => [
                'username' => '',
                'password' => ''
            ]
        ];
        $error = 0;
        $this->controller = new \Jjobs\Controllers\Login(null, null, [], $data['user']);

        $errors = $this->controller->validateLogin($data['user'], $error);
        $this->assertEquals(count($errors), 2);
    }


    public function test1aNull()
    {
        $data = [
            'user' => [
                'username' => 'user',
                'password' => ''
            ]
        ];
        $error = 0;
        $this->controller = new \Jjobs\Controllers\Login(null, null, [], $data['user']);

        $errors = $this->controller->validateLogin($data['user'], $error);
        $this->assertEquals(count($errors), 1);
    }
    public function test1bNull()
    {
        $data = [
            'user' => [
                'username' => '',
                'password' => 'pass'
            ]
        ];
        $error = 0;
        $this->controller = new \Jjobs\Controllers\Login(null, null, [], $data['user']);

        $errors = $this->controller->validateLogin($data['user'], $error);
        $this->assertEquals(count($errors), 1);
    }

    public function test1cNull()
    {
        $data = [
            'user' => [
                'username' => 'user',
                'password' => 'pass'
            ]
        ];
        $error = 1;
        $this->controller = new \Jjobs\Controllers\Login(null, null, [], $data['user']);

        $errors = $this->controller->validateLogin($data['user'], $error);
        $this->assertEquals(count($errors), 1);
    }


    public function testOK()
    {
        $data = [
            'user' => [
                'username' => 'user',
                'password' => 'pass'
            ]
        ];
        $error = 0;
        $this->controller = new \Jjobs\Controllers\Login(null, null, [], $data['user']);

        $errors = $this->controller->validateLogin($data['user'], $error);
        $this->assertEquals(count($errors), 0);
    }
}
