<?php

namespace App\Controllers;

use App\Includes\PmController;
use App\Includes\ViewHelpers;
use Scabbia\Config;
use Scabbia\Extensions\Helpers\Date;
use Scabbia\Extensions\Helpers\String;
use Scabbia\Extensions\I18n\I18n;
use Scabbia\Extensions\Helpers\Arrays;
use Scabbia\Extensions\Session\Session;
use Scabbia\Extensions\Validation\Validation;
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

        $this->load('App\\Models\\ProjectModel');

        $tProjects = $this->projectModel->getProjectsOf($this->userBindings->user['id']);
        $this->set('projects', $tProjects);

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

    /**
     * @ignore
     */
    public function settings()
    {
        if (Request::$method === 'post') {
            $tData = array(
                'username' => $this->userBindings->user['username'],
                'password' => Request::post('password', null, null),
                'password2' => Request::post('password2', null, null),
                'name' => Request::post('name', null, null),
                'phone' => Request::post('phone', null, null),
                'email' => Request::post('email', null, null),
                'page' => Request::post('page', null, null),
                'scmid' => Request::post('scmid', null, null),
                'bio' => Request::post('bio', null, null),
                'language' => Request::post('language', null, null),
                'sendmails' => Request::post('sendmails', null, null)
            );

            Validation::addRule('name')->isRequired()->errorMessage(I18n::_('Name field is required.'));
            // Validation::addRule('password')->isRequired()->errorMessage(I18n::_('Password field is required.'));
            Validation::addRule('email')->isEmail()->errorMessage(I18n::_('E-mail field should be filled in valid e-mail format.'));
            Validation::addRule('password')->isEqual($tData['password2'])->errorMessage(I18n::_('Passwords should match.'));

            if (!Validation::validate($tData)) {
                Session::set(
                    'alert',
                    array(
                        'error',
                        implode('<br />', Validation::getErrorMessages(true))
                    )
                );
            } else {
                $this->load('App\\Models\\UserModel');

                unset($tData['username']);
                if (strlen($tData['password']) === 0) {
                    unset($tData['password']);
                }
                unset($tData['password2']);

                $this->userModel->update(
                    $this->userBindings->user['id'],
                    $tData
                );

                $this->userBindings->setUserFromDatabase($this->userBindings->user['id']);

                Session::set(
                    'alert',
                    array(
                        'success',
                        I18n::_('Record updated.')
                    )
                );

                $tData['username'] = $this->userBindings->user['username'];
                $tData['password'] = '';
                $tData['password2'] = '';
            }

        } else {
            $tData = $this->userBindings->user;
            $tData['password'] = '';
            $tData['password2'] = '';
        }

        $this->set('data', $tData);

        $this->breadcrumbs[I18n::_('Settings')] = array(null, 'home/settings');

        $this->view();
    }
}
