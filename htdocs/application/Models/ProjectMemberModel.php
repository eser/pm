<?php

namespace App\Models;

use Scabbia\Extensions\Models\Model;

/**
 * @ignore
 */
class ProjectMemberModel extends Model
{
    /**
     * @ignore
     */
    public function getAllMembers()
    {
        return $this->db->createQuery()
            ->setTable('project_users')
            ->addField('*')
            ->setOrderBy('project ASC, relation ASC')
            ->get()
            ->allWithKey('id');
    }

    /**
     * @ignore
     */
    public function getMembers($uProjectId)
    {
        return $this->db->createQuery()
            ->setTable('project_users')
            ->addField('*')
            ->addParameter('project', $uProjectId)
            ->setWhere(array('project=:project'))
            ->setOrderBy('relation ASC')
            ->get()
            ->allWithKey('id');
    }

    /**
     * @ignore
     */
    public function getMembersCount($uProjectId)
    {
        return $this->db->createQuery()
            ->setTable('project_users')
            ->addField('COUNT(0)')
            ->addParameter('project', $uProjectId)
            ->setWhere(array('project=:project'))
            ->get()
            ->scalar();
    }

    /**
     * @ignore
     */
    public function getMembersWithPaging($uProjectId, $uOffset = 0, $uLimit = 20)
    {
        $tResult = $this->db->createQuery()
            ->setTable('project_users')
            ->setFields('*')
            ->setOffset($uOffset)
            ->setLimit($uLimit)
            ->addParameter('project', $uProjectId)
            ->setWhere(array('project=:project'))
            ->setOrderBy('relation ASC')
            ->get()
            ->all();

        return $tResult;
    }

    /**
     * @ignore
     */
    public function getConstantsByRelation($uProjectId, $uRelation)
    {
        return $this->db->createQuery()
            ->setTable('project_users')
            ->addField('*')
            ->addParameter('relation', $uRelation)
            ->addParameter('project', $uProjectId)
            ->setWhere(array('project=:project', _AND, 'relation=:relation'))
            ->get()
            ->allWithKey('id');
    }

    /**
     * @ignore
     */
    public function get($uId)
    {
        $tResult = $this->db->createQuery()
            ->setTable('project_users')
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
            ->setTable('project_users')
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
            ->setTable('project_users')
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
            ->setTable('project_users')
            ->setWhere(array('id=:id'))
            ->addParameter('id', $uId)
            ->setLimit(1)
            ->delete()
            ->execute();

        return $tResult;
    }
}
