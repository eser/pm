<?php

namespace App\Models;

use Scabbia\Extensions\Models\Model;

/**
 * @ignore
 */
class FileModel extends Model
{
    /**
     * @ignore
     */
    public function getFiles($uType, $uTargetId)
    {
        return $this->db->createQuery()
            ->setTable('files f')
            ->joinTable('users u', 'u.id=f.user', 'LEFT')
            ->addField('f.*, u.name AS usersname')
            ->setWhere(array('f.type=:type', _AND, 'f.targetid=:targetid'))
            ->addParameter('type', $uType)
            ->addParameter('targetid', $uTargetId)
            ->get()
            ->allWithKey('id');
    }

    /**
     * @ignore
     */
    public function getFilesOf($uUserId)
    {
        return $this->db->createQuery()
            ->setTable('files f')
            ->joinTable('users u', 'u.id=f.user', 'LEFT')
            ->addField('f.*, u.name AS usersname')
            ->setWhere(array('f.user=:userid'))
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
            ->setTable('files')
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
            ->setTable('files')
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
            ->setTable('files')
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
            ->setTable('files')
            ->setWhere(array('id=:id'))
            ->addParameter('id', $uId)
            ->setLimit(1)
            ->delete()
            ->execute();

        return $tResult;
    }
}
