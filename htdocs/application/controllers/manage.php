<?php

namespace App\Controllers;

use Scabbia\Extensions\Mvc\Controller;
use Scabbia\Extensions\Http\Http;
use Scabbia\Extensions\Fb\Fb;
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
    public function users($uSubpage = 'index')
    {
        // Auth::checkRedirect('user');

        if ($uSubpage === 'index') {
            return $this->users_index();
        } elseif ($uSubpage === 'add') {
            return $this->users_add();
        } elseif ($uSubpage === 'edit') {
            return $this->users_edit();
        } elseif ($uSubpage === 'remove') {
            return $this->users_remove();
        }

        return false;
    }

    /**
     * @ignore
     */
    public function groups($uSubpage = 'index')
    {
        // Auth::checkRedirect('user');

        if ($uSubpage === 'index') {
            return $this->groups_index();
        } elseif ($uSubpage === 'add') {
            return $this->groups_add();
        } elseif ($uSubpage === 'edit') {
            return $this->groups_edit();
        } elseif ($uSubpage === 'remove') {
            return $this->groups_remove();
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
            return $this->roles_index();
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
    private function users_index()
    {
        $this->load('App\\Models\\userModel');

        $tUsers = $this->userModel->getUsers();
        $this->set('users', $tUsers);

        $this->view('manage/users/index.cshtml');
    }

    /**
     * @ignore
     */
    private function groups_index()
    {
        $this->load('App\\Models\\groupModel');

        $tGroups = $this->groupModel->getGroups();
        $this->set('groups', $tGroups);

        $this->view('manage/groups/index.cshtml');
    }

    /**
     * @ignore
     */
    private function roles_index()
    {
        $this->load('App\\Models\\roleModel');

        $tRoles = $this->roleModel->getRoles();
        $this->set('roles', $tRoles);

        $this->view('manage/roles/index.cshtml');
    }

    /**
     * @ignore
     */
    private function roles_add()
    {
        if (Request::$method === 'post') {
            $this->load('App\\Models\\roleModel');

            $tId = $this->roleModel->insert(
                array(
                    'name' => Request::post('name', null, null),
                    'createproject' => Request::post('createproject', null, null),
                    'createuser' => Request::post('createuser', null, null),
                    'deleteuser' => Request::post('deleteuser', null, null)
                )
            );

            // redirect to newly created
            Http::redirect('manage/roles/edit/' . $tId, true);
            return;
        }

        $this->view('manage/roles/add.cshtml');
    }

    /**
     * @ignore
     */
    private function roles_edit($uId)
    {
        $this->load('App\\Models\\roleModel');

        if (Request::$method === 'post') {
            $tData = array(
                'name' => Request::post('name', null, null),
                'createproject' => Request::post('createproject', null, null),
                'createuser' => Request::post('createuser', null, null),
                'deleteuser' => Request::post('deleteuser', null, null)
            );

            $this->roleModel->update(
                $uId,
                $tData
            );
        } else {
            $tData = $this->roleModel->get($uId);
        }

        $this->set('id', $uId);
        $this->set('data', $tData);

        $this->view('manage/roles/edit.cshtml');
    }
}
