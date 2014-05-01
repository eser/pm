<?php

namespace App\Controllers;

use Scabbia\Extensions\Http\Http;
use Scabbia\Extensions\I18n\I18n;
use Scabbia\Extensions\Session\Session;
use Scabbia\Extensions\Validation\Validation;
use Scabbia\Request;
use App\Includes\PmController;

/**
 * @ignore
 */
class Manage extends PmController
{
    /**
     * @ignore
     */
    public function __construct()
    {
        parent::__construct();

        $this->breadcrumbs[I18n::_('Manage')] = array(null, 'manage');
    }

    /**
     * @ignore
     */
    public function index()
    {
        // Auth::checkRedirect('user');

        $this->view();
    }

    /**
     * @ignore
     */
    public function users($uSubpage = 'index', $id = 0)
    {
        // Auth::checkRedirect('user');

        $this->breadcrumbs[I18n::_('Users')] = array(null, 'manage/users');

        if ($uSubpage === 'index') {
            return $this->users_index($id);
        } elseif ($uSubpage === 'add') {
            return $this->users_add();
        } elseif ($uSubpage === 'edit') {
            return $this->users_edit($id);
        } elseif ($uSubpage === 'remove') {
            return $this->users_remove($id);
        }

        return false;
    }

    /**
     * @ignore
     */
    public function groups($uSubpage = 'index', $id = 0)
    {
        // Auth::checkRedirect('user');

        $this->breadcrumbs[I18n::_('Groups')] = array(null, 'manage/groups');

        if ($uSubpage === 'index') {
            return $this->groups_index($id);
        } elseif ($uSubpage === 'add') {
            return $this->groups_add();
        } elseif ($uSubpage === 'edit') {
            return $this->groups_edit($id);
        } elseif ($uSubpage === 'remove') {
            return $this->groups_remove($id);
        }

        return false;
    }

    /**
     * @ignore
     */
    public function pages($uSubpage = 'index', $id = 0)
    {
        // Auth::checkRedirect('user');

        $this->breadcrumbs[I18n::_('Pages')] = array(null, 'manage/pages');

        if ($uSubpage === 'index') {
            return $this->pages_index($id);
        } elseif ($uSubpage === 'add') {
            return $this->pages_add();
        } elseif ($uSubpage === 'edit') {
            return $this->pages_edit($id);
        } elseif ($uSubpage === 'remove') {
            return $this->pages_remove($id);
        }

        return false;
    }

    /**
     * @ignore
     */
    public function roles($uSubpage = 'index', $id = 0)
    {
        // Auth::checkRedirect('user');

        $this->breadcrumbs[I18n::_('Roles')] = array(null, 'manage/roles');

        if ($uSubpage === 'index') {
            return $this->roles_index($id);
        } elseif ($uSubpage === 'add') {
            return $this->roles_add();
        } elseif ($uSubpage === 'edit') {
            return $this->roles_edit($id);
        } elseif ($uSubpage === 'remove') {
            return $this->roles_remove($id);
        }

        return false;
    }

    /**
     * @ignore
     */
    public function constants($uSubpage = 'index', $id = 0)
    {
        // Auth::checkRedirect('user');

        $this->breadcrumbs[I18n::_('Constants')] = array(null, 'manage/constants');

        if ($uSubpage === 'index') {
            return $this->constants_index($id);
        } elseif ($uSubpage === 'add') {
            return $this->constants_add();
        } elseif ($uSubpage === 'edit') {
            return $this->constants_edit($id);
        } elseif ($uSubpage === 'remove') {
            return $this->constants_remove($id);
        }

        return false;
    }

    /**
     * @ignore
     */
    private function users_index($uPage = 1)
    {
        $tPageSize = 25;

        $tPage = $uPage - 1;
        if ($tPage < 0) {
            $tPage = 0;
        }

        $this->load('App\\Models\\UserModel');

        $this->set('data', $this->userModel->getUsersWithPaging($tPage * $tPageSize, $tPageSize));
        $this->set('dataCount', $this->userModel->getUsersCount());

        $this->set('pageSize', $tPageSize);
        $this->set('page', $tPage);

        $this->view('manage/users/index.cshtml');
    }

