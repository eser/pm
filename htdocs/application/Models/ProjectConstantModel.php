<?php

namespace App\Models;

use Scabbia\Extensions\Models\Model;
use Scabbia\Extensions\I18n\I18n;

/**
 * @ignore
 */
class ProjectConstantModel extends Model
{
    /**
     * @ignore
     */
    public $types;


    /**
     * @ignore
     */
    public function __construct()
    {
        parent::__construct();

        $this->types = array(
            'milestone_type' => I18n::_('Milestone'),
            'section_type' => I18n::_('Section')
        );
    }

    /**
     * @ignore
     */
    public function getAllConstants()
    {
        return $this->db->createQuery()
            ->setTable('project_constants')
            ->addField('*')
            ->setOrderBy('type ASC')
            ->get()
            ->allWithKey('id');
    }

    /**
     * @ignore
     */
    public function getConstants($uProjectId)
    {
        return $this->db->createQuery()
            ->setTable('project_constants')
            ->addField('*')
            ->addParameter('project', $uProjectId)
            ->setWhere(array('project=:project'))
            ->setOrderBy('type ASC')
            ->get()
            ->allWithKey('id');
    }

    /**
     * @ignore
     */
    public function getConstantsCount($uProjectId)
    {
        return $this->db->createQuery()
            ->setTable('project_constants')
            ->addField('COUNT(0)')
            ->addParameter('project', $uProjectId)
            ->setWhere(array('project=:project'))
            ->get()
            ->scalar();
    }

    /**
     * @ignore
     */
    public function getConstantsWithPaging($uProjectId, $uOffset = 0, $uLimit = 20)
    {
        $tResult = $this->db->createQuery()
            ->setTable('project_constants')
            ->setFields('*')
            ->setOffset($uOffset)
            ->setLimit($uLimit)
            ->addParameter('project', $uProjectId)
            ->setWhere(array('project=:project'))
            ->setOrderBy('type ASC')
            ->get()
            ->all();

        return $tResult;
    }

    /**
     * @ignore
     */
    public function getConstantsByType($uProjectId, $uType)
    {
        return $this->db->createQuery()
            ->setTable('project_constants')
            ->addField('*')
            ->addParameter('type', $uType)
            ->addParameter('project', $uProjectId)
            ->setWhere(array('project=:project', _AND, 'type=:type'))
            ->get()
            ->allWithKey('id');
    }

    /**
     * @ignore
     */
    public function get($uId)
    {
        $tResult = $this->db->createQuery()
            ->setTable('project_constants')
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
            ->setTable('project_constants')
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
            ->setTable('project_constants')
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
            ->setTable('project_constants')
            ->setWhere(array('id=:id'))
            ->addParameter('id', $uId)
            ->setLimit(1)
            ->delete()
            ->execute();

        return $tResult;
    }
}
