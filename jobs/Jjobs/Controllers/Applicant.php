<?php

namespace Jjobs\Controllers;

class Applicant{
    
private $applicantsTable;
private $authentication;
private $categoriesTable;
private $jobsTable;

// class costructor
 public function __construct(\CSY2028\DatabaseTable $applicantsTable, \CSY2028\Authentication $authentication = null, \CSY2028\DatabaseTable $categoriesTable = null, \CSY2028\DatabaseTable $jobsTable = null, array $get, array $post) {
 $this->applicantsTable = $applicantsTable;
 $this->authentication = $authentication;
 $this->categoriesTable = $categoriesTable;
 $this->jobsTable = $jobsTable;
 $this->get = $get;
 $this->post = $post;
 }

//  checks the validity of the input on the application form; returns an array of error messages.
public function validateApplicant($applicant, $fileError){
  $errorMsg = [];

  if (empty($applicant['name'])){
      $errorMsg [] = 'Please provide a name!';
  }
  if (empty($applicant['email'])){
      $errorMsg [] = 'You must provide an email address!';
  }

  if (empty($applicant['details'])){
      $errorMsg [] = 'Please provide a cover letter!';
}
if ($fileError!==null) {
    if ($fileError!==0)   $errorMsg [] = 'Your CV could not be uploaded!';
  
} else {
    if (empty($_FILES['applicant']['name']['cv'])) { $errorMsg [] = 'You must provide a CV!';
    } 
    else if ($_FILES['applicant']['error']['cv']!=0) {
        $errorMsg [] = 'Your CV could not be uploaded!';
      }
  }
return $errorMsg;

}

// Saves the record containing the applicant's data.
public function applySubmit(){
  $errors = $this->validateApplicant($this->post['applicant'], null);
  if (count($errors) == 0) {
    $parts = explode('.', $_FILES['applicant']['name']['cv']);
    $extension = end($parts);
    $fileName = uniqid() . '.' . $extension;
    move_uploaded_file($_FILES['applicant']['tmp_name']['cv'], 'cvs/' . $fileName);
    $this->post['applicant']['cv'] = $fileName;
    $this->applicantsTable->save($this->post['applicant']);
    header('location: /category/apply/success');
} else {
  return $this->applyForm($errors);
  }
}

// Generates the values needed to be passed to the form template. Returns the template and the values.
public function applyForm($errors = []){
  if  (isset($this->get['id'])) {
   $result = $this->jobsTable->find('id', $this->get['id']);
   $job = $result[0];
  }
  else  {
   $job = false;
  }
  $result = $this->jobsTable->findAll();

$categories = $this->categoriesTable->findAll();
 return ['template' => 'apply.html.php',
  'title' => 'Jo\'s Jobs - Apply',
  'variables' => [
   'job' => $job,
   'errors' => $errors,
   'categories' => $categories
   ]
  ];
 }


// Generates the values needed for the Success page template.
public function applySuccess(){
  $categories = $this->categoriesTable->findAll();
return ['template' => 'applySuccess.html.php',
   'title' => 'Jo\'s Jobs - Success',
   'variables' => [
    'categories' => $categories
    ]
   ];
  }
}
