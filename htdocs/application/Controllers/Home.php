<?php

namespace App\Controllers;

use Scabbia\Extensions\Mvc\Controller;

/**
 * @ignore
 */
class Home extends Controller
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
