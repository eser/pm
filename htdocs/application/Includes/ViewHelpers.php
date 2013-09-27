<?php

namespace App\Includes;

use Scabbia\Extensions\I18n\I18n;
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
}