    /**
     * @ignore
     */
    private function users_add()
    {
        if (Request::$method === 'post') {
            $tData = array(
                'scmid' => Request::post('scmid', null, null),
                'name' => Request::post('name', null, null),
                'username' => Request::post('username', null, null),
                'password' => Request::post('password', null, null),
                'email' => Request::post('email', null, null),
                'phone' => Request::post('phone', null, null),
                'role' => Request::post('role', null, null),
                'bio' => Request::post('bio', null, null),
                'page' => Request::post('page', null, null),
                'active' => Request::post('active', '1', null),
                'language' => Request::post('language', null, null),
                'sendmails' => Request::post('sendmails', '1', null)
            );

            $tUserGroups = array_keys(Request::post('groups', array(), null));

            Validation::addRule('name')->isRequired()->errorMessage(I18n::_('Name field is required.'));
            Validation::addRule('username')->isRequired()->errorMessage(I18n::_('Username field is required.'));
            Validation::addRule('password')->isRequired()->errorMessage(I18n::_('Password field is required.'));
            Validation::addRule('email')->isEmail()->errorMessage(I18n::_('E-mail field should be filled in valid e-mail format.'));

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

                $tId = $this->userModel->insert($tData);

                foreach (Request::post('groups', array(), null) as $tGroupKey => $tGroupValue) {
                    $this->userModel->addToGroup($tId, $tGroupKey);
                }

                Session::set(
                    'alert',
                    array(
                        'success',
                        I18n::_('Record added.')
                    )
                );

                // redirect to newly created
                Http::redirect('manage/users/edit/' . $tId, true);
                return;
            }
        } else {
            $tData = array(
                'scmid' => '',
                'name' => '',
                'username' => '',
                'password' => '',
                'email' => '',
                'phone' => '',
                'role' => '',
                'bio' => '',
                'page' => '',
                'active' => '1',
                'language' => I18n::$language['key'],
                'sendmails' => '1'
            );

            $tUserGroups = array();
        }

        $this->set('data', $tData);
        $this->set('usergroups', $tUserGroups);

        $this->load('App\\Models\\RoleModel');
        $this->set('roles', $this->roleModel->getRoles());

        $this->load('App\\Models\\GroupModel');
        $this->set('groups', $this->groupModel->getGroups());

        $this->breadcrumbs[I18n::_('User Add')] = array(null, 'manage/users/add');

