<?php

namespace App\Controllers;

use Scabbia\Extensions\Auth\Auth;
use Scabbia\Extensions\Http\Http;
use Scabbia\Extensions\I18n\I18n;
use Scabbia\Extensions\Validation\Validation;
use Scabbia\Request;
use App\Includes\PmController;

/**
 * @ignore
 */
class Gate extends PmController
{
    /**
     * @ignore
     */
    public $authOnly = false;

    /**
     * @ignore
     */
    public function login()
    {
        Auth::clear();

        $this->view();
    }

    /**
     * @ignore
     */
    public function postajax_login_json()
    {
        Auth::clear();

        $tLogin = Request::post('login');
        $tPassword = Request::post('password');

        // validations
        Validation::addRule('login')->isRequired()->errorMessage(I18n::_('E-mail address cannot be empty.'));
        if (strpos($tLogin, '@') !== false) {
            Validation::addRule('login')->isEmail()->errorMessage(I18n::_('Please check your e-mail address again.'));
        } else {
            Validation::addRule('login')->isRequired()->errorMessage(
                I18n::_('Please check your username again.')
            );
        }

        Validation::addRule('password')->isRequired()->errorMessage(I18n::_('Password cannot be empty.'));
//        Validation::addRule('password')->lengthMinimum(6)->errorMessage(
//            I18n::_('Şifreniz en az 6 karakter olmalıdır.')
//        );

        if (!Validation::validate($_POST)) {
            $this->set('success', false);

            $this->set('error', Validation::getErrorMessages(true));
            $this->json();

            return;
        }

        // kullanici kontrolleri
        $this->load('App\\Models\\UserModel');
        if (strpos($tLogin, '@') !== false) {
            $user = $this->userModel->getWithRolesByEmail($tLogin);
        } else {
            $user = $this->userModel->getWithRolesByUsername($tLogin);
        }

        if ($user === false) {
            $this->set('success', false);
            $this->set('error', I18n::_('Invalid username or e-mail.'));
            $this->json();

            return;
        }

        // password is not correct
        if ($tPassword != $user['password']) {
            $this->set('success', false);
            $this->set('error', I18n::_('Invalid password.'));
            $this->json();

            return;
        }

        // user is disabled
        if ($user['active'] !== '1' || $user['roleactive'] !== '1' || $user['rolelogin'] !== '1') {
            $this->set('success', false);
            $this->set('error', I18n::_('User is disabled.'));
            $this->json();

            return;
        }

        // TODO: check account role is disabled or not.

        $this->userBindings->setUser($user);

        $this->set('success', true);
        $this->set('redirection', Http::url('home/index'));
        $this->json();
    }
}
