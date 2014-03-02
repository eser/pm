<?php

namespace App\Models;

use Scabbia\Extensions\Models\Model;

/**
 * @ignore
 */
class LogModel extends Model
{
    /**
     * @ignore
     */
    public function getLogs($uType, $uTargetId)
    {
        return $this->db->createQuery()
            ->setTable('logs l')
            ->joinTable('users u', 'u.id=l.user', 'LEFT')
            ->addField('l.*, u.name AS usersname')
            ->setWhere(array('l.type=:type', _AND, 'l.targetid=:targetid'))
            ->addParameter('type', $uType)
            ->addParameter('targetid', $uTargetId)
            ->get()
            ->allWithKey('id');
    }

    /**
     * @ignore
     */
    public function getLogsOf($uUserId)
    {
        return $this->db->createQuery()
            ->setTable('logs l')
            ->joinTable('users u', 'u.id=l.user', 'LEFT')
            ->addField('l.*, u.name AS usersname')
            ->setWhere(array('l.user=:userid'))
            ->addParameter('userid', $uUserId)
            ->get()
            ->allWithKey('id');
    }

    /**
     * @ignore
     */
    public function get($uId)
    {
        $tResult = $this->db->createQuery()
            ->setTable('logs')
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
    public function insert($insert)
    {
        $tResult = $this->db->createQuery()
            ->setTable('logs')
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
            ->setTable('logs')
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
            ->setTable('logs')
            ->setWhere(array('id=:id'))
            ->addParameter('id', $uId)
            ->setLimit(1)
            ->delete()
            ->execute();

        return $tResult;
    }
}
