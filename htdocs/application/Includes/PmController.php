<?php

namespace App\Includes;

use Scabbia\Extensions\Http\Http;
use Scabbia\Extensions\I18n\I18n;
use Scabbia\Extensions\Mvc\Controller;
use Scabbia\Extensions\Database\Database;
use Scabbia\Framework;
use Scabbia\Request;
use App\Includes\UserBindings;

/**
 * @ignore
 */
class PmController extends Controller
{
    /**
     * @ignore
     */
    public $authOnly = true;
    /**
     * @ignore
     */
    public $userBindings;
    /**
     * @ignore
     */
    public $breadcrumbs;


    /**
     * @ignore
     */
    public function __construct()
    {
        parent::__construct();

        $this->loadDatasource('dbconn');
        $this->dbconn->errorHandling = Database::ERROR_EXCEPTION;
        $this->prerender->add(array(&$this, 'defaultPrerender'));

        if (isset($_GET['lang']) && strlen($_GET['lang']) > 0) {
            $tLanguage = $_GET['lang'];
            I18n::setLanguage($tLanguage);

            if (I18n::$language !== null) {
                Http::sendCookie('lang', I18n::$language['key']);
            }
        } else {
            $tLanguage = Request::cookie('lang', 'en');
            I18n::setLanguage($tLanguage);
        }        

        $this->breadcrumbs = array(
            I18n::_('Home') => array('icon-home', 'home')
        );
    }

    /**
     * @ignore
     */
    public function defaultPrerender()
    {
        $this->userBindings = UserBindings::get($this);

        // no need since 'controller' already has been registered to variables.
        // Framework::$variables['userBindings'] = $this->userBindings;
    }
}
