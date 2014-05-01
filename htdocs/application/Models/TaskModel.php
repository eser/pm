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
            ->setTable('tasks t')
            ->joinTable('constants c', 'c.id=t.status', 'LEFT')
            ->addField('t.*')
            ->setWhere(array('t.project=:projectid', _AND, array('c.type IS NULL', _OR, 'c.type = \'open_task_type\'')))
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
            ->setTable('tasks t')
            ->joinTable('constants c', 'c.id=t.status', 'LEFT')
            ->addField('COUNT(0)')
            ->setWhere(array('t.project=:projectid', _AND, array('c.type IS NULL', _OR, 'c.type = \'open_task_type\'')))
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
            ->setTable('tasks t')
            ->joinTable('constants c', 'c.id=t.status', 'LEFT')
            ->setFields('t.*')
            ->setOffset($uOffset)
            ->setLimit($uLimit)
            ->setWhere(array('t.project=:projectid', _AND, array('c.type IS NULL', _OR, 'c.type = \'open_task_type\'')))
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
            ->setTable('tasks t')
            ->joinTable('constants c', 'c.id=t.status', 'LEFT')
            ->addField('t.*')
            ->setWhere(array('t.project=:projectid', _AND, 'c.type = \'closed_task_type\''))
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
            ->setTable('tasks t')
            ->joinTable('constants c', 'c.id=t.status', 'LEFT')
            ->addField('COUNT(0)')
            ->setWhere(array('t.project=:projectid', _AND, 'c.type = \'closed_task_type\''))
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
            ->setTable('tasks t')
            ->joinTable('constants c', 'c.id=t.status', 'LEFT')
            ->setFields('t.*')
            ->setOffset($uOffset)
            ->setLimit($uLimit)
            ->setWhere(array('t.project=:projectid', _AND, 'c.type = \'closed_task_type\''))
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
    public function getTasksAllOf($uUserId, $uGroupIds)
    {
        return $this->db->createQuery()
            ->setTable('tasks t')
            ->joinTable('projects p', 'p.id=t.project', 'LEFT')
            ->joinTable('task_relatives tr', 'tr.task=t.id', 'LEFT')
            ->addField('t.*, p.name AS projectname, p.title AS projecttitle')
            ->setWhere(
                array(
                    array(
                        't.assignee=:assignee',
                        _OR,
                        array('tr.type=\'user\'', _AND, 'tr.targetid=:assignee'),
                        _OR,
                        array('tr.type=\'group\'', _AND, array('tr.targetid', _IN, $uGroupIds))
                    ),
                    _AND,
                    '((SELECT type FROM constants WHERE id=t.status) = \'open_task_type\')'
                )
            )
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

    /**
     * @ignore
     */
    public function getRelatives($uTaskId)
    {
        return $this->db->createQuery()
            ->setTable('task_relatives')
            ->addField('*')
            ->setWhere(array('task=:taskid'))
            ->addParameter('taskid', $uTaskId)
            ->get()
            ->all();
    }

    /**
     * @ignore
     */
    public function saveRelatives($uTaskId, $uRelatives)
    {
        $this->db->createQuery()
            ->setTable('task_relatives')
            ->setWhere(array('task=:taskid'))
            ->addParameter('taskid', $uTaskId)
            ->delete()
            ->execute();

        foreach ($uRelatives as $tRelative) {
            $this->db->createQuery()
                ->setTable('task_relatives')
                ->setFields(array(
                    'task'	    => $uTaskId,
                    'type'	    => $tRelative['type'],
                    'targetid'  => $tRelative['targetid']
                ))
                ->insert()
                ->execute(true);
        }
    }
}
