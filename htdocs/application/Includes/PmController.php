<?php

namespace App\Includes;

use Scabbia\Extensions\I18n\I18n;
use Scabbia\Extensions\LarouxJs\LarouxJs;
use Scabbia\Extensions\Mvc\Controller;
use Scabbia\Extensions\Database\Database;
use Scabbia\Request;

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
    }
}
