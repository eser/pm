<?php

namespace App\Controllers;

use Scabbia\Extensions\Helpers\Arrays;
use Scabbia\Extensions\Helpers\Date;
use Scabbia\Extensions\Mime\Mime;
use Scabbia\Extensions\Validation\Validation;
use Scabbia\Extensions\I18n\I18n;
use Scabbia\Extensions\Http\Http;
use Scabbia\Extensions\Session\Session;
use Scabbia\Extensions\Helpers\String;
use Scabbia\Io;
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

        $this->breadcrumbs[I18n::_('Projects')] = array(null, 'projects');
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

        if ($this->userBindings->user['roleadminister'] !== '1') {
            $this->set('data', $this->projectModel->getProjectsOfWithPaging($this->userBindings->user['id'], $tPage * $tPageSize, $tPageSize));
            $this->set('dataCount', $this->projectModel->getProjectsOfCount($this->userBindings->user['id']));
        } else {
            $this->set('data', $this->projectModel->getProjectsWithPaging($tPage * $tPageSize, $tPageSize));
            $this->set('dataCount', $this->projectModel->getProjectsCount());
        }

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
            $tHTMLConfig = \HTMLPurifier_Config::createDefault();
            $tPurifier = new \HTMLPurifier($tHTMLConfig);
            $tDescription = $tPurifier->purify(Request::post('description', null, null));

            $tData = array(
                'name' => String::slug(Request::post('title', null, null)),
                'title' => Request::post('title', null, null),
                'subtitle' => Request::post('subtitle', null, null),
                'shortdescription' => Request::post('shortdescription', null, null),
                'description' => $tDescription,
                'parent' => Request::post('parent', null, null),
                'type' => Request::post('type', null, null),
                'sourceforge' => Request::post('sourceforge', '0', null),
                'public' => Request::post('public', '0', null),
                'license' => Request::post('license', null, null),

                'created' => Date::toDb(time()),
                'owner' => $this->userBindings->user['id']
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
                        I18n::_('Record added.')
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
                'sourceforge' => '0',
                'public' => '0',
                'license' => ''
            );
        }

        $this->set('data', $tData);
        $this->set('projectTypes', $tProjectTypes);

        $this->breadcrumbs[I18n::_('Add Project')] = array(null, 'projects/add');

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
            $tHTMLConfig = \HTMLPurifier_Config::createDefault();
            $tPurifier = new \HTMLPurifier($tHTMLConfig);
            $tDescription = $tPurifier->purify(Request::post('description', null, null));

            $tData = array(
                'name' => String::slug(Request::post('title', null, null)),
                'title' => Request::post('title', null, null),
                'subtitle' => Request::post('subtitle', null, null),
                'shortdescription' => Request::post('shortdescription', null, null),
                'description' => $tDescription,
                'parent' => Request::post('parent', null, null),
                'type' => Request::post('type', null, null),
                'sourceforge' => Request::post('sourceforge', '0', null),
                'public' => Request::post('public', '0', null),
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
                        I18n::_('Record updated.')
                    )
                );
            }
        } else {
            $tData = $tOriginalData;
        }

        $this->set('projectId', $uId);
        $this->set('data', $tData);
        $this->set('projectTypes', $tProjectTypes);

        $this->breadcrumbs[I18n::_('Edit Project')] = array(null, 'projects/edit/' . $uId);

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
                I18n::_('Record removed.')
            )
        );

        // redirect to list
        Http::redirect('projects', true);
        return;
    }

    /**
     * @ignore
     */
    public function members($uProjectId, $uSubpage = 'index', $id = 0)
    {
        // Auth::checkRedirect('user');
        $this->load('App\\Models\\ProjectModel');

        $tProject = $this->projectModel->get($uProjectId);
        if ($tProject === false) {
            return false;
        }

        $this->loadPages($uProjectId);

        $this->breadcrumbs[$tProject['title']] = array(null, 'projects/show/' . $uProjectId);
        $this->breadcrumbs[I18n::_('Members')] = array(null, 'projects/members/' . $uProjectId);

        $this->set('projectId', $uProjectId);

        if ($uSubpage === 'index') {
            return $this->members_index($uProjectId, $id);
        } elseif ($uSubpage === 'add') {
            return $this->members_add($uProjectId);
        } elseif ($uSubpage === 'edit') {
            return $this->members_edit($uProjectId, $id);
        } elseif ($uSubpage === 'remove') {
            return $this->members_remove($uProjectId, $id);
        }

        return false;
    }

    /**
     * @ignore
     */
    public function constants($uProjectId, $uSubpage = 'index', $id = 0)
    {
        // Auth::checkRedirect('user');
        $this->load('App\\Models\\ProjectModel');

        $tProject = $this->projectModel->get($uProjectId);
        if ($tProject === false) {
            return false;
        }

        $this->loadPages($uProjectId);

        $this->breadcrumbs[$tProject['title']] = array(null, 'projects/show/' . $uProjectId);
        $this->breadcrumbs[I18n::_('Constants')] = array(null, 'projects/constants/' . $uProjectId);

        $this->set('projectId', $uProjectId);

        if ($uSubpage === 'index') {
            return $this->constants_index($uProjectId, $id);
        } elseif ($uSubpage === 'add') {
            return $this->constants_add($uProjectId);
        } elseif ($uSubpage === 'edit') {
            return $this->constants_edit($uProjectId, $id);
        } elseif ($uSubpage === 'remove') {
            return $this->constants_remove($uProjectId, $id);
        }

        return false;
    }

    /**
     * @ignore
     */
    public function tasks($uProjectId, $uSubpage = 'index', $id = 0)
    {
        // Auth::checkRedirect('user');
        $this->load('App\\Models\\ProjectModel');

        $tProject = $this->projectModel->get($uProjectId);
        if ($tProject === false) {
            return false;
        }

        $this->loadPages($uProjectId);

        $this->breadcrumbs[$tProject['title']] = array(null, 'projects/show/' . $uProjectId);
        $this->breadcrumbs[I18n::_('Tasks')] = array(null, 'projects/tasks/' . $uProjectId);

        $this->set('projectId', $uProjectId);

        if ($uSubpage === 'index') {
            return $this->tasks_index($uProjectId, $id);
        } elseif ($uSubpage === 'add') {
            return $this->tasks_add($uProjectId);
        } elseif ($uSubpage === 'edit') {
            return $this->tasks_edit($uProjectId, $id);
        } elseif ($uSubpage === 'remove') {
            return $this->tasks_remove($uProjectId, $id);
        } elseif ($uSubpage === 'detail') {
            return $this->tasks_detail($uProjectId, $id);
        } elseif ($uSubpage === 'closed') {
            return $this->tasks_closed($uProjectId, $id);
        } elseif ($uSubpage === 'addnote') {
            return $this->tasks_addnote($uProjectId, $id);
        } elseif ($uSubpage === 'addfile') {
            return $this->tasks_addfile($uProjectId, $id);
        }

        return false;
    }

    /**
     * @ignore
     */
    public function show($uId)
    {
        $this->load('App\\Models\\ProjectModel');

        $tProject = $this->projectModel->get($uId);
        if ($tProject === false) {
            return false;
        }

        $this->loadPages($uId);

        $this->set('projectId', $uId);
        $this->set('project', $tProject);

        $this->breadcrumbs[$tProject['title']] = array(null, 'projects/show/' . $tProject['id']);

        $this->load('App\\Models\\TaskModel');

        $tData = $this->taskModel->getAllTasks($tProject['id']);
        $tCategorizedData = Arrays::categorize($tData, 'milestone');
        $this->set('data', $tCategorizedData);

        $this->load('App\\Models\\ConstantModel');
        $tConstants = $this->constantModel->getConstants();
        $this->set('constants', Arrays::categorize($tConstants, 'type', true));

        $this->load('App\\Models\\ProjectConstantModel');
        $tProjectConstants = $this->projectConstantModel->getConstants($tProject['id']);
        $this->set('projectConstants', Arrays::categorize($tProjectConstants, 'type', true));

        $this->load('App\\Models\\ProjectMemberModel');
        $this->set('users', $this->projectMemberModel->getMembersWithDetails($tProject['id']));

        $this->view();
    }

    /**
     * @ignore
     */
    public function pages($uId, $uPageName)
    {
        $this->load('App\\Models\\ProjectModel');

        $tProject = $this->projectModel->get($uId);
        if ($tProject === false) {
            return false;
        }

        $this->load('App\\Models\\PageModel');
        $tPage = $this->pageModel->getByNameAndProject($uPageName, $uId, array('unlisted', 'menu'));
        if ($tPage === false) {
            return false;
        }

        $this->loadPages($uId);

        $this->breadcrumbs[$tProject['title']] = array(null, 'projects/show/' . $tProject['id']);
        $this->breadcrumbs[$tPage['title']] = array(null, 'projects/pages/' . $tProject['id'] . '/' . $tPage['name']);

        $this->set('projectId', $uId);
        $this->set('project', $tProject);
        $this->set('page', $tPage);

        $this->view();
    }

    /**
     * @ignore
     */
    private function loadMenu()
    {
        $this->load('App\\Models\\ProjectModel');

        if ($this->userBindings->user['roleadminister'] !== '1') {
            $tProjects = $this->projectModel->getProjectsOf($this->userBindings->user['id']);
        } else {
            $tProjects = $this->projectModel->getProjects();
        }

        foreach ($tProjects as &$tRow) {
            $tRow['displayname'] = $tRow['name'] . ' (' . $tRow['title'] . ')';
        }

        $this->set('projects', $tProjects);
    }

    /**
     * @ignore
     */
    private function loadPages($uProjectId)
    {
        $this->load('App\\Models\\PageModel');

        $tPages = $this->pageModel->getPagesOf($uProjectId, array('menu'));

        $this->set('pages', $tPages);
    }

    /**
     * @ignore
     */
    private function members_index($uProjectId, $uPage = 1)
    {
        $tPageSize = 25;

        $tPage = $uPage - 1;
        if ($tPage < 0) {
            $tPage = 0;
        }

        $this->load('App\\Models\\UserModel');
        $tUsers = $this->userModel->getUsers();
        $this->set('users', $tUsers);

        $this->load('App\\Models\\ConstantModel');
        $tRelationTypes = $this->constantModel->getConstantsByType('project_relation_type');
        $this->set('relationtypes', $tRelationTypes);

        $this->load('App\\Models\\ProjectMemberModel');

        $this->set('data', $this->projectMemberModel->getMembersWithPaging($uProjectId, $tPage * $tPageSize, $tPageSize));
        $this->set('dataCount', $this->projectMemberModel->getMembersCount($uProjectId));

        // $this->set('types', $this->projectConstantModel->types);

        $this->set('pageSize', $tPageSize);
        $this->set('page', $tPage);

        $this->view('projects/members/index.cshtml');
    }

    /**
     * @ignore
     */
    private function members_add($uProjectId)
    {
        $this->load('App\\Models\\UserModel');
        $tUsers = $this->userModel->getUsers();

        $this->load('App\\Models\\ConstantModel');
        $tRelationTypes = $this->constantModel->getConstantsByType('project_relation_type');

        if (Request::$method === 'post') {
            $this->load('App\\Models\\ProjectMemberModel');

            $tData = array(
                'user' => Request::post('user', null, null),
                'relation' => Request::post('relation', null, null),
                'project' => $uProjectId
            );

            Validation::addRule('user')->inKeys($tUsers)->errorMessage(I18n::_('Invalid user.'));
            Validation::addRule('relation')->inKeys($tRelationTypes)->errorMessage(I18n::_('Invalid relation type.'));

            if (!Validation::validate($tData)) {
                Session::set(
                    'alert',
                    array(
                        'error',
                        implode('<br />', Validation::getErrorMessages(true))
                    )
                );
            } else {
                $tId = $this->projectMemberModel->insert($tData);

                Session::set(
                    'alert',
                    array(
                        'success',
                        I18n::_('Record added.')
                    )
                );

                // redirect to newly created
                Http::redirect('projects/members/' . $uProjectId . '/edit/' . $tId, true);
                return;
            }
        } else {
            $tData = array(
                'user' => 0,
                'relation' => ''
            );
        }

        $this->set('users', $tUsers);
        $this->set('relationtypes', $tRelationTypes);
        $this->set('data', $tData);

        $this->breadcrumbs[I18n::_('Members Add')] = array(null, 'projects/members/' . $uProjectId . '/add');

        $this->view('projects/members/add.cshtml');
    }

    /**
     * @ignore
     */
    private function members_edit($uProjectId, $uId)
    {
        $this->load('App\\Models\\UserModel');
        $tUsers = $this->userModel->getUsers();

        $this->load('App\\Models\\ConstantModel');
        $tRelationTypes = $this->constantModel->getConstantsByType('project_relation_type');

        $this->load('App\\Models\\ProjectMemberModel');

        $tOriginalData = $this->projectMemberModel->get($uId);
        if ($tOriginalData === false || $tOriginalData['project'] !== $uProjectId) {
            return false;
        }

        if (Request::$method === 'post') {
            if (Request::post('asNew', 0, 'intval') === 1) {
                $this->members_add($uProjectId);
                return;
            }

            $tData = array(
                'user' => Request::post('user', null, null),
                'relation' => Request::post('relation', null, null)
            );

            Validation::addRule('user')->inKeys($tUsers)->errorMessage(I18n::_('Invalid user.'));
            Validation::addRule('relation')->inKeys($tRelationTypes)->errorMessage(I18n::_('Invalid relation type.'));

            if (!Validation::validate($tData)) {
                Session::set(
                    'alert',
                    array(
                        'error',
                        implode('<br />', Validation::getErrorMessages(true))
                    )
                );
            } else {
                $this->projectMemberModel->update(
                    $uId,
                    $tData
                );

                Session::set(
                    'alert',
                    array(
                        'success',
                        I18n::_('Record updated.')
                    )
                );
            }
        } else {
            $tData = $tOriginalData;
        }

        $this->set('id', $uId);
        $this->set('users', $tUsers);
        $this->set('relationtypes', $tRelationTypes);
        $this->set('data', $tData);

        $this->breadcrumbs[I18n::_('Members Edit')] = array(null, 'projects/members/' . $uProjectId . '/edit/' . $uId);

        $this->view('projects/members/edit.cshtml');
    }

    /**
     * @ignore
     */
    private function members_remove($uProjectId, $uId)
    {
        $this->load('App\\Models\\ProjectMemberModel');

        $tOriginalData = $this->projectMemberModel->get($uId);
        if ($tOriginalData === false || $tOriginalData['project'] !== $uProjectId) {
            return false;
        }

        $this->projectMemberModel->delete(
            $uId
        );

        Session::set(
            'alert',
            array(
                'success',
                I18n::_('Record removed.')
            )
        );

        // redirect to list
        Http::redirect('projects/members/' . $uProjectId, true);
        return;
    }

    /**
     * @ignore
     */
    private function constants_index($uProjectId, $uPage = 1)
    {
        $tPageSize = 25;

        $tPage = $uPage - 1;
        if ($tPage < 0) {
            $tPage = 0;
        }

        $this->load('App\\Models\\ProjectConstantModel');

        $this->set('data', $this->projectConstantModel->getConstantsWithPaging($uProjectId, $tPage * $tPageSize, $tPageSize));
        $this->set('dataCount', $this->projectConstantModel->getConstantsCount($uProjectId));

        $this->set('types', $this->projectConstantModel->types);

        $this->set('pageSize', $tPageSize);
        $this->set('page', $tPage);

        $this->view('projects/constants/index.cshtml');
    }

    /**
     * @ignore
     */
    private function constants_add($uProjectId)
    {
        $this->load('App\\Models\\ProjectConstantModel');

        if (Request::$method === 'post') {
            $tData = array(
                'name' => Request::post('name', null, null),
                'type' => Request::post('type', null, null),
                'project' => $uProjectId
            );

            Validation::addRule('name')->isRequired()->errorMessage(I18n::_('Name field is required.'));
            Validation::addRule('type')->inKeys($this->projectConstantModel->types)->errorMessage(I18n::_('Invalid type.'));

            if (!Validation::validate($tData)) {
                Session::set(
                    'alert',
                    array(
                        'error',
                        implode('<br />', Validation::getErrorMessages(true))
                    )
                );
            } else {
                $tId = $this->projectConstantModel->insert($tData);

                Session::set(
                    'alert',
                    array(
                        'success',
                        I18n::_('Record added.')
                    )
                );

                // redirect to newly created
                Http::redirect('projects/constants/' . $uProjectId . '/edit/' . $tId, true);
                return;
            }
        } else {
            $tData = array(
                'name' => '',
                'type' => ''
            );
        }

        $this->set('data', $tData);
        $this->set('types', $this->projectConstantModel->types);

        $this->breadcrumbs[I18n::_('Constants Add')] = array(null, 'projects/constants/' . $uProjectId . '/add');

        $this->view('projects/constants/add.cshtml');
    }

    /**
     * @ignore
     */
    private function constants_edit($uProjectId, $uId)
    {
        $this->load('App\\Models\\ProjectConstantModel');

        $tOriginalData = $this->projectConstantModel->get($uId);
        if ($tOriginalData === false || $tOriginalData['project'] !== $uProjectId) {
            return false;
        }

        if (Request::$method === 'post') {
            if (Request::post('asNew', 0, 'intval') === 1) {
                $this->constants_add($uProjectId);
                return;
            }

            $tData = array(
                'name' => Request::post('name', null, null),
                'type' => Request::post('type', null, null)
            );

            Validation::addRule('name')->isRequired()->errorMessage(I18n::_('Name field is required.'));
            Validation::addRule('type')->inKeys($this->projectConstantModel->types)->errorMessage(I18n::_('Invalid type.'));

            if (!Validation::validate($tData)) {
                Session::set(
                    'alert',
                    array(
                        'error',
                        implode('<br />', Validation::getErrorMessages(true))
                    )
                );
            } else {
                $this->projectConstantModel->update(
                    $uId,
                    $tData
                );

                Session::set(
                    'alert',
                    array(
                        'success',
                        I18n::_('Record updated.')
                    )
                );
            }
        } else {
            $tData = $tOriginalData;
        }

        $this->set('id', $uId);
        $this->set('data', $tData);
        $this->set('types', $this->projectConstantModel->types);

        $this->breadcrumbs[I18n::_('Constants Edit')] = array(null, 'projects/constants/' . $uProjectId . '/edit/' . $uId);

        $this->view('projects/constants/edit.cshtml');
    }

    /**
     * @ignore
     */
    private function constants_remove($uProjectId, $uId)
    {
        $this->load('App\\Models\\ProjectConstantModel');

        $tOriginalData = $this->projectConstantModel->get($uId);
        if ($tOriginalData === false || $tOriginalData['project'] !== $uProjectId) {
            return false;
        }

        $this->projectConstantModel->delete(
            $uId
        );

        Session::set(
            'alert',
            array(
                'success',
                I18n::_('Record removed.')
            )
        );

        // redirect to list
        Http::redirect('projects/constants/' . $uProjectId, true);
        return;
    }

    /**
     * @ignore
     */
    public function tasks_index($uProjectId, $uPage = 1)
    {
        $this->load('App\\Models\\ProjectModel');

        $tProject = $this->projectModel->get($uProjectId);
        if ($tProject === false) {
            return false;
        }

        $this->set('projectId', $uProjectId);
        $this->set('project', $tProject);

        $tPageSize = 25;

        $tPage = $uPage - 1;
        if ($tPage < 0) {
            $tPage = 0;
        }

        $this->load('App\\Models\\TaskModel');

        $this->set('data', $this->taskModel->getTasksWithPaging($uProjectId, $tPage * $tPageSize, $tPageSize));
        $this->set('dataCount', $this->taskModel->getTasksCount($uProjectId));

        $this->set('pageSize', $tPageSize);
        $this->set('page', $tPage);

        $this->load('App\\Models\\ConstantModel');
        $tConstants = $this->constantModel->getConstants();
        $this->set('constants', Arrays::categorize($tConstants, 'type', true));

        $this->load('App\\Models\\ProjectConstantModel');
        $tProjectConstants = $this->projectConstantModel->getConstants($uProjectId);
        $this->set('projectConstants', Arrays::categorize($tProjectConstants, 'type', true));

        $this->load('App\\Models\\ProjectMemberModel');
        $this->set('users', $this->projectMemberModel->getMembersWithDetails($uProjectId));

        $this->view('projects/tasks/index.cshtml');
    }

    /**
     * @ignore
     */
    public function tasks_closed($uProjectId, $uPage = 1)
    {
        $this->load('App\\Models\\ProjectModel');

        $tProject = $this->projectModel->get($uProjectId);
        if ($tProject === false) {
            return false;
        }

        $this->loadPages($uProjectId);

        $this->set('projectId', $uProjectId);
        $this->set('project', $tProject);

        $tPageSize = 25;

        $tPage = $uPage - 1;
        if ($tPage < 0) {
            $tPage = 0;
        }

        $this->load('App\\Models\\TaskModel');

        $this->set('data', $this->taskModel->getClosedTasksWithPaging($uProjectId, $tPage * $tPageSize, $tPageSize));
        $this->set('dataCount', $this->taskModel->getClosedTasksCount($uProjectId));

        $this->set('pageSize', $tPageSize);
        $this->set('page', $tPage);

        $this->load('App\\Models\\ConstantModel');
        $tConstants = $this->constantModel->getConstants();
        $this->set('constants', Arrays::categorize($tConstants, 'type', true));

        $this->load('App\\Models\\ProjectConstantModel');
        $tProjectConstants = $this->projectConstantModel->getConstants($uProjectId);
        $this->set('projectConstants', Arrays::categorize($tProjectConstants, 'type', true));

        $this->load('App\\Models\\ProjectMemberModel');
        $this->set('users', $this->projectMemberModel->getMembersWithDetails($uProjectId));

        $this->view('projects/tasks/closed.cshtml');
    }

    /**
     * @ignore
     */
    private function tasks_addnote($uProjectId, $uId)
    {
        $this->load('App\\Models\\TaskModel');

        $tOriginalData = $this->taskModel->get($uId);
        if ($tOriginalData === false || $tOriginalData['project'] !== $uProjectId) {
            return false;
        }

        $this->load('App\\Models\\NoteModel');

        $tHTMLConfig = \HTMLPurifier_Config::createDefault();
        $tPurifier = new \HTMLPurifier($tHTMLConfig);

        $tDescription = $tPurifier->purify(Request::post('description', null, null));

        if (strlen(trim($tDescription)) > 0) {
            $tData = array(
                'targetid' => $uId,
                'type' => 'task',
                'description' => $tDescription,
                'deleted' => '0',

                'created' => Date::toDb(time()),
                'user' => $this->userBindings->user['id']
            );

            $this->noteModel->insert(
                $tData
            );

            Session::set(
                'alert',
                array(
                    'success',
                    I18n::_('Note added.')
                )
            );
        }

        // redirect to list
        Http::redirect('projects/tasks/' . $uProjectId . '/detail/' . $uId, true); //  . '#tabnotes'
        return;
    }

    /**
     * @ignore
     */
    private function tasks_addfile($uProjectId, $uId)
    {
        $this->load('App\\Models\\TaskModel');

        $tOriginalData = $this->taskModel->get($uId);
        if ($tOriginalData === false || $tOriginalData['project'] !== $uProjectId) {
            return false;
        }

        $this->load('App\\Models\\FileModel');

        // $tHTMLConfig = \HTMLPurifier_Config::createDefault();
        // $tPurifier = new \HTMLPurifier($tHTMLConfig);

        // $tDescription = $tPurifier->purify(Request::post('description', null, null));
        $tDescription = '';

        if (count($_FILES) > 0) {
            $tFile = array_pop($_FILES);

            $tGeneratedUuid = String::generateUuid();
            $tExtension = String::sanitizeFilename(pathinfo($tFile['name'], PATHINFO_EXTENSION));
            $tMimeType = Mime::getType($tExtension);

            $tPath = 'uploads/' . $uId . '/';
            $tAbsolutePath = Io::translatePath('{base}' . $tPath);
            if (!file_exists($tAbsolutePath)) {
                mkdir($tAbsolutePath, 0777, true);
            }

            $tFilePath = $tPath . $tGeneratedUuid . '.' . $tExtension;
            $tAbsoluteFilePath = $tAbsolutePath . $tGeneratedUuid . '.' . $tExtension;
            move_uploaded_file($tFile['tmp_name'], $tAbsoluteFilePath);

            $tData = array(
                'targetid' => $uId,
                'type' => 'task',
                'filename' => $tFile['name'],
                'mimetype' => $tMimeType,
                'path' => $tFilePath,
                'description' => $tDescription,
                'deleted' => '0',

                'created' => Date::toDb(time()),
                'user' => $this->userBindings->user['id']
            );

            $this->fileModel->insert(
                $tData
            );

            Session::set(
                'alert',
                array(
                    'success',
                    I18n::_('File added.')
                )
            );
        }

        // redirect to list
        Http::redirect('projects/tasks/' . $uProjectId . '/detail/' . $uId, true); //  . '#tabfiles'
        return;
    }

    /**
     * @ignore
     */
    public function tasks_add($uProjectId)
    {
        $this->load('App\\Models\\ProjectModel');

        $tProject = $this->projectModel->get($uProjectId);
        if ($tProject === false) {
            return false;
        }

        if (Request::$method === 'post') {
            $tHTMLConfig = \HTMLPurifier_Config::createDefault();
            $tPurifier = new \HTMLPurifier($tHTMLConfig);

            $tRevisions = Request::post('revisions', null, null);
            $tDueDate = rtrim(Request::post('duedate', '', null));
            $tEndDate = rtrim(Request::post('enddate', '', null));
            $tDescription = $tPurifier->purify(Request::post('description', null, null));

            $tData = array(
                'project' => $uProjectId,
                'type' => Request::post('type', null, null),
                'section' => Request::post('section', null, null),
                'milestone' => Request::post('milestone', null, null),
                'subject' => Request::post('subject', null, null),
                'description' => $tDescription,
                'status' => Request::post('status', null, null),
                'priority' => Request::post('priority', null, null),
                'progress' => Request::post('progress', '0', null),
                'startdate' => Date::toDb(Request::post('startdate', null, null), 'd/m/Y'),
                'duedate' => ($tDueDate == '') ? null : Date::toDb($tDueDate, 'd/m/Y'),
                'estimatedtime' => Request::post('estimatedtime', null, null),
                'enddate' => ($tEndDate == '') ? null : Date::toDb($tEndDate, 'd/m/Y'),
                'assignee' => Request::post('assignee', null, null),

                'created' => Date::toDb(time()),
                'owner' => $this->userBindings->user['id']
            );

            Validation::addRule('subject')->isRequired()->errorMessage(I18n::_('Subject field is required.'));
            Validation::addRule('description')->isRequired()->errorMessage(I18n::_('Description field is required.'));
            // TODO add more validators

            if (!Validation::validate($tData)) {
                Session::set(
                    'alert',
                    array(
                        'error',
                        implode('<br />', Validation::getErrorMessages(true))
                    )
                );
            } else {
                $this->load('App\\Models\\TaskModel');
               
                $tRevs = explode(',', $tRevisions);
                for ($i = count($tRevs) - 1; $i >= 0; $i--) {
                    $tRevs[$i] = trim($tRevs[$i]);
                }

                $tId = $this->taskModel->insert($tData, $tRevs);

                $tData['revisions'] = $tRevisions;

                $this->load('App\\Models\\LogModel');
                $this->logModel->insert(
                    array(
                        'targetid' => $tId,
                        'user' => $this->userBindings->user['id'],
                        'created' => Date::toDb(time()),
                        'type' => 'task',
                        'serializeddata' => json_encode($tData),
                        'description' => 'Task Created'
                    )
                );

                Session::set(
                    'alert',
                    array(
                        'success',
                        I18n::_('Record added.')
                    )
                );

                // redirect to newly created
                Http::redirect('projects/tasks/' . $uProjectId, true);
                return;
            }
        } else {
            $tData = array(
                'project' => $uProjectId,
                'type' => '',
                'section' => '',
                'milestone' => '',
                'subject' => '',
                'description' => '',
                'status' => '',
                'priority' => null,
                'progress' => '0',
                'startdate' => Date::toDb(time()),
                'duedate' => null,
                'estimatedtime' => '',
                'enddate' => null,
                'assignee' => '',
                'created' => Date::toDb(time()),
                'owner' => $this->userBindings->user['id'],
                'revisions' => ''
            );
        }

        $this->set('projectId', $uProjectId);
        $this->set('project', $tProject);
        $this->set('data', $tData);

        $this->load('App\\Models\\ConstantModel');
        $tConstants = $this->constantModel->getConstants();
        $this->set('constants', Arrays::categorize($tConstants, 'type', true));

        $this->load('App\\Models\\ProjectConstantModel');
        $tProjectConstants = $this->projectConstantModel->getConstants($uProjectId);
        $this->set('projectConstants', Arrays::categorize($tProjectConstants, 'type', true));

        $this->load('App\\Models\\ProjectMemberModel');
        $this->set('users', $this->projectMemberModel->getMembersWithDetails($uProjectId));

        $this->breadcrumbs[I18n::_('New Task')] = array(null, 'projects/tasks/' . $tProject['id'] . '/add');

        $this->view('projects/tasks/add.cshtml');
    }

    /**
     * @ignore
     */
    private function tasks_edit($uProjectId, $uId)
    {
        $this->load('App\\Models\\TaskModel');

        $tOriginalData = $this->taskModel->get($uId);
        if ($tOriginalData === false || $tOriginalData['project'] !== $uProjectId) {
            return false;
        }

        $this->load('App\\Models\\FileModel');
        $this->load('App\\Models\\NoteModel');
        $this->load('App\\Models\\LogModel');

        if (Request::$method === 'post') {
            if (Request::post('asNew', 0, 'intval') === 1) {
                $this->tasks_add($uProjectId);
                return;
            }

            $tDueDate = rtrim(Request::post('duedate', '', null));
            $tEndDate = rtrim(Request::post('enddate', '', null));
            $tRevisions = Request::post('revisions', null, null);

            $tData = array(
                'project' => $uProjectId,
                'type' => Request::post('type', null, null),
                'section' => Request::post('section', null, null),
                'milestone' => Request::post('milestone', null, null),
                'subject' => Request::post('subject', null, null),
                'description' => Request::post('description', null, null),
                'status' => Request::post('status', null, null),
                'priority' => Request::post('priority', null, null),
                'progress' => Request::post('progress', '0', null),
                'startdate' => Date::toDb(Request::post('startdate', null, null), 'd/m/Y'),
                'duedate' => ($tDueDate == '') ? null : Date::toDb($tDueDate, 'd/m/Y'),
                'estimatedtime' => Request::post('estimatedtime', null, null),
                'enddate' => ($tEndDate == '') ? null : Date::toDb($tEndDate, 'd/m/Y'),
                'assignee' => Request::post('assignee', null, null)
            );

            Validation::addRule('subject')->isRequired()->errorMessage(I18n::_('Subject field is required.'));
            Validation::addRule('description')->isRequired()->errorMessage(I18n::_('Description field is required.'));
            // TODO add more validators

            if (!Validation::validate($tData)) {
                Session::set(
                    'alert',
                    array(
                        'error',
                        implode('<br />', Validation::getErrorMessages(true))
                    )
                );
            } else {
               
                $tRevs = explode(',', $tRevisions);
                for ($i = count($tRevs) - 1; $i >= 0; $i--) {
                    $tRevs[$i] = trim($tRevs[$i]);
                }

                $this->taskModel->update(
                    $uId,
                    $tData,
                    $tRevs
                );
                
                $tData['revisions'] = $tRevisions;
                $tDataDiff = array_diff_assoc($tData, $tOriginalData);

                if (count($tDataDiff) > 0) {
                    $this->logModel->insert(
                        array(
                            'targetid' => $uId,
                            'user' => $this->userBindings->user['id'],
                            'created' => Date::toDb(time()),
                            'type' => 'task',
                            'serializeddata' => json_encode($tDataDiff),
                            'description' => 'Task Updated'
                        )
                    );

                    Session::set(
                        'alert',
                        array(
                            'success',
                            I18n::_('Record updated.')
                        )
                    );
                }

                Http::redirect('projects/tasks/' . $uProjectId, true);
                return;
			}
        } else {
            $tData = $tOriginalData;
        }

        $this->set('id', $uId);
        $this->set('data', $tData);

        $this->load('App\\Models\\ConstantModel');
        $tConstants = $this->constantModel->getConstants();
        $this->set('constants', Arrays::categorize($tConstants, 'type', true));

        $this->load('App\\Models\\ProjectConstantModel');
        $tProjectConstants = $this->projectConstantModel->getConstants($uProjectId);
        $this->set('projectConstants', Arrays::categorize($tProjectConstants, 'type', true));

        $this->load('App\\Models\\ProjectMemberModel');
        $this->set('users', $this->projectMemberModel->getMembersWithDetails($uProjectId));

        $this->set('files', $this->fileModel->getFiles('task', $uId));
        $this->set('notes', $this->noteModel->getNotes('task', $uId));
        $this->set('logs', $this->logModel->getLogs('task', $uId));

        $this->breadcrumbs[I18n::_('Task Edit')] = array(null, 'projects/tasks/' . $uProjectId . '/edit/' . $uId);

        $this->view('projects/tasks/edit.cshtml');
    }

    /**
     * @ignore
     */
    private function tasks_remove($uProjectId, $uId)
    {
        $this->load('App\\Models\\TaskModel');

        $tOriginalData = $this->taskModel->get($uId);
        if ($tOriginalData === false || $tOriginalData['project'] !== $uProjectId) {
            return false;
        }

        $this->taskModel->delete(
            $uId
        );

        Session::set(
            'alert',
            array(
                'success',
                I18n::_('Record removed.')
            )
        );

        // redirect to list
        Http::redirect('projects/tasks/' . $uProjectId, true);
        return;
    }

    /**
     * @ignore
     */
    private function tasks_detail($uProjectId, $uId)
    {
        $this->load('App\\Models\\TaskModel');

        $tData = $this->taskModel->get($uId);
        if ($tData === false || $tData['project'] !== $uProjectId) {
            return false;
        }

        $this->set('id', $uId);
        $this->set('projectId', $uProjectId);
        $this->set('data', $tData);

        $this->load('App\\Models\\ConstantModel');
        $tConstants = $this->constantModel->getConstants();
        $this->set('constants', Arrays::categorize($tConstants, 'type', true));

        $this->load('App\\Models\\ProjectConstantModel');
        $tProjectConstants = $this->projectConstantModel->getConstants($uProjectId);
        $this->set('projectConstants', Arrays::categorize($tProjectConstants, 'type', true));

        $this->load('App\\Models\\ProjectMemberModel');
        $this->set('users', $this->projectMemberModel->getMembersWithDetails($uProjectId));

        $this->load('App\\Models\\FileModel');
        $this->load('App\\Models\\NoteModel');
        $this->load('App\\Models\\LogModel');
        $this->set('files', $this->fileModel->getFiles('task', $uId));
        $this->set('notes', $this->noteModel->getNotes('task', $uId));
        $this->set('logs', $this->logModel->getLogs('task', $uId));

        $this->breadcrumbs[I18n::_('Task Detail')] = array(null, 'projects/tasks/' . $uProjectId . '/detail/' . $uId);

        $this->view('projects/tasks/detail.cshtml');
    }

}
