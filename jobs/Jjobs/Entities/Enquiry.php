<?php

namespace Jjobs\Entities;

class Enquiry
{

    public $usersTable;

    public $id;
    public $userId;

    public function __construct(\CSY2028\DatabaseTable $usersTable)
    {
        $this->usersTable = $usersTable;
    }
    // returns user value for the given enquiry id (i.e. staff who has completed the enquiry)
    public function getUser()
    {
        return $this->usersTable->find('id', $this->userId)[0];
    }
}
