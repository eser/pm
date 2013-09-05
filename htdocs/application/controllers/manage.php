<?php

namespace App\Controllers;

use Scabbia\Extensions\Database\Database;
use Scabbia\Extensions\Mvc\Controller;
use Scabbia\Extensions\Http\Http;
use Scabbia\Extensions\I18n\I18n;
use Scabbia\Extensions\Fb\Fb;
use Scabbia\Extensions\Session\Session;
use Scabbia\Extensions\Validation\Validation;
use Scabbia\Request;

/**
 * @ignore
 */
class manage extends Controller
{
    /**
     * @ignore
     */
    public function index()
    {
        // Auth::checkRedirect('user');

        $this->load('App\\Models\\homeModel');

        $tWelcomeText = $this->homeModel->getWelcomeText();
        $this->set('welcomeText', $tWelcomeText);
        
        $this->view();
    }

    /**
     * @ignore
     */
    public function users($uSubpage = 'index', $id = 0)
    {
        // Auth::checkRedirect('user');

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
    public function roles($uSubpage = 'index', $id = 0)
    {
        // Auth::checkRedirect('user');

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

        $this->load('App\\Models\\userModel');

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
                'siterole' => Request::post('siterole', null, null),
                'bio' => Request::post('bio', null, null),
                'page' => Request::post('page', null, null)
            );

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
                $this->load('App\\Models\\userModel');

                $tId = $this->userModel->insert($tData);

                Session::set(
                    'alert',
                    array(
                        'success',
                        'Record added.'
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
                'siterole' => '',
                'bio' => '',
                'page' => ''
            );
        }

        $this->set('data', $tData);

        $this->load('App\\Models\\roleModel');
        $this->set('roles', $this->roleModel->getRoles());

        $this->load('App\\Models\\groupModel');
        $this->set('groups', $this->groupModel->getGroups());

        $this->view('manage/users/add.cshtml');
    }

    /**
     * @ignore
     */
    private function users_edit($uId)
    {
        $this->load('App\\Models\\userModel');

        $tOriginalData = $this->userModel->get($uId);
        if ($tOriginalData === false) {
            return false;
        }

        if (Request::$method === 'post') {
            $tData = array(
                'scmid' => Request::post('scmid', null, null),
                'name' => Request::post('name', null, null),
                'username' => Request::post('username', null, null),
                'password' => Request::post('password', null, null),
                'email' => Request::post('email', null, null),
                'phone' => Request::post('phone', null, null),
                'siterole' => Request::post('siterole', null, null),
                'bio' => Request::post('bio', null, null),
                'page' => Request::post('page', null, null)
            );

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

                Session::set(
                    'alert',
                    array(
                        'success',
                        'Record updated.'
                    )
                );

                $tData['password'] = '';
            }
        } else {
            $tData = $tOriginalData;
            $tData['password'] = '';
        }

        $this->set('id', $uId);
        $this->set('data', $tData);

        $this->load('App\\Models\\roleModel');
        $this->set('roles', $this->roleModel->getRoles());

        $this->load('App\\Models\\groupModel');
        $this->set('groups', $this->groupModel->getGroups());

        $this->view('manage/users/edit.cshtml');
    }

    /**
     * @ignore
     */
    private function users_remove($uId)
    {
        $this->load('App\\Models\\userModel');

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
                'Record removed.'
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

        $this->load('App\\Models\\groupModel');

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
                $this->load('App\\Models\\groupModel');

                $tId = $this->groupModel->insert($tData);

                Session::set(
                    'alert',
                    array(
                        'success',
                        'Record added.'
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

        $this->view('manage/groups/add.cshtml');
    }

    /**
     * @ignore
     */
    private function groups_edit($uId)
    {
        $this->load('App\\Models\\groupModel');

        $tOriginalData = $this->groupModel->get($uId);
        if ($tOriginalData === false) {
            return false;
        }

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
                $this->groupModel->update(
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

        $this->view('manage/groups/edit.cshtml');
    }

    /**
     * @ignore
     */
    private function groups_remove($uId)
    {
        $this->load('App\\Models\\groupModel');

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
                'Record removed.'
            )
        );

        // redirect to list
        Http::redirect('manage/groups', true);
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

        $this->load('App\\Models\\roleModel');

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
                'createproject' => Request::post('createproject', null, null),
                'createuser' => Request::post('createuser', null, null),
                'deleteuser' => Request::post('deleteuser', null, null),
                'administer' => Request::post('administer', null, null)
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
                $this->load('App\\Models\\roleModel');

                $tId = $this->roleModel->insert($tData);

                Session::set(
                    'alert',
                    array(
                        'success',
                        'Record added.'
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
                'administer' => '0'
            );
        }

        $this->set('data', $tData);

        $this->view('manage/roles/add.cshtml');
    }

    /**
     * @ignore
     */
    private function roles_edit($uId)
    {
        $this->load('App\\Models\\roleModel');

        $tOriginalData = $this->roleModel->get($uId);
        if ($tOriginalData === false) {
            return false;
        }

        if (Request::$method === 'post') {
            $tData = array(
                'name' => Request::post('name', null, null),
                'createproject' => Request::post('createproject', null, null),
                'createuser' => Request::post('createuser', null, null),
                'deleteuser' => Request::post('deleteuser', null, null),
                'administer' => Request::post('administer', null, null)
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
                        'Record updated.'
                    )
                );
            }
        } else {
            $tData = $tOriginalData;
        }

        $this->set('id', $uId);
        $this->set('data', $tData);

        $this->view('manage/roles/edit.cshtml');
    }

    /**
     * @ignore
     */
    private function roles_remove($uId)
    {
        $this->load('App\\Models\\roleModel');

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
                'Record removed.'
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

        $this->load('App\\Models\\constantModel');

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
        $this->load('App\\Models\\constantModel');

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
                        'Record added.'
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

        $this->view('manage/constants/add.cshtml');
    }

    /**
     * @ignore
     */
    private function constants_edit($uId)
    {
        $this->load('App\\Models\\constantModel');

        $tOriginalData = $this->constantModel->get($uId);
        if ($tOriginalData === false) {
            return false;
        }

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
                $this->constantModel->update(
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
        $this->set('types', $this->constantModel->types);

        $this->view('manage/constants/edit.cshtml');
    }

    /**
     * @ignore
     */
    private function constants_remove($uId)
    {
        $this->load('App\\Models\\constantModel');

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
                'Record removed.'
            )
        );

        // redirect to list
        Http::redirect('manage/constants', true);
        return;
    }
}
