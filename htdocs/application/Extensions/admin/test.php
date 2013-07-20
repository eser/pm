<?php

namespace App\Extensions\Admin;

use Scabbia\Extensions\Auth\Auth;
use Scabbia\Extensions\Mvc\Controllers;
use Scabbia\Extensions\Panel\Controllers\Panel;
use Scabbia\Extensions\Views\Views;

/**
 * Admin Extension: Test Section
 *
 * @package Scabbia
 * @subpackage Panel
 * @version 1.1.0
 */
class Test
{
    /**
     * @ignore
     */
    public static function index()
    {
        Auth::checkRedirect('user');

        $tVariables = array(
            'message' => 'test'
        );

        Views::viewFile('{app}views/admin/test/index.cshtml', $tVariables);
    }

    /**
     * @ignore
     */
    public static function dummy()
    {
        Auth::checkRedirect('user');

        echo 'dummy';
    }
}
