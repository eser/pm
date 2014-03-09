<?php

namespace App\Models;

use Scabbia\Extensions\Models\Model;

/**
 * @ignore
 */
class ProjectModel extends Model
{
    /**
     * @ignore
     */
    public function getProjects()
    {
        return $this->db->createQuery()
            ->setTable('projects')
            ->addField('*')
            ->get()
            ->allWithKey('id');
    }

    /**
     * @ignore
     */
    public function getProjectsCount()
    {
        return $this->db->createQuery()
            ->setTable('projects')
            ->addField('COUNT(0)')
            ->get()
            ->scalar();
    }

    /**
     * @ignore
     */
    public function getProjectsWithPaging($uOffset = 0, $uLimit = 20)
    {
        $tResult = $this->db->createQuery()
            ->setTable('projects')
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
    public function getProjectsOf($uUserId)
    {
        return $this->db->createQuery()
            ->setTable('projects p')
            ->joinTable('project_users pu', 'pu.project=p.id', 'LEFT')
            ->addField('p.*')
            ->setWhere(array('pu.user=:user', _OR, 'p.owner=:user', _OR, 'p.public=\'1\''))
            ->setGroupBy('p.id')
            ->addParameter('user', $uUserId)
            ->get()
            ->allWithKey('id');
    }

    /**
     * @ignore
     */
    public function getProjectsOfCount($uUserId)
    {
        return $this->db->createQuery()
            ->setTable('projects p')
            ->joinTable('project_users pu', 'pu.project=p.id', 'LEFT')
            ->addField('COUNT(0)')
            ->setWhere(array('pu.user=:user', _OR, 'p.owner=:user', _OR, 'p.public=\'1\''))
            ->setGroupBy('p.id')
            ->addParameter('user', $uUserId)
            ->get()
            ->scalar();
    }

    /**
     * @ignore
     */
    public function getProjectsOfWithPaging($uUserId, $uOffset = 0, $uLimit = 20)
    {
        $tResult = $this->db->createQuery()
            ->setTable('projects p')
            ->joinTable('project_users pu', 'pu.project=p.id', 'LEFT')
            ->addField('p.*')
            ->setWhere(array('pu.user=:user', _OR, 'p.owner=:user', _OR, 'p.public=\'1\''))
            ->setGroupBy('p.id')
            ->setOffset($uOffset)
            ->setLimit($uLimit)
            ->addParameter('user', $uUserId)
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
            ->setTable('projects')
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
            ->setTable('projects')
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
            ->setTable('projects')
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
            ->setTable('projects')
            ->setWhere(array('id=:id'))
            ->addParameter('id', $uId)
            ->setLimit(1)
            ->delete()
            ->execute();

        return $tResult;
    }
}
