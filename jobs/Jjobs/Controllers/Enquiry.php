<?php

namespace Jjobs\Controllers;

class Enquiry
{

  private $enquiriesTable;
  private $authentication;
  private $categoriesTable;

  //  class constructor
  public function __construct(\CSY2028\DatabaseTable $enquiriesTable, \CSY2028\DatabaseTable $categoriesTable = null, \CSY2028\Authentication $authentication = null,  array $get, array $post)
  {
    $this->enquiriesTable = $enquiriesTable;
    $this->authentication = $authentication;
    $this->categoriesTable = $categoriesTable;
    $this->get = $get;
    $this->post = $post;
  }

  // Validates the input on the enquiry page
  public function validateEnquiry($enquiry)
  {
    $errorMsg = [];

    if (empty($enquiry['name'])) {
      $errorMsg[] = 'Please provide a name!';
    }
    if (empty($enquiry['address'])) {
      $errorMsg[] = 'You must provide an address!';
    }

    if (empty($enquiry['telephone'])) {
      $errorMsg[] = 'Please provide a telephone number!';
    }
    if (empty($enquiry['text'])) {
      $errorMsg[] = 'You cannot submit an empty enquiry!';
    }
    return $errorMsg;
  }

  // Saves the enquiry to the database.
  public function addEnquirySubmit()
  {
    $enquiry = $this->post['enquiry'];
    $errors = $this->validateEnquiry($enquiry);

    if (count($errors) == 0) {
      $this->enquiriesTable->insert($enquiry);
      header('location: /enquiry/success');
    } else {
      return $this->addEnquiryForm($errors);
    }
  }

  // Returns the template and values requried for the success page.
  public function enquirySuccess()
  {
    $categories = $this->categoriesTable->findAll();
    return [
      'template' => 'enquirySuccess.html.php',
      'title' => 'Jo\'s Jobs - Success',
      'variables' => [
        'categories' => $categories
      ]
    ];
  }


  // Returns the values required for the Enquiry form page.
  public function addEnquiryForm($errors = [])
  {
    $categories = $this->categoriesTable->findAll();
    return [
      'template' => 'addEnquiry.html.php',
      'title' => 'Jo\'s Jobs - Add Enquiry',
      'variables' => [
        'errors' => $errors,
        'categories' => $categories,
      ]
    ];
  }

  // Returns the values and template required for the Enquiries page of the Admin area.
  public function enquiriesList()
  {
    $categories = $this->categoriesTable->findAll();
    $user = $this->authentication->getUser();

    if ($user->access >= 1) $enquiries = $this->enquiriesTable->findAll();
    else $enquiries = false;
    return [
      'template' => 'enquiries.html.php',
      'title' => 'Jo\'s Jobs - Enquiries',
      'variables' => [
        'categories' => $categories,
        'enquiries' => $enquiries,
        'access' => $user->access
      ]
    ];
  }

  // Changes the enquiry status to "completed" and saves the user who completed the enquiry.
  public function completeEnquiry()
  {
    $user = $this->authentication->getUser();
    if ($user->access >= 1) {
      $this->enquiriesTable->update_field('status', 1, $this->post['id']);
      $this->enquiriesTable->update_field('userId', $user->id, $this->post['id']);
      header('location: /admin/enquiries');
    } else return;
  }
}
