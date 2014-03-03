<?php

namespace App\Includes;

use Scabbia\Extensions\Helpers\Date;
use Scabbia\Extensions\I18n\I18n;
use Scabbia\Extensions\Http\Http;
use Scabbia\Extensions\LarouxJs\LarouxJs;
use Scabbia\Request;

/**
 * @ignore
 */
class ViewHelpers
{
    /**
     * @ignore
     */
    public static function printBool($uCondition)
    {
        if ($uCondition === true || intval($uCondition) === 1) {
            return I18n::_('Yes');
        }

        return I18n::_('No');
    }

    /**
     * @ignore
     */
    public static function printDate($uDate, $uIncludeHour = false)
    {
        if ($uDate === '' || $uDate === null) {
            return I18n::_('(Unspecified)');
        }

        return Date::convert($uDate, 'Y-m-d H:i:s', $uIncludeHour ? 'd/m/Y H:i' : 'd/m/Y');
    }

    /**
     * @ignore
     */
    public static function printProject($uProject)
    {
        return '<a href="' . Http::url('projects/show/' . $uProject['id']) . '">' . $uProject['title'] . '</a>';
    }

    /**
     * @ignore
     */
    public static function printProjectId($uProjectId, $uProjectName, $uProjectTitle)
    {
        return '<a href="' . Http::url('projects/show/' . $uProjectId) . '">' . $uProjectTitle . '</a>';
    }

    /**
     * @ignore
     */
    public static function printUser($uUser)
    {
        if ($uUser === null) {
            return I18n::_('(Unassigned)');
        }

        return '<a href="#">' . $uUser['name'] . '</a>'; // ' . Http::url('users/show/' . $uUser['id']) . '
    }

    /**
     * @ignore
     */
    public static function printUserId($uUserId, $uUserName)
    {
        if ($uUserId === 0) {
            return I18n::_('(Unassigned)');
        }

        return '<a href="#">' . $uUserName . '</a>'; // ' . Http::url('users/show/' . $uUserId) . '
    }
}
