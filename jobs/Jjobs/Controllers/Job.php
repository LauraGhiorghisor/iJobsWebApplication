<?php
namespace Jjobs\Controllers;
class Job {
    
 private $jobsTable;
 private $categoriesTable;
 private $usersTable;
 private $authentication;

//  class constructor
 public function __construct(\CSY2028\DatabaseTable $jobsTable, \CSY2028\DatabaseTable $categoriesTable = null, \CSY2028\DatabaseTable $usersTable = null, \CSY2028\Authentication $authentication = null, array $get, array $post) {
 $this->jobsTable = $jobsTable;
 $this->categoriesTable = $categoriesTable;
 $this->usersTable = $usersTable;
 $this->authentication = $authentication;
 $this->get = $get;
 $this->post = $post;
 }

//  Returns values and template for the Jobs page on the user-side (under Jobs menu)
 public function list() {
	$date = new \DateTime();
	$date1 = $date->format('Y-m-d');
	$categories = $this->categoriesTable->findAll();
	if ($this->get['id'] == 0) {
		$jobs = $this->jobsTable->findAll();
		$title = 'All Jobs';
	} else {
		$jobs = $this->jobsTable->find_3_cond('categoryId', $this->get['id'], 'archived_status', 'No' , 'closingDate', $date1);
		$title = $this->categoriesTable->find('id', $this->get['id'])[0]->name. ' Jobs' ;
	}

	$jobs_locations = $this->jobsTable->selectDistinct('location');
	return ['template' => 'list.html.php',
	'title' => 'Jo\'s Jobs - '.$title,
	'variables' => [
		'jobs' => $jobs ?? null,
		'categories' => $categories,
		'jobs_locations' => $jobs_locations,
		]
	];
 }

// Returns the user Jobs page, filtered by location.
public function filteredList(){
	$date = new \DateTime();
	$date1 = $date->format('Y-m-d');
	$categories = $this->categoriesTable->findAll();

	if ($this->post['selected_location']== '0')  $this->post['selected_location'] = '%';
    $jobs_locations = $this->jobsTable->selectDistinct('location');
    $jobs = $this->jobsTable->find_3_cond('location', $this->post['selected_location'], 'archived_status', 'No' , 'closingDate', $date1);

	if ($jobs) {
		$title =  $jobs[0]->getCategory()->name .' Jobs';
	} else   {
		$title = 'No jobs yet!';
	}
	return ['template' => 'list.html.php',
	'title' => 'Jo\'s Jobs - '.$title,
	'variables' => [
		'jobs' => $jobs ?? null,
		'categories' => $categories,
		'jobs_locations' => $jobs_locations,
		]
	];
}

// Returns the values and template for the Admin Jobs page
 public function adminJobList(){
	$jobs_locations = $this->jobsTable->selectDistinct('location');
	$categories = $this->categoriesTable->findAll();
	$user = $this->authentication->getUser();

	if ($user->access >= 1) $jobs = $this->jobsTable->findAll();
		else $jobs = $this->jobsTable->find('userId', $user->id);

	 return ['template' => 'jobs.html.php',
	 'title' => 'Jo\'s Jobs - Job List',
	 'variables' => [
		'jobs' => $jobs,
		'jobs_locations' => $jobs_locations,
		'categories' => $categories,
		'userId' => $user->id ?? null,
		'access' => $user->access ?? null
		]
	 ];

 }

// Returns the values and template for the Admin Jobs page, filtered by location and/or category
 public function adminFilteredJobList(){
	 if ($this->post['selected_category'] == '0')  $this->post['selected_category'] = '%';
	 if ($this->post['selected_location']== '0')  $this->post['selected_location'] = '%';
	$jobs_locations = $this->jobsTable->selectDistinct('location');
	$user = $this->authentication->getUser();
	$jobs = $this->jobsTable->find_2_cond('categoryId', $this->post['selected_category'], 'location', $this->post['selected_location']);
	$categories = $this->categoriesTable->findAll();
	
	 return ['template' => 'jobs.html.php',
	 'title' => 'Jo\'s Jobs - Job List',
	 'variables' => [
		'jobs' => $jobs,
		'jobs_locations' => $jobs_locations,
		'categories' => $categories,
		'access' => $user->access ?? null,
		'userId' => $user->id ?? null
		
		]
	 ];

 }

// Validates the input on the Add/edit job form
public function validateJob($job){
	$errorMsg = [];
  
	if (empty($job['title'])){
		$errorMsg [] = 'Please provide a title!';
	}
	if (empty($job['description'])){
		$errorMsg [] = 'Please provide a description!';
	}
  
	if (empty($job['salary'])){
		$errorMsg [] = 'Please provide a salary!';
  }
	if (empty($job['location'])){
		$errorMsg [] = 'Please provide a location!';
  }
  if (empty($job['categoryId'])){
	$errorMsg [] = 'Please provide a category!';
	}
	if (empty($job['closingDate'])){
		$errorMsg [] = 'Please provide a close date!';
	}
  return $errorMsg;

}

// Saves the job record to the database.
 public function editSubmit(){

	if (isset($this->get['id'])){
		$user = $this->authentication->getUser();

		if ($user->id !=$this->jobsTable->find('id', $this->get['id'])[0]->userId) {	
			header('location: /admin/jobs');
			return;
		}
	}
	  $job = $this->post['job'];
	  $errors = $this->validateJob($job);
        
  	if (count($errors) == 0) {
	  $user = $this->authentication->getUser();
	  $job['userId'] = $user->id;
	$this->jobsTable->save($job);
	header('location: /admin/jobs');
	} else {
		return $this->editForm($errors);
	}
}
   

// Returns the values and template for the Add/Edit Job form page.
public function editForm($errors = []){
	$user = $this->authentication->getUser();

	if  (isset($this->get['id'])) {
		$result = $this->jobsTable->find('id', $this->get['id']);

		if ($result) $job = $result[0];
			else $job = false;
		$title = 'Edit Job';
	  } else  {
		 $job = false;
		 $title = 'Add Job';
	  }
	  $categories = $this->categoriesTable->findAll();

   	return ['template' => 'editJob.html.php',
	  'title' => 'Jo\'s Jobs - '.$title,
	  'variables' => [
		 'job' => $job,
		 'errors' => $errors,
		 'categories' => $categories,
		 'access' => $user->access ?? null,
		 'userId' => $user->id ?? null
		 ]
	  ];
   }


// deletes a job record
public function delete() {
	$user = $this->authentication->getUser();
	if ($user->id !=$this->jobsTable->find('id', $this->post['id'])[0]->userId) return;
		else {
			$this->jobsTable->delete($this->post['id']); 
			header('location: /admin/jobs');
		}
}
   

//Archives the job record.
public function archive() {
	$user = $this->authentication->getUser();
	if ($user->id !=$this->jobsTable->find('id', $this->post['id'])[0]->userId) return;
	else {
	$this->jobsTable->archive($this->post['id']);
	header('location: /admin/jobs');
	}
}
 

// Reposts the job.
public function repost() {
		$user = $this->authentication->getUser();
		if ($user->id !=$this->jobsTable->find('id', $this->post['id'])[0]->userId) return;
			else {
				$this->jobsTable->repost($this->post['id']);
				header('location: /admin/jobs');
			}
}


//Returns the values and template for the home page: 10 live jobs ordered by date in descending order.
public function home() {
$jobs = $this->jobsTable->find_order_limit_date_archive('closingDate', 'archived_status', 'No', 'closingDate', 'ASC', '10');

$categories = $this->categoriesTable->findAll();
 return ['template' => 'home.html.php',
 'title' => 'Jo\'s Jobs - Home',
 'variables' => [
	'jobs' => $jobs,
    'categories' => $categories
    ]
 ];
 }


//Returns the values and template for the applicants page on the admin area.
public function listApplicants() {
	
	$user = $this->authentication->getUser();

	if ($user->access == 1) $jobs = $this->jobsTable->find('id', $this->get['id']);
		else $jobs = $this->jobsTable->find('id', $this->get['id'], 'userId', $user->id);

	if (!empty($jobs))	
	{
		$job = $jobs[0];
		$applicants = $job->getApplicants();
	} else $job = false;
	
	$categories = $this->categoriesTable->findAll();
	return ['template' => 'applicants.html.php',
	'title' => 'Jo\'s Jobs - Applicants',
	'variables' => [
	   'categories' => $categories,
	   'job' => $job,
	   'applicants' => $applicants ?? null,
	   'access' => $user->access ?? null,
	   'userId' => $user->id ?? null
	   ]
	];
	}

}
