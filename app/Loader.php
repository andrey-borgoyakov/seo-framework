<?php
/**
 * GNU GENERAL PUBLIC LICENSE.
 * Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
 * {Disclaimer}.
 * {Licence}. You can read public licence here
 * @link https://github.com/andrey-borgoyakov/microshop/blob/master/LICENSE
 * {version}.
 * {copyright} Tiny Shop CMS. (c) 2017
 * Created by Andrey Borgoyakov. @link
 */

/** define Runner static */
require_once 'Runner.php';

/** Define required files */
foreach (Runner::getRequiredFiles() as $name)
{
    require_once $name;
}

/** initialize Session default */
$session = Runner::getInstance('Core/Origin/Session');
$session->startSession();

if (empty($_SESSION)) {
    $session->__set('SESSION_START_TIME', time());
    $session->__set('USER', 'guest');
    $session->__set('IS_LOGGED_IN', false);
}

if ($_SESSION['SESSION_START_TIME'] > time() + SESSION_LIFE_TIME) {
    $session->destroy();
}

if(DEBUG_MODE) {
    ini_set('display_errors',1);
    error_reporting(E_ALL);
}

/** If file extension exist, directly include it without run()  */
/** TODO: Need to refactor in future.Temporary solution */
/** find .css .js in uri */
$isCss = strripos($_SERVER['REQUEST_URI'], '.css');
$isJs  = strripos($_SERVER['REQUEST_URI'], '.js');

if ($isCss || $isJs) {
    include $_SERVER['REQUEST_URI'];
} else {
    Runner::getInstance('Core/Origin/View')->getHeader();
    Router::boot();
    Runner::getInstance('Core/Origin/View')->getFooter();
}

