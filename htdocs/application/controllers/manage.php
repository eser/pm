<?php

namespace App\Controllers;

use Scabbia\Extensions\Mvc\Controller;
use Scabbia\Extensions\Fb\Fb;

/**
 * @ignore
 */
class manage extends Controller
{
    /**
     * @ignore
     */
    public function index()
    {
        $this->load('App\\Models\\homeModel');

        $tWelcomeText = $this->homeModel->getWelcomeText();
        $this->set('welcomeText', $tWelcomeText);
        
        $this->view();
    }

    /**
     * @ignore
     */
    public function users()
    {
        $this->load('App\\Models\\userModel');

        $tUsers = $this->userModel->getUsers();
        $this->set('users', $tUsers);

        $this->view();
    }

    /**
     * @ignore
     */
    public function groups()
    {
        $this->load('App\\Models\\groupModel');

        $tGroups = $this->groupModel->getGroups();
        $this->set('groups', $tGroups);

        $this->view();
    }


    /**
     * @ignore
     */
    public function roles()
    {
        $this->load('App\\Models\\roleModel');

        $tRoles = $this->roleModel->getRoles();
        $this->set('roles', $tRoles);

        $this->view();
    }
}
