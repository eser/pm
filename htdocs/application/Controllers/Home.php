<?php

namespace App\Controllers;

use App\Includes\PmController;
use App\Includes\ViewHelpers;
use Scabbia\Extensions\Helpers\Date;
use Scabbia\Extensions\Helpers\String;
use Scabbia\Extensions\I18n\I18n;
use Scabbia\Extensions\Helpers\Arrays;
use Scabbia\Request;

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

        $tCalendar = array();

        $tCalendarMonth = Request::get('month', date('m'));
        $tCalendarYear = Request::get('year', date('Y'));

        foreach ($tTasks as $tTask) {
            if ($tTask['startdate'] !== null) {
                $tStartDate = Date::fromDb($tTask['startdate']);
                if (date('m.Y', $tStartDate) === $tCalendarMonth . '.' . $tCalendarYear) {
                    $tDay = (int)date('d', $tStartDate);
                    if (!isset($tCalendar[$tDay])) {
                        $tCalendar[$tDay] = array();
                    }

                    $tCalendar[$tDay][] =
                        ViewHelpers::printProjectId($tTask['project'], $tTask['projectname'], $tTask['projecttitle']) .
                        '<br /><strong>' . I18n::_('Start') . '</strong>: ' . $tTask['subject'];
                }
            }

            if ($tTask['duedate'] !== null) {
                $tDueDate = Date::fromDb($tTask['duedate']);
                if (date('m.Y', $tDueDate) === $tCalendarMonth . '.' . $tCalendarYear) {
                    $tDay = (int)date('d', $tDueDate);
                    if (!isset($tCalendar[$tDay])) {
                        $tCalendar[$tDay] = array();
                    }

                    $tCalendar[$tDay][] =
                        ViewHelpers::printProjectId($tTask['project'], $tTask['projectname'], $tTask['projecttitle']) .
                        '<br /><strong>' . I18n::_('Due Date') . '</strong>: ' . $tTask['subject'];
                }
            }
        }

        $this->set('calendar', $tCalendar);
        $this->set('calendarMonth', $tCalendarMonth);
        $this->set('calendarYear', $tCalendarYear);

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
