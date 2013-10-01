<?php

namespace App\Controllers;

use App\Includes\PmController;

/**
 * @ignore
 */
class Home extends PmController
{
    /**
     * @ignore
     */
    public function index()
    {
        $this->load('App\\Models\\HomeModel');

        $tWelcomeText = $this->homeModel->getWelcomeText();
        $this->set('welcomeText', $tWelcomeText);
        
        $this->view();
    }
}
