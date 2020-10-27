<?php
require 'Jjobs/Controllers/User.php';
require 'CSY2028/DatabaseTable.php';

class RegistrationTest extends \PHPUnit\Framework\TestCase
{
    private $controller;
    private $usersTable;
    private $pdo;

    public function setUp()
    {
        $this->pdo = new \PDO('mysql:host=v.je;dbname=job', 'student', 'student');
        $this->usersTable = new \CSY2028\DatabaseTable($this->pdo, 'users', 'id');
    }
    public function testBothNull()
    {
        $data = [
            'user' => [
                'username' => '',
                'password' => '',
            ]
        ];
        $this->controller = new \Jjobs\Controllers\User(null, $this->usersTable, null, [], $data['user']);
        $errors = $this->controller->validateRegistration($data['user']);
        $this->assertEquals(count($errors), 2);
    }

    public function testUsernameNull()
    {
        $data = [
            'user' => [
                'username' => '',
                'password' => 'pas',
            ]
        ];
        $this->controller = new \Jjobs\Controllers\User(null, $this->usersTable, null, [], $data['user']);
        $errors = $this->controller->validateRegistration($data['user']);
        $this->assertEquals(count($errors), 1);
    }

    public function testPassNull()
    {
        $data = [
            'user' => [
                'username' => '123',
                'password' => '',
            ]
        ];
        $this->controller = new \Jjobs\Controllers\User(null, $this->usersTable, null, [], $data['user']);
        $errors = $this->controller->validateRegistration($data['user']);
        $this->assertEquals(count($errors), 1);
    }
    public function testUserTaken()
    {
        $data = [
            'user' => [
                'username' => 'admin',
                'password' => 'pas',
            ]
        ];
        $this->controller = new \Jjobs\Controllers\User(null, $this->usersTable, null, [], $data['user']);
        $errors = $this->controller->validateRegistration($data['user']);
        $this->assertEquals(count($errors), 1);
    }

    public function testBothOK()
    {
        $data = [
            'user' => [
                'username' => '444',
                'password' => '444',
            ]
        ];
        $this->controller = new \Jjobs\Controllers\User(null, $this->usersTable, null, [], $data['user']);
        $errors = $this->controller->validateRegistration($data['user']);
        $this->assertEquals(count($errors), 0);
    }
}
