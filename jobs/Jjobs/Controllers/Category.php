<?php

namespace Jjobs\Controllers;

class Category
{

   private $jcategoriesTable;
   private $authentication;

   public function __construct(\CSY2028\DatabaseTable $categoriesTable, \CSY2028\Authentication $authentication = null, array $get, array $post)
   {
      $this->categoriesTable = $categoriesTable;
      $this->authentication = $authentication;
      $this->get = $get;
      $this->post = $post;
   }

   // Generates values for the template for the "About Us" page
   public function about()
   {
      $categories = $this->categoriesTable->findAll();
      return [
         'template' => 'about.html.php',
         'title' => 'Jo\'s Jobs - About',
         'variables' => [
            'categories' => $categories
         ]
      ];
   }

   //  Generates the values for the template for the "FAQ" page
   public function faq()
   {
      $categories = $this->categoriesTable->findAll();
      return [
         'template' => 'faq.html.php',
         'title' => 'Jo\'s Jobs - FAQ',
         'variables' => [
            'categories' => $categories
         ]
      ];
   }


   // Returns the values and template for the page displaying the jobs on the admin side
   public function categories()
   {
      $user = $this->authentication->getUser();
      $categories = $this->categoriesTable->findAll();
      return [
         'template' => 'categories.html.php',
         'title' => 'Jo\'s Jobs - Categories',
         'variables' => [
            'categories' => $categories,
            'access' => $user->access ?? null
         ],
      ];
   }


   // Validates the inputs on the Add/Edit Category form  
   public function validateCategory($category)
   {
      $errorMsg = [];
      if (empty($category['name'])) {
         $errorMsg[] = 'Please provide a name!';
      }
      return $errorMsg;
   }


   // Saves the category to the database.
   public function editSubmit()
   {
      $category = $this->post['category'];
      $user = $this->authentication->getUser();
      $errors = $this->validateCategory($category);

      if (count($errors) == 0) {
         if ($user->access < 1) {
            header('location: /admin/categories');
            return;
         } else {
            $this->categoriesTable->save($category);
         }
         header('location: /admin/categories');
         return 1;
      } else {
         return $this->editForm($errors);
      }
   }

   // Generates the values needed for the Add/edit category form template.
   public function editForm($errors = [])
   {
      if (isset($this->get['id'])) {
         $result = $this->categoriesTable->find('id', $this->get['id']);
         if (!empty($result)) $category = $result[0];
         else $category = false;
         $title = 'Edit Category';
      } else {
         $category = false;
         $title = 'Add Category';
      }

      $categories = $this->categoriesTable->findAll();
      $user = $this->authentication->getUser();

      return [
         'template' => 'editCategory.html.php',
         'title' => 'Jo\'s Jobs - ' . $title,
         'variables' => [
            'category' => $category,
            'errors' => $errors,
            'categories' => $categories,
            'access' => $user->access ?? null
         ]
      ];
   }


   // deletes a category from the database
   public function delete()
   {
      $user = $this->authentication->getUser();
      if ($user->access < 1) {
         header('location: /admin/categories');
         return;
      } else {
         $this->categoriesTable->delete($this->post['id']);
         header('location: /admin/categories');
      }
   }
}
