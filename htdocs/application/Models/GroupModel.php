<?php

namespace App\Models;

use Scabbia\Extensions\Models\Model;

/**
 * @ignore
 */
class GroupModel extends Model
{
    /**
     * @ignore
     */
    public function getGroups()
    {
        return $this->db->createQuery()
            ->setTable('groups')
            ->addField('*')
            ->get()
            ->allWithKey('id');
    }

    /**
     * @ignore
     */
    public function getGroupsCount()
    {
        return $this->db->createQuery()
            ->setTable('groups')
            ->addField('COUNT(0)')
            ->get()
            ->scalar();
    }

    /**
     * @ignore
     */
    public function getGroupsWithPaging($uOffset = 0, $uLimit = 20)
    {
        $tResult = $this->db->createQuery()
            ->setTable('groups')
            ->setFields('*')
            ->setOffset($uOffset)
            ->setLimit($uLimit)
            ->get()
            ->all();

        return $tResult;
    }

    /**
     * @ignore
     */
    public function get($uId)
    {
        $tResult = $this->db->createQuery()
            ->setTable('groups')
            ->setFields('*')
            ->setWhere(array('id=:id'))
            ->setLimit(1)
            ->addParameter('id', $uId)
            ->get()
            ->row();

        return $tResult;
    }

    /**
     * @ignore
     */
    public function getRange($uIdRange)
    {
        $tResult = $this->db->createQuery()
            ->setTable('groups')
            ->setFields('*')
            ->setWhere(array('id', _IN, $uIdRange))
            ->get()
            ->allWithKey('id');

        return $tResult;
    }

    /**
     * @ignore
     */
    public function getUsersRange($uIdRange)
    {
        return $this->db->createQuery()
            ->setTable('user_groups')
            ->setFields('userid')
            ->setWhere(array('groupid', _IN, $uIdRange))
            ->get()
            ->column('userid');
    }

    /**
     * @ignore
     */
    public function insert($insert)
    {
        $tResult = $this->db->createQuery()
            ->setTable('groups')
            ->setFields($insert)
            ->insert()
            ->execute(true);

        return $tResult;
    }

    /**
     * @ignore
     */
    public function update($id, $update)
    {
        $tResult = $this->db->createQuery()
            ->setTable('groups')
            ->setFields($update)
            ->addParameter('id', $id)
            ->setWhere(array('id=:id'))
            ->setLimit(1)
            ->update()
            ->execute();

        return $tResult;
    }

    /**
     * @ignore
     */
    public function delete($uId)
    {
        $tResult = $this->db->createQuery()
            ->setTable('groups')
            ->setWhere(array('id=:id'))
            ->addParameter('id', $uId)
            ->setLimit(1)
            ->delete()
            ->execute();

        return $tResult;
    }
}
