<?php

namespace Jjobs\Controllers;

class Login
{
   private $authentication;
   private $categoriesTable;

   //  class constructor
   public function __construct(\CSY2028\Authentication $authentication = null, \CSY2028\DatabaseTable $categoriesTable = null, array $get, array $post)
   {
      $this->authentication = $authentication;
      $this->categoriesTable = $categoriesTable;
      $this->get = $get;
      $this->post = $post;
   }


   //   Validates the input on the login form. Calls the authentication login method which starts the session.
   public function validateLogin($user, $error)
   {
      $errorMsg = [];

      if (empty($user['username'])) {
         $errorMsg[] = 'Please provide a username!';
      }
      if (empty($user['password'])) {
         $errorMsg[] = 'Please provide a password!';
      }
      if ($error !== null) {
         if ($error !== 0) {
            $errorMsg[] = 'We couldn\'t find your details!';
         }
      } else if (count($errorMsg) == 0 && !$this->authentication->login($this->post['username'], $this->post['password'])) {
         $errorMsg[] = 'We couldn\'t find your details!';
      }
      return $errorMsg;
   }

   // Redirects to the login success page or returns the login form method if the login is not successful.
   public function loginSubmit()
   {
      $user = $this->post;
      $errors = $this->validateLogin($user, null);

      if (count($errors) == 0) {
         header('location: /admin/login/success');
      } else return $this->loginForm($errors);
   }


   // Returns the values and template required for the login form page.
   public function loginForm($errors = [])
   {
      $categories = $this->categoriesTable->findAll();

      return [
         'template' => 'loginForm.html.php',
         'title' => 'Jo\'s Jobs - Admin Home',
         'variables' => [
            'loggedin' => $this->authentication->isLoggedIn(),
            'errors' => $errors,
            'categories' => $categories,
            'access' => $this->authentication->getUser()->access ?? '',
         ]
      ];
   }


   //Returns the values and template required for the Log in error page. This page is shown to users trying to access pages that require log in.
   public function loginError()
   {
      $categories = $this->categoriesTable->findAll();
      return [
         'template' => 'loginError.html.php',
         'title' => 'Jo\'s Jobs - Login Error',
         'variables' => [
            'categories' => $categories
         ]
      ];
   }

   //   Returns the values and template required to display the success page after log in.
   public function loginSuccess()
   {
      $categories = $this->categoriesTable->findAll();
      $user = $this->authentication->getUser();
      return [
         'template' => 'loginSuccess.html.php',
         'title' => 'Jo\'s Jobs - Admin Home',
         'variables' => [
            'categories' => $categories,
            'access' => $user->access ?? null
         ]
      ];
   }

   // Log the user out. Returns the values and template required to display the log out page.
   public function logout()
   {
      session_destroy();
      $categories = $this->categoriesTable->findAll();
      return [
         'template' => 'logout.html.php',
         'title' => 'Jo\'s Jobs - Log out',
         'variables' => [
            'loggedin' => false,
            'categories' => $categories
         ]
      ];
   }
}
