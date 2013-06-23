<?php

namespace App\Models;

use Scabbia\Extensions\Models\Model;

/**
 * @ignore
 */
class userModel extends Model
{
    /**
     * @ignore
     */
    public function getUsers()
    {
        return $this->db->createQuery()
            ->setTable('users')
            ->addField('*')
            ->get()
            ->all();
    }
}
