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
    public function getAllTasks($uProjectId)
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
    public function getAllTasksCount($uProjectId)
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
    public function getAllTasksWithPaging($uProjectId, $uOffset = 0, $uLimit = 20)
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
    public function getTasks($uProjectId)
    {
        return $this->db->createQuery()
            ->setTable('tasks')
            ->addField('*')
            ->setWhere(array('project=:projectid', _AND, '((SELECT type FROM constants WHERE id=tasks.status) = \'open_task_type\')'))
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
            ->setWhere(array('project=:projectid', _AND, '((SELECT type FROM constants WHERE id=tasks.status) = \'open_task_type\')'))
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
            ->setWhere(array('project=:projectid', _AND, '((SELECT type FROM constants WHERE id=tasks.status) = \'open_task_type\')'))
            ->addParameter('projectid', $uProjectId)
            ->get()
            ->all();

        return $tResult;
    }
    
    /**
     * @ignore
     */
    public function getClosedTasks($uProjectId)
    {
        return $this->db->createQuery()
            ->setTable('tasks')
            ->addField('*')
            ->setWhere(array('project=:projectid', _AND, '((SELECT type FROM constants WHERE id=tasks.status) = \'closed_task_type\')'))
            ->addParameter('projectid', $uProjectId)
            ->get()
            ->allWithKey('id');
    }

    /**
     * @ignore
     */
    public function getClosedTasksCount($uProjectId)
    {
        return $this->db->createQuery()
            ->setTable('tasks')
            ->addField('COUNT(0)')
            ->setWhere(array('project=:projectid', _AND, '((SELECT type FROM constants WHERE id=tasks.status) = \'closed_task_type\')'))
            ->addParameter('projectid', $uProjectId)
            ->get()
            ->scalar();
    }

    /**
     * @ignore
     */
    public function getClosedTasksWithPaging($uProjectId, $uOffset = 0, $uLimit = 20)
    {
        $tResult = $this->db->createQuery()
            ->setTable('tasks')
            ->setFields('*, (SELECT GROUP_CONCAT(revision SEPARATOR \', \') FROM task_revisions WHERE task=tasks.id) AS revisions')
            ->setOffset($uOffset)
            ->setLimit($uLimit)
            ->setWhere(array('project=:projectid', _AND, '((SELECT type FROM constants WHERE id=tasks.status) = \'closed_task_type\')'))
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
            ->setWhere(array('t.assignee=:assignee', _AND, '((SELECT type FROM constants WHERE id=t.status) = \'open_task_type\')'))
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
            ->setFields('*, (SELECT GROUP_CONCAT(revision SEPARATOR \', \') FROM task_revisions WHERE task=tasks.id) AS revisions')
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
    public function insert($insert, $revs)
    {
        $tResult = $this->db->createQuery()
            ->setTable('tasks')
            ->setFields($insert)
            ->insert()
            ->execute(true);
            
        $id=$this->db->lastInsertId();
        
        foreach($revs as $rev) {
			$this->db->createQuery()
				->setTable('task_revisions')
				->setFields(array(
					'revision'	=> (int)$rev,
					'task'	    => $id,
                    'relation'  => 'related'
				))
				->insert()
				->execute(true);
		}

        return $tResult;
    }

    /**
     * @ignore
     */
    public function update($id, $update, $revs)
    {
        $tResult = $this->db->createQuery()
            ->setTable('tasks')
            ->setFields($update)
            ->addParameter('id', $id)
            ->setWhere(array('id=:id'))
            ->setLimit(1)
            ->update()
            ->execute();
            
        $this->db->createQuery()
            ->setTable('task_revisions')
            ->setWhere(array('task=:id'))
            ->addParameter('id', $id)
            ->delete()
            ->execute();
            
        foreach($revs as $rev) {
			$this->db->createQuery()
				->setTable('task_revisions')
				->setFields(array(
					'revision'	=> (int)$rev,
					'task'	    => $id,
                    'relation'  => 'related'
				))
				->insert()
				->execute(true);
		}

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
