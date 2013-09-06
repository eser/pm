<?php

namespace App\Controllers;

use Scabbia\Extensions\Mvc\Controller;

/**
 * @ignore
 */
class projects extends Controller
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
}
