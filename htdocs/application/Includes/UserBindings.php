<?php

namespace App\Includes;

use Scabbia\Extensions\Helpers\String;
use Scabbia\Extensions\Http\Http;
use Scabbia\Extensions\Mvc\Controllers;
use Scabbia\Extensions\Session\Session;
use App\Includes\PmController;
use Scabbia\Request;

/**
 * @ignore
 */
class UserBindings
{
    /**
     * @ignore
     */
    public $user;
    /**
     * @ignore
     */
    public $language;

    /**
     * @ignore
     */
    public static function get(PmController $uController)
    {
        $newInstance = new static();

        // user
        $newInstance->user = Session::get('user', null);
        if (!isset($newInstance->user)) {
            // if user is not logged in
            if ($uController->authOnly) {
                if (strlen(Request::$pathInfo) > 0 && Request::$pathInfo !== 'gate/login') {
                    Http::redirect('gate/login?return=' . Http::encode(Request::$pathInfo));
                } else {
                    Http::redirect('gate/login');
                }

                exit;
            }
        }

        return $newInstance;
    }

    /**
     * @ignore
     */
    public function reloadUserInfo()
    {
        // user added to session, so put tagids to session and also block list to improve performance
    }

    /**
     * @ignore
     */
    public function setUser($uUser)
    {
        $this->user = $uUser;
        Session::set('user', $this->user);

        $this->reloadUserInfo();
    }

    /**
     * @ignore
     */
    public function setUserFromDatabase($uUserId)
    {
        $userModel = Controllers::load('App\\Models\\UserModel');
        $this->user = $userModel->getWithRoles($uUserId);
        Session::set('user', $this->user);

        $this->reloadUserInfo();
    }

    /**
     * @ignore
     */
    public function isSuperuser() {
        return ($this->user['level'] == 'superuser' || $this->user['level'] == 'admin');
    }
}
