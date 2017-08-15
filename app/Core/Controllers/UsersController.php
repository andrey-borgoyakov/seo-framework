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

    public function loginAction()
    {
        if (!$this->isUserLoggedIn()) {
            Runner::getInstance('Core/Models/Viewer')->renderTemplate('includes/login');
        } else {
            Router::redirect('/');
        }
    }

    public function isUserLoggedIn()
    {
        return $_SESSION['IS_LOGGED_IN'];
    }
}