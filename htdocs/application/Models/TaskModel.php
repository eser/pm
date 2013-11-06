<?php

namespace App\Models;

use Scabbia\Extensions\Models\Model;

/**
 * @ignore
 */
class TaskModel extends Model
{
    /**
     * @ignore
     */
    public function getTasks($uProjectId)
    {
        return $this->db->createQuery()
            ->setTable('tasks')
            ->addField('*')
            ->setWhere(array('project=:projectid'))
            ->addParameter('projectid', $uProjectId)
            ->get()
            ->allWithKey('id');
    }

    /**
     * @ignore
     */
    public function getTasksCount($uProjectId)
    {
        return $this->db->createQuery()
            ->setTable('tasks')
            ->addField('COUNT(0)')
            ->setWhere(array('project=:projectid'))
            ->addParameter('projectid', $uProjectId)
            ->get()
            ->scalar();
    }

    /**
     * @ignore
     */
    public function getTasksWithPaging($uProjectId, $uOffset = 0, $uLimit = 20)
    {
        $tResult = $this->db->createQuery()
            ->setTable('tasks')
            ->setFields('*')
            ->setOffset($uOffset)
            ->setLimit($uLimit)
            ->setWhere(array('project=:projectid'))
            ->addParameter('projectid', $uProjectId)
            ->get()
            ->all();

        return $tResult;
    }

    /**
     * @ignore
     */
    public function getTasksOf($uUserId)
    {
        return $this->db->createQuery()
            ->setTable('tasks t')
            ->joinTable('projects p', 'p.id=t.project', 'LEFT')
            ->addField('t.*, p.name AS projectname, p.title AS projecttitle')
            ->setWhere(array('t.assignee=:assignee'))
            ->setGroupBy('t.id')
            ->addParameter('assignee', $uUserId)
            ->get()
            ->allWithKey('id');
    }

    /**
     * @ignore
     */
    public function get($uId)
    {
        $tResult = $this->db->createQuery()
            ->setTable('tasks')
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
            ->setTable('tasks')
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
            ->setTable('tasks')
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
            ->setTable('tasks')
            ->setWhere(array('id=:id'))
            ->addParameter('id', $uId)
            ->setLimit(1)
            ->delete()
            ->execute();

        return $tResult;
    }
}