        $this->view('manage/users/add.cshtml');
    }

    /**
     * @ignore
     */
    private function users_edit($uId)
    {
        $this->load('App\\Models\\UserModel');

        $tOriginalData = $this->userModel->get($uId);
        if ($tOriginalData === false) {
            return false;
        }

        if (Request::$method === 'post') {
            if (Request::post('asNew', 0, 'intval') === 1) {
                $this->users_add();
                return;
            }

            $tData = array(
                'scmid' => Request::post('scmid', null, null),
                'name' => Request::post('name', null, null),
                'username' => Request::post('username', null, null),
                'password' => Request::post('password', null, null),
                'email' => Request::post('email', null, null),
                'phone' => Request::post('phone', null, null),
                'role' => Request::post('role', null, null),
                'bio' => Request::post('bio', null, null),
                'page' => Request::post('page', null, null),
                'active' => Request::post('active', null, null),
                'language' => Request::post('language', null, null),
                'sendmails' => Request::post('sendmails', null, null)
            );

            $tUserGroups = array_keys(Request::post('groups', array(), null));

            Validation::addRule('name')->isRequired()->errorMessage(I18n::_('Name field is required.'));
            Validation::addRule('username')->isRequired()->errorMessage(I18n::_('Username field is required.'));
            // Validation::addRule('password')->isRequired()->errorMessage(I18n::_('Password field is required.'));
            Validation::addRule('email')->isEmail()->errorMessage(I18n::_('E-mail field should be filled in valid e-mail format.'));

            if (!Validation::validate($tData)) {
                Session::set(
                    'alert',
                    array(
                        'error',
                        implode('<br />', Validation::getErrorMessages(true))
                    )
                );
            } else {
                if (strlen($tData['password']) === 0) {
                    unset($tData['password']);
                }

                $this->userModel->update(
                    $uId,
                    $tData
                );

                $this->userModel->purgeGroups($uId);
                foreach (Request::post('groups', array(), null) as $tGroupKey => $tGroupValue) {
                    $this->userModel->addToGroup($uId, $tGroupKey);
                }

                Session::set(
                    'alert',
                    array(
                        'success',
                        I18n::_('Record updated.')
                    )
                );

                $tData['password'] = '';
            }
        } else {
            $tData = $tOriginalData;
            $tUserGroups = $this->userModel->getGroups($uId);
            $tData['password'] = '';
        }

        $this->set('id', $uId);
        $this->set('data', $tData);
        $this->set('usergroups', $tUserGroups);

        $this->load('App\\Models\\RoleModel');
        $this->set('roles', $this->roleModel->getRoles());

        $this->load('App\\Models\\GroupModel');
        $this->set('groups', $this->groupModel->getGroups());

        $this->breadcrumbs[I18n::_('User Edit')] = array(null, 'manage/users/edit/' . $uId);

        $this->view('manage/users/edit.cshtml');
    }

    /**
     * @ignore
     */
    private function users_remove($uId)
    {
        $this->load('App\\Models\\UserModel');

        $tOriginalData = $this->userModel->get($uId);
        if ($tOriginalData === false) {
            return false;
        }

        $this->userModel->delete(
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
        Http::redirect('manage/users', true);
        return;
    }

    /**
     * @ignore
     */
    private function groups_index($uPage = 1)
    {
        $tPageSize = 25;

        $tPage = $uPage - 1;
        if ($tPage < 0) {
            $tPage = 0;
        }

        $this->load('App\\Models\\GroupModel');

        $this->set('data', $this->groupModel->getGroupsWithPaging($tPage * $tPageSize, $tPageSize));
        $this->set('dataCount', $this->groupModel->getGroupsCount());

        $this->set('pageSize', $tPageSize);
        $this->set('page', $tPage);

        $this->view('manage/groups/index.cshtml');
    }

    /**
     * @ignore
     */
    private function groups_add()
    {
        if (Request::$method === 'post') {
            $tData = array(
                'name' => Request::post('name', null, null)
            );

            Validation::addRule('name')->isRequired()->errorMessage(I18n::_('Name field is required.'));

            if (!Validation::validate($tData)) {
                Session::set(
                    'alert',
                    array(
                        'error',
                        implode('<br />', Validation::getErrorMessages(true))
                    )
                );
            } else {
                $this->load('App\\Models\\GroupModel');

                $tId = $this->groupModel->insert($tData);

                Session::set(
                    'alert',
                    array(
                        'success',
                        I18n::_('Record added.')
                    )
                );

                // redirect to newly created
                Http::redirect('manage/groups/edit/' . $tId, true);
                return;
            }
        } else {
            $tData = array(
                'name' => ''
            );
        }

        $this->set('data', $tData);

        $this->breadcrumbs[I18n::_('Group Add')] = array(null, 'manage/groups/add');

        $this->view('manage/groups/add.cshtml');
    }

    /**
     * @ignore
     */
    private function groups_edit($uId)
    {
        $this->load('App\\Models\\GroupModel');

        $tOriginalData = $this->groupModel->get($uId);
        if ($tOriginalData === false) {
            return false;
        }

        if (Request::$method === 'post') {
            if (Request::post('asNew', 0, 'intval') === 1) {
                $this->groups_add();
                return;
            }

            $tData = array(
                'name' => Request::post('name', null, null)
            );

            Validation::addRule('name')->isRequired()->errorMessage(I18n::_('Name field is required.'));

            if (!Validation::validate($tData)) {
                Session::set(
                    'alert',
                    array(
                        'error',
                        implode('<br />', Validation::getErrorMessages(true))
                    )
                );
            } else {
                $this->groupModel->update(
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

        $this->breadcrumbs[I18n::_('Group Edit')] = array(null, 'manage/groups/edit/' . $uId);

        $this->view('manage/groups/edit.cshtml');
    }

    /**
     * @ignore
     */
    private function groups_remove($uId)
    {
        $this->load('App\\Models\\GroupModel');

        $tOriginalData = $this->groupModel->get($uId);
        if ($tOriginalData === false) {
            return false;
        }

        $this->groupModel->delete(
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
        Http::redirect('manage/groups', true);
        return;
    }

	/**
     * @ignore
     */
    private function pages_index($uPage = 1)
    {
        $tPageSize = 25;

        $tPage = $uPage - 1;
        if ($tPage < 0) {
            $tPage = 0;
        }

        $this->load('App\\Models\\PageModel');

        $this->set('data', $this->pageModel->getPagesWithPaging($tPage * $tPageSize, $tPageSize));
        $this->set('dataCount', $this->pageModel->getPagesCount());

        $this->set('pageSize', $tPageSize);
        $this->set('page', $tPage);

        $this->load('App\\Models\\ProjectModel');
		$tProjects = $this->projectModel->getProjects();

        foreach ($tProjects as &$tRow) {
            $tRow['displayname'] = $tRow['name'] . ' (' . $tRow['title'] . ')';
        }

        $this->set('projects', $tProjects);
        $this->set('types', $this->pageModel->types);

        $this->view('manage/pages/index.cshtml');
    }

    /**
     * @ignore
     */
    private function pages_add()
    {
        $this->load('App\\Models\\ProjectModel');
		$tProjects = $this->projectModel->getProjects();

        foreach ($tProjects as &$tRow) {
            $tRow['displayname'] = $tRow['name'] . ' (' . $tRow['title'] . ')';
        }

        $this->set('projects', $tProjects);

        $this->load('App\\Models\\PageModel');

        if (Request::$method === 'post') {
            $tHTMLConfig = \HTMLPurifier_Config::createDefault();
            $tPurifier = new \HTMLPurifier($tHTMLConfig);
            $tHtml = $tPurifier->purify(Request::post('html', null, null));

            $tData = array(
                'name' => Request::post('name', null, null),
                'title' => Request::post('title', null, null),
                'html' => $tHtml,
                'project' => Request::post('project', '0', null),
                'type' => Request::post('type', null, null)
            );

            Validation::addRule('name')->isRequired()->errorMessage(I18n::_('Name field is required.'));
            Validation::addRule('title')->isRequired()->errorMessage(I18n::_('Title field is required.'));
            Validation::addRule('html')->isRequired()->errorMessage(I18n::_('HTML is required.'));
            Validation::addRule('type')->inArray(array('passive', 'unlisted', 'menu'))->errorMessage(I18n::_('Type should be valid.'));

            if (!Validation::validate($tData)) {
                Session::set(
                    'alert',
                    array(
                        'error',
                        implode('<br />', Validation::getErrorMessages(true))
                    )
                );
            } else {
                $tId = $this->pageModel->insert($tData);

                Session::set(
                    'alert',
                    array(
                        'success',
                        I18n::_('Record added.')
                    )
                );

                // redirect to newly created
                Http::redirect('manage/pages/edit/' . $tId, true);
                return;
            }
        } else {
            $tData = array(
                'name' => '',
                'title' => '',
                'html' => '',
                'project' => '0',
                'type' => 'unlisted'
            );
        }

        $this->set('data', $tData);
        $this->set('types', $this->pageModel->types);

        $this->breadcrumbs[I18n::_('Page Add')] = array(null, 'manage/pages/add');

        $this->view('manage/pages/add.cshtml');
    }

    /**
     * @ignore
     */
    private function pages_edit($uId)
    {
        $this->load('App\\Models\\ProjectModel');
		$tProjects = $this->projectModel->getProjects();

        foreach ($tProjects as &$tRow) {
            $tRow['displayname'] = $tRow['name'] . ' (' . $tRow['title'] . ')';
        }

        $this->set('projects', $tProjects);

        $this->load('App\\Models\\PageModel');

        $tOriginalData = $this->pageModel->get($uId);
        if ($tOriginalData === false) {
            return false;
        }

        if (Request::$method === 'post') {
            if (Request::post('asNew', 0, 'intval') === 1) {
                $this->pages_add();
                return;
            }

            $tHTMLConfig = \HTMLPurifier_Config::createDefault();
            $tPurifier = new \HTMLPurifier($tHTMLConfig);
            $tHtml = $tPurifier->purify(Request::post('html', null, null));

            $tData = array(
                'name' => Request::post('name', null, null),
                'title' => Request::post('title', null, null),
                'html' => $tHtml,
                'project' => Request::post('project', '0', null),
                'type' => Request::post('type', null, null)
            );

            Validation::addRule('name')->isRequired()->errorMessage(I18n::_('Name field is required.'));
            Validation::addRule('title')->isRequired()->errorMessage(I18n::_('Title field is required.'));
            Validation::addRule('html')->isRequired()->errorMessage(I18n::_('HTML is required.'));
            Validation::addRule('type')->inArray(array('passive', 'unlisted', 'menu'))->errorMessage(I18n::_('Type should be valid.'));

            if (!Validation::validate($tData)) {
                Session::set(
                    'alert',
                    array(
                        'error',
                        implode('<br />', Validation::getErrorMessages(true))
                    )
                );
            } else {
                $this->pageModel->update(
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

        $this->set('types', $this->pageModel->types);

        $this->breadcrumbs[I18n::_('Page Edit')] = array(null, 'manage/pages/edit/' . $uId);

        $this->view('manage/pages/edit.cshtml');
    }

    /**
     * @ignore
     */
    private function pages_remove($uId)
    {
        $this->load('App\\Models\\PageModel');

        $tOriginalData = $this->pageModel->get($uId);
        if ($tOriginalData === false) {
            return false;
        }

        $this->pageModel->delete(
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
        Http::redirect('manage/pages', true);
        return;
    }

    /**
     * @ignore
     */
    private function roles_index($uPage = 1)
    {
        $tPageSize = 25;

        $tPage = $uPage - 1;
        if ($tPage < 0) {
            $tPage = 0;
        }

        $this->load('App\\Models\\RoleModel');

        $this->set('data', $this->roleModel->getRolesWithPaging($tPage * $tPageSize, $tPageSize));
        $this->set('dataCount', $this->roleModel->getRolesCount());

        $this->set('pageSize', $tPageSize);
        $this->set('page', $tPage);

        $this->view('manage/roles/index.cshtml');
    }

    /**
     * @ignore
     */
    private function roles_add()
    {
        if (Request::$method === 'post') {
            $tData = array(
                'name' => Request::post('name', null, null),
                'createproject' => Request::post('createproject', '0', null),
                'createuser' => Request::post('createuser', '0', null),
                'deleteuser' => Request::post('deleteuser', '0', null),
                'administer' => Request::post('administer', '0', null),
                'login' => Request::post('login', '0', null),
                'active' => Request::post('active', '0', null)
            );

            Validation::addRule('name')->isRequired()->errorMessage(I18n::_('Name field is required.'));

            if (!Validation::validate($tData)) {
                Session::set(
                    'alert',
                    array(
                        'error',
                        implode('<br />', Validation::getErrorMessages(true))
                    )
                );
            } else {
                $this->load('App\\Models\\RoleModel');

                $tId = $this->roleModel->insert($tData);

                Session::set(
                    'alert',
                    array(
                        'success',
                        I18n::_('Record added.')
                    )
                );

                // redirect to newly created
                Http::redirect('manage/roles/edit/' . $tId, true);
                return;
            }
        } else {
            $tData = array(
                'name' => '',
                'createproject' => '1',
                'createuser' => '0',
                'deleteuser' => '0',
                'administer' => '0',
                'login' => '1',
                'active' => '1'
            );
        }

        $this->set('data', $tData);

        $this->breadcrumbs[I18n::_('Role Add')] = array(null, 'manage/roles/add');

        $this->view('manage/roles/add.cshtml');
    }

    /**
     * @ignore
     */
    private function roles_edit($uId)
    {
        $this->load('App\\Models\\RoleModel');

        $tOriginalData = $this->roleModel->get($uId);
        if ($tOriginalData === false) {
            return false;
        }

        if (Request::$method === 'post') {
            if (Request::post('asNew', 0, 'intval') === 1) {
                $this->roles_add();
                return;
            }

            $tData = array(
                'name' => Request::post('name', null, null),
                'createproject' => Request::post('createproject', '0', null),
                'createuser' => Request::post('createuser', '0', null),
                'deleteuser' => Request::post('deleteuser', '0', null),
                'administer' => Request::post('administer', '0', null),
                'login' => Request::post('login', '0', null),
                'active' => Request::post('active', '0', null)
            );

            Validation::addRule('name')->isRequired()->errorMessage(I18n::_('Name field is required.'));

            if (!Validation::validate($tData)) {
                Session::set(
                    'alert',
                    array(
                        'error',
                        implode('<br />', Validation::getErrorMessages(true))
                    )
                );
            } else {
                $this->roleModel->update(
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

        $this->breadcrumbs[I18n::_('Role Edit')] = array(null, 'manage/roles/edit/' . $uId);

        $this->view('manage/roles/edit.cshtml');
    }

    /**
     * @ignore
     */
    private function roles_remove($uId)
    {
        $this->load('App\\Models\\RoleModel');

        $tOriginalData = $this->roleModel->get($uId);
        if ($tOriginalData === false) {
            return false;
        }

        $this->roleModel->delete(
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
        Http::redirect('manage/roles', true);
        return;
    }

    /**
     * @ignore
     */
    private function constants_index($uPage = 1)
    {
        $tPageSize = 25;

        $tPage = $uPage - 1;
        if ($tPage < 0) {
            $tPage = 0;
        }

        $this->load('App\\Models\\ConstantModel');

        $this->set('data', $this->constantModel->getConstantsWithPaging($tPage * $tPageSize, $tPageSize));
        $this->set('dataCount', $this->constantModel->getConstantsCount());

        $this->set('types', $this->constantModel->types);

        $this->set('pageSize', $tPageSize);
        $this->set('page', $tPage);

        $this->view('manage/constants/index.cshtml');
    }

    /**
     * @ignore
     */
    private function constants_add()
    {
        $this->load('App\\Models\\ConstantModel');

        if (Request::$method === 'post') {
            $tData = array(
                'name' => Request::post('name', null, null),
                'type' => Request::post('type', null, null)
            );

            Validation::addRule('name')->isRequired()->errorMessage(I18n::_('Name field is required.'));
            Validation::addRule('type')->inKeys($this->constantModel->types)->errorMessage(I18n::_('Invalid type.'));

            if (!Validation::validate($tData)) {
                Session::set(
                    'alert',
                    array(
                        'error',
                        implode('<br />', Validation::getErrorMessages(true))
                    )
                );
            } else {
                $tId = $this->constantModel->insert($tData);

                Session::set(
                    'alert',
                    array(
                        'success',
                        I18n::_('Record added.')
                    )
                );

                // redirect to newly created
                Http::redirect('manage/constants/edit/' . $tId, true);
                return;
            }
        } else {
            $tData = array(
                'name' => '',
                'type' => ''
            );
        }

        $this->set('data', $tData);
        $this->set('types', $this->constantModel->types);

        $this->breadcrumbs[I18n::_('Constants Add')] = array(null, 'manage/constants/add');

        $this->view('manage/constants/add.cshtml');
    }

    /**
     * @ignore
     */
    private function constants_edit($uId)
    {
        $this->load('App\\Models\\ConstantModel');

        $tOriginalData = $this->constantModel->get($uId);
        if ($tOriginalData === false) {
            return false;
        }

        if (Request::$method === 'post') {
            if (Request::post('asNew', 0, 'intval') === 1) {
                $this->constants_add();
                return;
            }

            $tData = array(
                'name' => Request::post('name', null, null),
                'type' => Request::post('type', null, null)
            );

            Validation::addRule('name')->isRequired()->errorMessage(I18n::_('Name field is required.'));
            Validation::addRule('type')->inKeys($this->constantModel->types)->errorMessage(I18n::_('Invalid type.'));

            if (!Validation::validate($tData)) {
                Session::set(
                    'alert',
                    array(
                        'error',
                        implode('<br />', Validation::getErrorMessages(true))
                    )
                );
            } else {
                $this->constantModel->update(
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
        $this->set('types', $this->constantModel->types);

        $this->breadcrumbs[I18n::_('Constants Edit')] = array(null, 'manage/constants/edit/' . $uId);

        $this->view('manage/constants/edit.cshtml');
    }

    /**
     * @ignore
     */
    private function constants_remove($uId)
    {
        $this->load('App\\Models\\ConstantModel');

        $tOriginalData = $this->constantModel->get($uId);
        if ($tOriginalData === false) {
            return false;
        }

        $this->constantModel->delete(
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
        Http::redirect('manage/constants', true);
        return;
    }
}
