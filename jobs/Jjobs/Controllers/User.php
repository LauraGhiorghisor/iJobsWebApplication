<?php

namespace Jjobs\Controllers;

class User{
  
    private $authentication;
    private $usersTable;
    private $categoriesTable;

    // Class constructor
    public function __construct(\CSY2028\Authentication $authentication = null, \CSY2028\DatabaseTable $usersTable, \CSY2028\DatabaseTable $categoriesTable = null, array $get, array $post)
    {
        $this->authentication = $authentication;
        $this->usersTable = $usersTable;
        $this->categoriesTable = $categoriesTable;
        $this->get = $get;
        $this->post = $post;
    }

    // Returns the values and template required by the loadTemplate() method in order to display the form for adding a new user (in the Admin area)
    public function addUserForm($errors = []){
        $user = $this->authentication->getUser();
        $categories = $this->categoriesTable->findAll();
        return ['template' => 'addUserForm.html.php',
        'title' => 'Jo\'s Jobs - Register',
        'variables' => [
           'categories' => $categories,
           'errors' => $errors,
           'access' => $user->access ?? null
           ]
        ];
     }
  
    // Validates the input on the add user form.
    public function validateRegistration($user){
    
        $errorMsg = [];

        if (empty($user['username'])){
            $errorMsg [] = 'Please fill in the username field';
        }
        if (empty($user['password'])){
            $errorMsg [] = 'You must provide a password!';
        }
        if (count($this->usersTable->find('username', $user['username']))>0)	{
            $errorMsg [] = 'Username already taken. Please try again!';
        }
        return $errorMsg;
    }

    // Adds a user record to the databases if it passes the validation.
    public function addUserSubmit(){

        $user = $this->post['user'];
        $errors = $this->validateRegistration($user);
        
        if (count($errors) == 0) {
        $user['password'] = password_hash(trim($this->post['user']['password']), PASSWORD_DEFAULT);
        $user['username'] = strtolower(trim($user['username']));
        $this->usersTable->save($user);
        header('location: /addUser/success');
        } else {
            return $this->addUserForm($errors);
            }
    }

    // Returns the  values and template required for displaying the success page.
     public function addUserSuccess(){
        $categories = $this->categoriesTable->findAll();
        $user = $this->authentication->getUser();
        return ['template' => 'addUserSuccess.html.php',
            'title' => 'Jo\'s Jobs - Success',
            'variables' => [
            'categories' => $categories,
            'access' => $user->access ?? null
            ]
         ];
     }

// Removes a user record from the database.
    public function removeUserSubmit (){
        $user = $this->authentication->getUser();
        if ($user->access !=2) return;
            else {
                $this->usersTable->delete($this->post['id']); 
                header('location: /admin/removeUser');
                }
    }

// Returns the values and template required to display the page containing the list of users (Admin area).
    public function removeUserForm(){
        $categories = $this->categoriesTable->findAll();
        $users = $this->usersTable->findAll();
        $user = $this->authentication->getUser();
        return ['template' => 'removeUserForm.html.php',
            'title' => 'Jo\'s Jobs - Remove User',
            'variables' => [
                'users'=> $users,
            'categories' => $categories,
            'access' => $user->access ?? null,
            'userId' => $user->id ?? null
            ]
            ];
    }

}
