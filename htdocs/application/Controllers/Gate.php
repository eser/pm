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

        // TODO: Translate messages in English
        // validations
        Validation::addRule('login')->isRequired()->errorMessage(I18n::_('E-posta adresiniz boş olamaz.'));
        if (strpos($tLogin, '@') !== false) {
            Validation::addRule('login')->isEmail()->errorMessage(I18n::_('Lütfen e-posta adresinizi gözden geçirin.'));
        } else {
            Validation::addRule('login')->isRequired()->errorMessage(
                I18n::_('Lütfen kullanıcı isminizi gözden geçirin.')
            );
        }

        Validation::addRule('password')->isRequired()->errorMessage(I18n::_('Parolanız boş olamaz.'));
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
            $user = $this->userModel->getByEmail($tLogin);
        } else {
            $user = $this->userModel->getByUsername($tLogin);
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

        $this->userBindings->setUser($user);

        $this->set('success', true);
        $this->set('redirection', Http::url('home/index'));
        $this->json();
    }
}
