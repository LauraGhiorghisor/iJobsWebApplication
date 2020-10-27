<?php

namespace Jjobs;

class Routes implements \CSY2028\Routes
{


    private $authentication;

    public function getRoutes($route): array
    {
        require '../database.php';

        $categoriesTable = new \CSY2028\DatabaseTable($pdo, 'category', 'id');
        $applicantsTable = new \CSY2028\DatabaseTable($pdo, 'applicants', 'id');
        $usersTable = new \CSY2028\DatabaseTable($pdo, 'users', 'id');
        $jobsTable = new \CSY2028\DatabaseTable($pdo, 'job', 'id', '\Jjobs\Entities\Job', [$categoriesTable, $applicantsTable]);
        $enquiriesTable = new \CSY2028\DatabaseTable($pdo, 'enquiries', 'id', '\Jjobs\Entities\Enquiry', [$usersTable]);


        $this->authentication = new \CSY2028\Authentication($usersTable, 'username', 'password');
        $jobController = new \Jjobs\Controllers\Job($jobsTable, $categoriesTable, $usersTable, $this->authentication, $_GET, $_POST);
        $categoryController = new \Jjobs\Controllers\Category($categoriesTable, $this->authentication, $_GET, $_POST);
        $applicantsController = new \Jjobs\Controllers\Applicant($applicantsTable, $this->authentication, $categoriesTable, $jobsTable, $_GET, $_POST);
        $enquiriesController = new \Jjobs\Controllers\Enquiry($enquiriesTable, $categoriesTable, $this->authentication, $_GET, $_POST);

        $loginController = new \Jjobs\Controllers\Login($this->authentication, $categoriesTable, $_GET, $_POST);
        $usersController = new \Jjobs\Controllers\User($this->authentication, $usersTable, $categoriesTable, $_GET, $_POST);


        $routes = [
            '' => [
                'GET' => [
                    'controller' => $jobController,
                    'function' => 'home'
                ]
            ],
            'about' => [
                'GET' => [
                    'controller' => $categoryController,
                    'function' => 'about'
                ]
            ],
            'faq' => [
                'GET' => [
                    'controller' => $categoryController,
                    'function' => 'faq'
                ]
            ],
            'category' => [
                'GET' => [
                    'controller' => $jobController,
                    'function' => 'list'
                ],
                'POST' => [
                    'controller' => $jobController,
                    'function' => 'filteredList'
                ]
            ],
            'category/apply' => [
                'GET' => [
                    'controller' => $applicantsController,
                    'function' => 'applyForm'
                ],
                'POST' => [
                    'controller' => $applicantsController,
                    'function' => 'applySubmit'
                ]
            ],
            'category/apply/success' => [
                'GET' => [
                    'controller' => $applicantsController,
                    'function' => 'applySuccess'
                ]
            ],
            'category/apply/error' => [
                'GET' => [
                    'controller' => $applicantsController,
                    'function' => 'applyError'
                ]
            ],
            'admin/login' => [
                'POST' => [
                    'controller' => $loginController,
                    'function' => 'loginSubmit'
                ],
                'GET' => [
                    'controller' => $loginController,
                    'function' => 'loginForm'
                ]
            ],

            'admin/login/error' => [
                'GET' => [
                    'controller' => $loginController,
                    'function' => 'loginError'
                ]
            ],
            'admin/login/success' => [
                'GET' => [
                    'controller' => $loginController,
                    'function' => 'loginSuccess'
                ],
                'login' => true
            ],
            'admin/logout' => [
                'GET' => [
                    'controller' => $loginController,
                    'function' => 'logout'
                ]
            ],
            'admin/categories' => [
                'GET' => [
                    'controller' => $categoryController,
                    'function' => 'categories'
                ],
                'login' => true
            ],
            'admin/jobs' => [
                'GET' => [
                    'controller' => $jobController,
                    'function' => 'adminJobList'
                ],
                'POST' => [
                    'controller' => $jobController,
                    'function' => 'adminFilteredJobList'
                ],
                'login' => true
            ],
            'admin/job/edit' => [
                'GET' => [
                    'controller' => $jobController,
                    'function' => 'editForm'
                ],
                'POST' => [
                    'controller' => $jobController,
                    'function' => 'editSubmit'
                ],
                'login' => true
            ],
            'admin/category/edit' => [
                'GET' => [
                    'controller' => $categoryController,
                    'function' => 'editForm'
                ],
                'POST' => [
                    'controller' => $categoryController,
                    'function' => 'editSubmit'
                ],
                'login' => true
            ],

            'admin/job/delete' => [
                'POST' => [
                    'controller' => $jobController,
                    'function' => 'delete'
                ],
                'GET' => [
                    'controller' => $jobController,
                    'function' => 'home'
                ],
                'login' => true
            ],
            'admin/job/archive' => [
                'POST' => [
                    'controller' => $jobController,
                    'function' => 'archive'
                ],
                'GET' => [
                    'controller' => $jobController,
                    'function' => 'home'
                ],
                'login' => true
            ],
            'admin/job/repost' => [
                'POST' => [
                    'controller' => $jobController,
                    'function' => 'repost'
                ],
                'GET' => [
                    'controller' => $jobController,
                    'function' => 'home'
                ],
                'login' => true
            ],
            'admin/category/delete' => [
                'POST' => [
                    'controller' => $categoryController,
                    'function' => 'delete'
                ],
                'GET' => [
                    'controller' => $jobController,
                    'function' => 'home'
                ],
                'login' => true
            ],
            'admin/job/applicants' => [
                'GET' => [
                    'controller' => $jobController,
                    'function' => 'listApplicants'
                ],
                'login' => true
            ],
            'admin/addUser' => [
                'GET' => [
                    'controller' => $usersController,
                    'function' => 'addUserForm'
                ],
                'POST' => [
                    'controller' => $usersController,
                    'function' => 'addUserSubmit'
                ],
                'login' => true
            ],
            'admin/removeUser' => [
                'GET' => [
                    'controller' => $usersController,
                    'function' => 'removeUserForm'
                ],
                'POST' => [
                    'controller' => $usersController,
                    'function' => 'removeUserSubmit'
                ],
                'login' => true
            ],

            'addUser/success' => [
                'GET' => [
                    'controller' => $usersController,
                    'function' => 'addUserSuccess'
                ],
                'login' => true
            ],
            'admin/enquiries' => [
                'GET' => [
                    'controller' => $enquiriesController,
                    'function' => 'enquiriesList'
                ],
                'login' => true
            ],
            'admin/completeEnquiry' => [
                'POST' => [
                    'controller' => $enquiriesController,
                    'function' => 'completeEnquiry'
                ],
                'login' => true
            ],
            'contact' => [
                'GET' => [
                    'controller' => $enquiriesController,
                    'function' => 'addEnquiryForm'
                ],
                'POST' => [
                    'controller' => $enquiriesController,
                    'function' => 'addEnquirySubmit'
                ]
            ],
            'enquiry/success' => [
                'GET' => [
                    'controller' => $enquiriesController,
                    'function' => 'enquirySuccess'
                ]
            ],
        ];

        return $routes;
    }

    public function getAuthentication(): \CSY2028\Authentication
    {
        return $this->authentication;
    }
}
