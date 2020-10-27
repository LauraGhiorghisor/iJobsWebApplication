<?php
require 'Jjobs/Controllers/Category.php';

class CategoryTest extends \PHPUnit\Framework\TestCase
{
    private $controller;
    private $categoriesTable;
    private $authentication;

    public function setUp()
    {
        $this->pdo = new \PDO('mysql:host=v.je;dbname=job', 'student', 'student');
        $this->categoriesTable = new \CSY2028\DatabaseTable($this->pdo, 'category', 'id');
    }
    public function testNull()
    {
        $data = [
            'category' => [
                'name' => ''
            ]
        ];

        $this->controller = new \Jjobs\Controllers\Category($this->categoriesTable, null, [], $data['category']);

        $errors = $this->controller->validateCategory($data['category']);
        $this->assertEquals(count($errors), 1);
    }

    public function testOK()
    {
        $data = [
            'category' => [
                'name' => 'Test'
            ]
        ];
        $this->controller = new \Jjobs\Controllers\Category($this->categoriesTable, null, [], $data['category']);
        $errors = $this->controller->validateCategory($data['category']);
        $this->assertEquals(count($errors), 0);
    }
}
