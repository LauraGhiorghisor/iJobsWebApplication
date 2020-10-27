<?php
require 'Jjobs/Controllers/Applicant.php';

class ApplicantTest extends \PHPUnit\Framework\TestCase
{
    private $controller;
    private $applicantsTable;
    private $pdo;

    public function setUp()
    {
        $this->pdo = new \PDO('mysql:host=v.je;dbname=job', 'student', 'student');
        $this->applicantsTable = new \CSY2028\DatabaseTable($this->pdo, 'applicants', 'id');
    }
    public function testNull()
    {
        $data = [
            'applicant' => [
                'name' => '',
                'email' => '',
                'details' => ''
            ]
        ];
        $fileError = 1;

        $this->controller = new \Jjobs\Controllers\Applicant($this->applicantsTable, null, null, null, [], $data['applicant']);

        $errors = $this->controller->validateApplicant($data['applicant'], $fileError);
        $this->assertEquals(count($errors), 4);
    }

    public function test3Null()
    {
        $data = [
            'applicant' => [
                'name' => '',
                'email' => '',
                'details' => ''
            ]
        ];
        $fileError = 0;

        $this->controller = new \Jjobs\Controllers\Applicant($this->applicantsTable, null, null, null, [], $data['applicant']);

        $errors = $this->controller->validateApplicant($data['applicant'], $fileError);
        $this->assertEquals(count($errors), 3);
    }



    public function test2Null()
    {
        $data = [
            'applicant' => [
                'name' => 'name',
                'email' => '',
                'details' => ''
            ]
        ];
        $fileError = 0;

        $this->controller = new \Jjobs\Controllers\Applicant($this->applicantsTable, null, null, null, [], $data['applicant']);

        $errors = $this->controller->validateApplicant($data['applicant'], $fileError);
        $this->assertEquals(count($errors), 2);
    }

    public function test1Null()
    {
        $data = [
            'applicant' => [
                'name' => '',
                'email' => 'email',
                'details' => 'details'
            ]
        ];
        $fileError = 0;

        $this->controller = new \Jjobs\Controllers\Applicant($this->applicantsTable, null, null, null, [], $data['applicant']);
        $errors = $this->controller->validateApplicant($data['applicant'], $fileError);
        $this->assertEquals(count($errors), 1);
    }

    public function testOK()
    {
        $data = [
            'applicant' => [
                'name' => 'name',
                'email' => 'email',
                'details' => 'details'
            ]
        ];
        $fileError = 0;

        $this->controller = new \Jjobs\Controllers\Applicant($this->applicantsTable, null, null, null, [], $data['applicant']);
        $errors = $this->controller->validateApplicant($data['applicant'], $fileError);
        $this->assertEquals(count($errors), 0);
    }
}
