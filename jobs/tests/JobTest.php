<?php
require 'Jjobs/Controllers/Job.php';

class JobTest extends \PHPUnit\Framework\TestCase
{
    private $controller;
    private $categoriesTable;
    private $applicantsTable;
    private $jobsTable;
    private $pdo;

    public function setUp()
    {
        $this->pdo = new \PDO('mysql:host=v.je;dbname=job', 'student', 'student');
        $this->categoriesTable = new \CSY2028\DatabaseTable($this->pdo, 'category', 'id');
        $this->applicantsTable = new \CSY2028\DatabaseTable($this->pdo, 'applicants', 'id');
        $this->jobsTable = new \CSY2028\DatabaseTable($this->pdo, 'job', 'id', '\Jjobs\Entities\Job', [$this->categoriesTable, $this->applicantsTable]);
    }
    public function testNull()
    {
        $data = [
            'job' => [
                'title' => '',
                'description' => '',
                'salary' => '',
                'location' => '',
                'categoryId' => '',
                'closingDate' => ''
            ]
        ];

        $this->controller = new \Jjobs\Controllers\Job($this->jobsTable, null, null, null, [], $data['job']);

        $errors = $this->controller->validateJob($data['job']);
        $this->assertEquals(count($errors), 6);
    }

    public function test5Null()
    {
        $data = [
            'job' => [
                'title' => 'New Cat',
                'description' => '',
                'salary' => '',
                'location' => '',
                'categoryId' => '',
                'closingDate' => ''
            ]
        ];

        $this->controller = new \Jjobs\Controllers\Job($this->jobsTable, null, null, null, [], $data['job']);

        $errors = $this->controller->validateJob($data['job']);
        $this->assertEquals(count($errors), 5);
    }


    public function test4Null()
    {
        $data = [
            'job' => [
                'title' => 'New Cat',
                'description' => 'New category',
                'salary' => '',
                'location' => '',
                'categoryId' => '',
                'closingDate' => ''
            ]
        ];

        $this->controller = new \Jjobs\Controllers\Job($this->jobsTable, null, null, null, [], $data['job']);

        $errors = $this->controller->validateJob($data['job']);
        $this->assertEquals(count($errors), 4);
    }

    public function test3Null()
    {
        $data = [
            'job' => [
                'title' => 'New Cat',
                'description' => '',
                'salary' => '',
                'location' => 'Northampton',
                'categoryId' => '',
                'closingDate' => '23/03/2030'
            ]
        ];

        $this->controller = new \Jjobs\Controllers\Job($this->jobsTable, null, null, null, [], $data['job']);

        $errors = $this->controller->validateJob($data['job']);
        $this->assertEquals(count($errors), 3);
    }
    public function test2Null()
    {
        $data = [
            'job' => [
                'title' => 'New Cat',
                'description' => '',
                'salary' => '',
                'location' => 'Northampton',
                'categoryId' => '1',
                'closingDate' => '23/03/2030'
            ]
        ];

        $this->controller = new \Jjobs\Controllers\Job($this->jobsTable, null, null, null, [], $data['job']);

        $errors = $this->controller->validateJob($data['job']);
        $this->assertEquals(count($errors), 2);
    }
    public function test1Null()
    {
        $data = [
            'job' => [
                'title' => 'New Cat',
                'description' => '',
                'salary' => '80000',
                'location' => 'Northampton',
                'categoryId' => '1',
                'closingDate' => '23/03/2030'
            ]
        ];

        $this->controller = new \Jjobs\Controllers\Job($this->jobsTable, null, null, null, [], $data['job']);

        $errors = $this->controller->validateJob($data['job']);
        $this->assertEquals(count($errors), 1);
    }
    public function testAllOK()
    {
        $data = [
            'job' => [
                'title' => 'New Cat',
                'description' => 'category',
                'salary' => '80000',
                'location' => 'Northampton',
                'categoryId' => '1',
                'closingDate' => '23/03/2030'
            ]
        ];

        $this->controller = new \Jjobs\Controllers\Job($this->jobsTable, null, null, null, [], $data['job']);

        $errors = $this->controller->validateJob($data['job']);
        $this->assertEquals(count($errors), 0);
    }
}
