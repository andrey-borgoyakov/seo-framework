<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 3/13/2017
 * Time: 3:25 PM
 */

class Core_Controllers_UsersController extends Core_Origin_Controller
{
    public function indexAction()
    {
    }

    /**
     * Main login action
     */
    public function loginAction()
    {
        if (!$this->isUserLoggedIn()) {
            $this->renderTemplate('includes/login');
        } else {
            Router::redirect('/');
        }
    }

    /**
     * Check if user logged in
     * @return mixed
     */
    public function isUserLoggedIn()
    {
        return $_SESSION['IS_LOGGED_IN'];
    }

    public function settingsAction()
    {
        $this->addNotice('Feature in progress...', 'notice');
    }

    public function changelogAction()
    {
        $this->renderTemplate('changelog');
    }
}