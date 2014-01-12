<?php

namespace App\Models;

use Scabbia\Extensions\Models\Model;

/**
 * @ignore
 */
class ConstantModel extends Model
{
    /**
     * @ignore
     */
    public $types = array(
        'task_type' => 'Task Type',
        'project_type' => 'Project Type',
        'open_task_type' => 'Open Task Type',
        'closed_task_type' => 'Closed Task Type',
        'priority_type' => 'Priority Type'
    );


    /**
     * @ignore
     */
    public function getConstants()
    {
        return $this->db->createQuery()
            ->setTable('constants')
            ->addField('*')
            ->setOrderBy('type ASC, id ASC')
            ->get()
            ->allWithKey('id');
    }

    /**
     * @ignore
     */
    public function getConstantsCount()
    {
        return $this->db->createQuery()
            ->setTable('constants')
            ->addField('COUNT(0)')
            ->get()
            ->scalar();
    }

    /**
     * @ignore
     */
    public function getConstantsWithPaging($uOffset = 0, $uLimit = 20)
    {
        $tResult = $this->db->createQuery()
            ->setTable('constants')
            ->setFields('*')
            ->setOrderBy('type ASC, id ASC')
            ->setOffset($uOffset)
            ->setLimit($uLimit)
            ->get()
            ->all();

        return $tResult;
    }

    /**
     * @ignore
     */
    public function getConstantsByType($uType)
    {
        return $this->db->createQuery()
            ->setTable('constants')
            ->addField('*')
            ->addParameter('type', $uType)
            ->setWhere(array('type=:type'))
            ->setOrderBy('id ASC')
            ->get()
            ->allWithKey('id');
    }

    /**
     * @ignore
     */
    public function get($uId)
    {
        $tResult = $this->db->createQuery()
            ->setTable('constants')
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
            ->setTable('constants')
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
            ->setTable('constants')
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
            ->setTable('constants')
            ->setWhere(array('id=:id'))
            ->addParameter('id', $uId)
            ->setLimit(1)
            ->delete()
            ->execute();

        return $tResult;
    }
}
