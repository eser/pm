<?php

namespace App\Controllers;

use App\Includes\PmController;
use Scabbia\Extensions\I18n\I18n;
use Scabbia\Extensions\Helpers\Arrays;

/**
 * @ignore
 */
class Home extends PmController
{
    /**
     * @ignore
     */
    public function index()
    {
        $this->load('App\\Models\\UserModel');
        $tGroupIds = $this->userModel->getGroups($this->userBindings->user['id']);

        $this->load('App\\Models\\TaskModel');

        $tTasks = $this->taskModel->getTasksAllOf($this->userBindings->user['id'], $tGroupIds);
        $this->set('tasks', $tTasks);

        $this->load('App\\Models\\ConstantModel');
        $tConstants = $this->constantModel->getConstants();
        $this->set('constants', Arrays::categorize($tConstants, 'type', true));

        $this->load('App\\Models\\ProjectConstantModel');
        $tProjectConstants = $this->projectConstantModel->getAllConstants();
        $this->set('projectConstants', Arrays::categorize($tProjectConstants, 'type', true));

        $this->view();
    }

    /**
     * @ignore
     */
    public function projects()
    {
        $this->load('App\\Models\\ProjectModel');

        $tProjects = $this->projectModel->getProjectsOf($this->userBindings->user['id']);
        $this->set('projects', $tProjects);

        $this->breadcrumbs[I18n::_('My Projects')] = array(null, 'home/projects');

        $this->view();
    }

    /**
     * @ignore
     */
    public function tasks()
    {
        $this->load('App\\Models\\TaskModel');

        $tTasks = $this->taskModel->getTasksOf($this->userBindings->user['id']);
        $this->set('tasks', $tTasks);

        $this->load('App\\Models\\ConstantModel');
        $tConstants = $this->constantModel->getConstants();
        $this->set('constants', Arrays::categorize($tConstants, 'type', true));

        $this->load('App\\Models\\ProjectConstantModel');
        $tProjectConstants = $this->projectConstantModel->getAllConstants();
        $this->set('projectConstants', Arrays::categorize($tProjectConstants, 'type', true));

        $this->breadcrumbs[I18n::_('Assigned Tasks')] = array(null, 'home/tasks');

        $this->view();
    }
}
