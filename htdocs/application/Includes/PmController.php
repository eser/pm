<?php

namespace App\Includes;

use Scabbia\Extensions\Mvc\Controller;
use Scabbia\Extensions\Database\Database;
use Scabbia\Framework;
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
    public function __construct()
    {
        parent::__construct();

        $this->loadDatasource('dbconn');
        $this->dbconn->errorHandling = Database::ERROR_EXCEPTION;
        $this->prerender->add(array(&$this, 'defaultPrerender'));
    }

    /**
     * @ignore
     */
    public function defaultPrerender()
    {
        $this->userBindings = UserBindings::get($this);

        Framework::$variables['userBindings'] = $this->userBindings;
    }
}
