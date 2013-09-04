<?php

namespace App\Models;

use Scabbia\Extensions\Models\Model;

/**
 * @ignore
 */
class roleModel extends Model
{
    /**
     * @ignore
     */
    public function getRoles()
    {
        return $this->db->createQuery()
            ->setTable('siteroles')
            ->addField('*')
            ->get()
            ->all();
    }
}
