<?php

namespace App\Controllers;

use Scabbia\Extensions\Helpers\Date;
use Scabbia\Extensions\Validation\Validation;
use Scabbia\Extensions\I18n\I18n;
use Scabbia\Extensions\Http\Http;
use Scabbia\Extensions\Session\Session;
use Scabbia\Extensions\Helpers\String;
use Scabbia\Request;
use App\Includes\PmController;

/**
 * @ignore
 */
class Projects extends PmController
{
    /**
     * @ignore
     */
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs['Projects'] = array(null, 'projects');
    }

    /**
     * @ignore
     */
    public function index($uPage = 1)
    {
        $tPageSize = 25;

        $tPage = $uPage - 1;
        if ($tPage < 0) {
            $tPage = 0;
        }

        $this->load('App\\Models\\ProjectModel');

        $this->set('data', $this->projectModel->getProjectsWithPaging($tPage * $tPageSize, $tPageSize));
        $this->set('dataCount', $this->projectModel->getProjectsCount());

        $this->set('pageSize', $tPageSize);
        $this->set('page', $tPage);

        $this->load('App\\Models\\ConstantModel');
        $tProjectTypes = $this->constantModel->getConstantsByType('project_type');

        $this->set('projectTypes', $tProjectTypes);


        $this->loadMenu();
        $this->view();
    }

    /**
     * @ignore
     */
    public function add()
    {
        $this->load('App\\Models\\ConstantModel');
        $tProjectTypes = $this->constantModel->getConstantsByType('project_type');

        if (Request::$method === 'post') {
            $tData = array(
                'name' => String::slug(Request::post('name', null, null)),
                'title' => Request::post('title', null, null),
                'subtitle' => Request::post('subtitle', null, null),
                'shortdescription' => Request::post('shortdescription', null, null),
                'description' => Request::post('description', null, null),
                'parent' => Request::post('parent', null, null),
                'type' => Request::post('type', null, null),
                'sourceforge' => Request::post('sourceforge', null, null),
                'public' => Request::post('public', null, null),
                'license' => Request::post('license', null, null),

                'created' => Date::toDb(time())
            );

            Validation::addRule('name')->isRequired()->errorMessage(I18n::_('Name field is required.'));
            Validation::addRule('title')->isRequired()->errorMessage(I18n::_('Title field is required.'));
            Validation::addRule('subtitle')->isRequired()->errorMessage(I18n::_('Subtitle field is required.'));
            Validation::addRule('shortdescription')->isRequired()->errorMessage(I18n::_('Short Description field is required.'));
            Validation::addRule('description')->isRequired()->errorMessage(I18n::_('Description is required.'));

            if (!Validation::validate($tData)) {
                Session::set(
                    'alert',
                    array(
                        'error',
                        implode('<br />', Validation::getErrorMessages(true))
                    )
                );
            } else {
                $this->load('App\\Models\\ProjectModel');

                $tId = $this->projectModel->insert($tData);

                Session::set(
                    'alert',
                    array(
                        'success',
                        'Record added.'
                    )
                );

                // redirect to newly created
                Http::redirect('projects/edit/' . $tId, true);
                return;
            }
        } else {
            $tData = array(
                'name' => '',
                'title' => '',
                'subtitle' => '',
                'shortdescription' => '',
                'description' => '',
                'parent' => null,
                'type' => '',
                'sourceforge' => '',
                'public' => '',
                'license' => ''
            );
        }

        $this->set('data', $tData);
        $this->set('projectTypes', $tProjectTypes);

        $this->breadcrumbs['Add Project'] = array(null, 'projects/add');

        $this->loadMenu();
        $this->view();
    }

    /**
     * @ignore
     */
    public function edit($uId)
    {
        $this->load('App\\Models\\ConstantModel');
        $tProjectTypes = $this->constantModel->getConstantsByType('project_type');

        $this->load('App\\Models\\ProjectModel');

        $tOriginalData = $this->projectModel->get($uId);
        if ($tOriginalData === false) {
            return false;
        }

        if (Request::$method === 'post') {
            $tData = array(
                'name' => String::slug(Request::post('name', null, null)),
                'title' => Request::post('title', null, null),
                'subtitle' => Request::post('subtitle', null, null),
                'shortdescription' => Request::post('shortdescription', null, null),
                'description' => Request::post('description', null, null),
                'parent' => Request::post('parent', null, null),
                'type' => Request::post('type', null, null),
                'sourceforge' => Request::post('sourceforge', null, null),
                'public' => Request::post('public', null, null),
                'license' => Request::post('license', null, null)
            );

            Validation::addRule('name')->isRequired()->errorMessage(I18n::_('Name field is required.'));
            Validation::addRule('title')->isRequired()->errorMessage(I18n::_('Title field is required.'));
            Validation::addRule('subtitle')->isRequired()->errorMessage(I18n::_('Subtitle field is required.'));
            Validation::addRule('shortdescription')->isRequired()->errorMessage(I18n::_('Short Description field is required.'));
            Validation::addRule('description')->isRequired()->errorMessage(I18n::_('Description is required.'));

            if (!Validation::validate($tData)) {
                Session::set(
                    'alert',
                    array(
                        'error',
                        implode('<br />', Validation::getErrorMessages(true))
                    )
                );
            } else {
                $this->projectModel->update(
                    $uId,
                    $tData
                );

                Session::set(
                    'alert',
                    array(
                        'success',
                        'Record updated.'
                    )
                );
            }
        } else {
            $tData = $tOriginalData;
        }

        $this->set('id', $uId);
        $this->set('data', $tData);
        $this->set('projectTypes', $tProjectTypes);

        $this->breadcrumbs['Edit Project'] = array(null, 'projects/edit/' . $uId);

        $this->loadMenu();
        $this->view();
    }

    /**
     * @ignore
     */
    public function remove($uId)
    {
        $this->load('App\\Models\\ProjectModel');

        $tOriginalData = $this->projectModel->get($uId);
        if ($tOriginalData === false) {
            return false;
        }

        $this->projectModel->delete(
            $uId
        );

        Session::set(
            'alert',
            array(
                'success',
                'Record removed.'
            )
        );

        // redirect to list
        Http::redirect('projects', true);
        return;
    }

    /**
     * @ignore
     */
    public function show($uId)
    {
        $this->load('App\\Models\\ProjectModel');

        $tProject = $this->projectModel->get($uId);

        $this->set('id', $uId);
        $this->set('project', $tProject);

        $this->breadcrumbs[$tProject['title']] = array(null, 'projects/show/' . $tProject['id']);

        $this->view();
    }

    /**
     * @ignore
     */
    public function newtask($uId)
    {
        $this->load('App\\Models\\ProjectModel');

        $tProject = $this->projectModel->get($uId);

        $this->set('id', $uId);
        $this->set('project', $tProject);

        $this->breadcrumbs[$tProject['title']] = array(null, 'projects/show/' . $tProject['id']);
        $this->breadcrumbs['New Task'] = array(null, 'projects/newtask/' . $tProject['id']);

        $this->view();
    }

    /**
     * @ignore
     */
    private function loadMenu()
    {
        $this->load('App\\Models\\ProjectModel');

        $tProjects = $this->projectModel->getProjects();

        foreach ($tProjects as &$tRow) {
            $tRow['displayname'] = $tRow['name'] . ' (' . $tRow['title'] . ')';
        }

        $this->set('projects', $tProjects);
    }
}
