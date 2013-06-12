<?php

namespace App;

use Scabbia\Extensions\Models\Model;

/**
 * @ignore
 */
class homeModel extends Model
{
    /**
     * @ignore
     */
    public function getWelcomeText()
    {
        return 'Welcome!';
    }
    
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
