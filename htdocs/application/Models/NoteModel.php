<?php

namespace App\Models;

use Scabbia\Extensions\Models\Model;

/**
 * @ignore
 */
class NoteModel extends Model
{
    /**
     * @ignore
     */
    public function getNotes($uType, $uTargetId)
    {
        return $this->db->createQuery()
            ->setTable('notes n')
            ->joinTable('users u', 'u.id=n.user', 'LEFT')
            ->addField('n.*, u.name AS usersname')
            ->setWhere(array('n.type=:type', _AND, 'n.targetid=:targetid'))
            ->addParameter('type', $uType)
            ->addParameter('targetid', $uTargetId)
            ->get()
            ->allWithKey('id');
    }

    /**
     * @ignore
     */
    public function getNotesOf($uUserId)
    {
        return $this->db->createQuery()
            ->setTable('notes n')
            ->joinTable('users u', 'u.id=n.user', 'LEFT')
            ->addField('n.*, u.name AS usersname')
            ->setWhere(array('n.user=:userid'))
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
            ->setTable('notes')
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
            ->setTable('notes')
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
            ->setTable('notes')
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
            ->setTable('notes')
            ->setWhere(array('id=:id'))
            ->addParameter('id', $uId)
            ->setLimit(1)
            ->delete()
            ->execute();

        return $tResult;
    }
}
