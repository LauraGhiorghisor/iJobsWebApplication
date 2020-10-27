<?php

namespace Jjobs\Entities;

class Job
{

    public $categoriesTable;
    public $applicantsTable;

    public $id;
    public $title;
    public $description;
    public $salary;
    public $closingDate;
    public $categoryID;
    public $location;

    public function __construct(\CSY2028\DatabaseTable $categoriesTable, \CSY2028\DatabaseTable $applicantsTable)
    {
        $this->categoriesTable = $categoriesTable;
        $this->applicantsTable = $applicantsTable;
    }

    // Returns the categpry corresponding to the given id.
    public function getCategory()
    {
        return $this->categoriesTable->find('id', $this->categoryId)[0];
    }


    // Returns the applicants for the given job.
    public function getApplicants()
    {
        return $this->applicantsTable->find('jobId', $this->id);
    }
}
