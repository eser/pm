<?php

namespace App\Includes;

use Scabbia\Extensions\Helpers\Arrays;
use Scabbia\Extensions\Helpers\Date;
use Scabbia\Extensions\I18n\I18n;
use Scabbia\Extensions\Http\Http;
use Scabbia\Extensions\LarouxJs\LarouxJs;
use Scabbia\Extensions\Mvc\Controllers;
use Scabbia\Request;

/**
 * @ignore
 */
class StaticHelpers
{
    /**
     * @ignore
     */
    public static function getRelativeUsers($uRelativesArray)
    {
        $tUserModel = Controllers::load('App\\Models\\UserModel');
        $tGroupModel = Controllers::load('App\\Models\\GroupModel');

        $tRelativeUsers = array();
        $tRelativeGroups = array();
        foreach ($uRelativesArray as $tRelative) {
            if ($tRelative['type'] == 'group') {
                $tRelativeGroups[] = $tRelative['targetid'];
            } else {
                $tRelativeUsers[] = $tRelative['targetid'];
            }
        }

        if (count($tRelativeGroups) > 0) {
            foreach ($tGroupModel->getUsersRange($tRelativeGroups) as $tUserId) {
                $tRelativeUsers[] = $tUserId;
            }
        }

        return $tUserModel->getRange($tRelativeUsers);
    }

    /**
     * @ignore
     */
    public static function getRelativeUsersGrouped($uRelativesArray)
    {
        $tUserModel = Controllers::load('App\\Models\\UserModel');
        $tGroupModel = Controllers::load('App\\Models\\GroupModel');

        $tRelativeUsers = isset($uRelativesArray['user']) ? Arrays::column($uRelativesArray['user'], 'targetid') : array();
        $tRelativeGroups = isset($uRelativesArray['group']) ? Arrays::column($uRelativesArray['group'], 'targetid') : array();

        if (count($tRelativeGroups) > 0) {
            foreach ($tGroupModel->getUsersRange($tRelativeGroups) as $tUserId) {
                $tRelativeUsers[] = $tUserId;
            }
        }

        return $tUserModel->getRange($tRelativeUsers);
    }
}
