<?php
require 'Jjobs/Controllers/Enquiry.php';

class EnquiryTest extends \PHPUnit\Framework\TestCase
{
    private $controller;
    private $usersTable;
    private $enquiriesTable;
    private $pdo;

    public function setUp()
    {
        $this->pdo = new \PDO('mysql:host=v.je;dbname=job', 'student', 'student');
        $this->usersTable = new \CSY2028\DatabaseTable($this->pdo, 'users', 'id');
        $this->enquiriesTable = new \CSY2028\DatabaseTable($this->pdo, 'enquiries', 'id', '\Jjobs\Entities\Enquiry', [$this->usersTable]);
    }
    public function testNull()
    {
        $data = [
            'enquiry' => [
                'name' => '',
                'address' => '',
                'telephone' => '',
                'text' => ''
            ]
        ];

        $this->controller = new \Jjobs\Controllers\Enquiry($this->enquiriesTable, null, null, [], $data['enquiry']);

        $errors = $this->controller->validateEnquiry($data['enquiry']);
        $this->assertEquals(count($errors), 4);
    }


    public function test3Null()
    {
        $data = [
            'enquiry' => [
                'name' => '',
                'address' => '',
                'telephone' => '',
                'text' => 'text'
            ]
        ];
        $this->controller = new \Jjobs\Controllers\Enquiry($this->enquiriesTable, null, null, [], $data['enquiry']);
        $errors = $this->controller->validateEnquiry($data['enquiry']);
        $this->assertEquals(count($errors), 3);
    }

    public function test2Null()
    {
        $data = [
            'enquiry' => [
                'name' => 'name',
                'address' => 'address',
                'telephone' => '',
                'text' => ''
            ]
        ];
        $this->controller = new \Jjobs\Controllers\Enquiry($this->enquiriesTable, null, null, [], $data['enquiry']);
        $errors = $this->controller->validateEnquiry($data['enquiry']);
        $this->assertEquals(count($errors), 2);
    }
    public function test1Null()
    {
        $data = [
            'enquiry' => [
                'name' => 'name',
                'address' => 'address',
                'telephone' => '1234',
                'text' => ''
            ]
        ];
        $this->controller = new \Jjobs\Controllers\Enquiry($this->enquiriesTable, null, null, [], $data['enquiry']);
        $errors = $this->controller->validateEnquiry($data['enquiry']);
        $this->assertEquals(count($errors), 1);
    }
    public function testOK()
    {
        $data = [
            'enquiry' => [
                'name' => 'name',
                'address' => 'address',
                'telephone' => '1234',
                'text' => 'text'
            ]
        ];
        $this->controller = new \Jjobs\Controllers\Enquiry($this->enquiriesTable, null, null, [], $data['enquiry']);
        $errors = $this->controller->validateEnquiry($data['enquiry']);
        $this->assertEquals(count($errors), 0);
    }
}
