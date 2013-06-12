<?php

namespace App;

use Scabbia\Extensions\Mvc\Controller;
use Scabbia\Extensions\Fb\Fb;

/**
 * @ignore
 */
class home extends Controller
{
    /**
     * @ignore
     */
    public function index()
    {
        $this->load('App\\homeModel');

        $tWelcomeText = $this->homeModel->getWelcomeText();
        $this->set('welcomeText', $tWelcomeText);
        
        $tUsers = $this->homeModel->getUsers();
        $this->set('users', $tUsers);

        $this->view();
    }

    /**
     * @ignore
     */
    public function getajax_index()
    {
        $this->load('App\\homeModel');

        $tWelcomeText = $this->homeModel->getWelcomeText();
        $this->set('welcomeText', $tWelcomeText);

        $this->json();
    }

    /**
     * @ignore
     */
    public function facebookLogin()
    {
        Fb::loadApi(true);
        Fb::$appRedirectUri = Http::url('home/facebookLogin', true);
        Fb::login();

        $tUserData = Fb::getUser();

        echo 'Welcome ', $tUserData->object['username'], '!';
    }
}
