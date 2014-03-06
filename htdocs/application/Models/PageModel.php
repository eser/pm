<?php

namespace App\Models;

use Scabbia\Extensions\Models\Model;

/**
 * @ignore
 */
class PageModel extends Model
{
    /**
     * @ignore
     */
    public $types = array(
        'passive'     => 'Passive',
        'unlisted'    => 'Unlisted',
        'menu'        => 'Menu'
    );


    /**
     * @ignore
     */
    public function getPages()
    {
        return $this->db->createQuery()
            ->setTable('pages')
            ->addField('*')
            ->get()
            ->allWithKey('id');
    }

    /**
     * @ignore
     */
    public function getPagesCount()
    {
        return $this->db->createQuery()
            ->setTable('pages')
            ->addField('COUNT(0)')
            ->get()
            ->scalar();
    }

    /**
     * @ignore
     */
    public function getPagesWithPaging($uOffset = 0, $uLimit = 20)
    {
        $tResult = $this->db->createQuery()
            ->setTable('pages')
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
    public function get($uId)
    {
        $tResult = $this->db->createQuery()
            ->setTable('pages')
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
    public function getByName($uName, $uTypeFilter)
    {
        $tResult = $this->db->createQuery()
            ->setTable('pages')
            ->setFields('*')
            ->setWhere(array('name=:name', _AND, array('type', _IN, $uTypeFilter)))
            ->setLimit(1)
            ->addParameter('name', $uName)
            ->get()
            ->row();

        return $tResult;
    }

    /**
     * @ignore
     */
    public function getByNameAndProject($uName, $uProjectId, $uTypeFilter)
    {
        $tResult = $this->db->createQuery()
            ->setTable('pages')
            ->setFields('*')
            ->setWhere(array('name=:name', _AND, 'project=:project', _AND, array('type', _IN, $uTypeFilter)))
            ->setLimit(1)
            ->addParameter('name', $uName)
            ->addParameter('project', $uProjectId)
            ->get()
            ->row();

        return $tResult;
    }

    /**
     * @ignore
     */
    public function getPagesOf($uProjectId, $uTypeFilter)
    {
        $tResult = $this->db->createQuery()
            ->setTable('pages')
            ->setFields('*')
            ->setWhere(array('project=:project', _AND, array('type', _IN, $uTypeFilter)))
            ->addParameter('project', $uProjectId)
            ->get()
            ->all();

        return $tResult;
    }

    /**
     * @ignore
     */
    public function insert($insert)
    {
        $tResult = $this->db->createQuery()
            ->setTable('pages')
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
            ->setTable('pages')
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
            ->setTable('pages')
            ->setWhere(array('id=:id'))
            ->addParameter('id', $uId)
            ->setLimit(1)
            ->delete()
            ->execute();

        return $tResult;
    }
}
