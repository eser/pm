<?php

namespace App\Models;

use Scabbia\Extensions\Models\Model;

/**
 * @ignore
 */
class UserModel extends Model
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
            ->allWithKey('id');
    }

    /**
     * @ignore
     */
    public function getUsersCount()
    {
        return $this->db->createQuery()
            ->setTable('users')
            ->addField('COUNT(0)')
            ->get()
            ->scalar();
    }

    /**
     * @ignore
     */
    public function getUsersWithPaging($uOffset = 0, $uLimit = 20)
    {
        $tResult = $this->db->createQuery()
            ->setTable('users')
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
            ->setTable('users')
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
            ->setTable('users')
            ->setFields('*')
            ->setWhere(array('id', _IN, $uIdRange))
            ->get()
            ->allWithKey('id');

        return $tResult;
    }

    /**
     * @ignore
     */
    public function getWithRoles($uId)
    {
        $tResult = $this->db->createQuery()
            ->setTable('users u')
            ->joinTable('roles r', 'r.id=u.role', 'LEFT')
            ->setFields('u.*, r.login AS rolelogin, r.active AS roleactive, r.administer AS roleadminister')
            ->setWhere(array('u.id=:id'))
            ->setLimit(1)
            ->addParameter('id', $uId)
            ->get()
            ->row();

        return $tResult;
    }

    /**
     * @ignore
     */
    public function getWithRolesByUsername($uUsername)
    {
        $tResult = $this->db->createQuery()
            ->setTable('users u')
            ->joinTable('roles r', 'r.id=u.role', 'LEFT')
            ->setFields('u.*, r.login AS rolelogin, r.active AS roleactive, r.administer AS roleadminister')
            ->setWhere(array('u.username=:username'))
            ->setLimit(1)
            ->addParameter('username', $uUsername)
            ->get()
            ->row();

        return $tResult;
    }

    /**
     * @ignore
     */
    public function getWithRolesByEmail($uEmail)
    {
        $tResult = $this->db->createQuery()
            ->setTable('users u')
            ->joinTable('roles r', 'r.id=u.role', 'LEFT')
            ->setFields('u.*, r.login AS rolelogin, r.active AS roleactive, r.administer AS roleadminister')
            ->setWhere(array('u.email=:email'))
            ->setLimit(1)
            ->addParameter('email', $uEmail)
            ->get()
            ->row();

        return $tResult;
    }

    /**
     * @ignore
     */
    public function insert($insert)
    {
        $tResult = $this->db->createQuery()
            ->setTable('users')
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
            ->setTable('users')
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
            ->setTable('users')
            ->setWhere(array('id=:id'))
            ->addParameter('id', $uId)
            ->setLimit(1)
            ->delete()
            ->execute();

        return $tResult;
    }

    /**
     * @ignore
     */
    public function getGroups($uId)
    {
        return $this->db->createQuery()
            ->setTable('user_groups')
            ->setFields('groupid')
            ->setWhere(array('userid=:userid'))
            ->addParameter('userid', $uId)
            ->get()
            ->column('groupid');
    }

    /**
     * @ignore
     */
    public function addToGroup($uId, $uGroupId)
    {
        $tResult = $this->db->createQuery()
            ->setTable('user_groups')
            ->setFields(
                array(
                    'userid' => $uId,
                    'groupid' => $uGroupId
                )
            )
            ->insert()
            ->execute(true);

        return $tResult;
    }

    /**
     * @ignore
     */
    public function purgeGroups($uId)
    {
        $tResult = $this->db->createQuery()
            ->setTable('user_groups')
            ->setWhere(array('userid=:userid'))
            ->addParameter('userid', $uId)
            ->delete()
            ->execute();

        return $tResult;
    }
}
