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
final class Router
{
    /** define default controller name */
    const DEFAULT_CONTROLLER_NAME = 'Home';

    /** define default action name */
    const DEFAULT_ACTION_NAME = 'Index';

    /** default controller path */
    const CONTROLLERS_PATH = 'Core/Controllers/';

    /** Controllers file extension */
    const INSTANCE_EXTENSION = '.php';

    /** Templates file extension */
    const TEMPLATE_EXTENSION = '.phtml';


    /**
     * Main route method
     *
     * @throws Runner coreException
     */
    public static function boot()
    {
        $routes = array();
        if (Router::isRedirect()) {
            $routes = Router::parseRequest();
        }

        /** @var  $controller_file Core_Origin_Controller class file */
        $controllerFile = Router::setRequestController($routes) . '.php';
        $controllerPath = $controllerFile;

        Router::includeControllerInstance($controllerPath, $routes);

        /** Finally Call controller Action */
        Router::callControllerMethod(
            Runner::getInstance(Router::setRequestController($routes)),
            Router::setControllerAction($routes)
        );
    }

    /**
     * Check if redirect exist
     *
     * @return bool
     */
    public static function isRedirect()
    {
        return isset($_SERVER['REQUEST_URI']);
    }

    /**
     * Check and return routed Controller name
     *
     * @param $routes
     * @return string
     */
    public static function setRequestController($routes)
    {
        /** get controller name */
        if (!empty($routes[1])) {
            $controllerName = $routes[1];
        } else {
            $controllerName = self::DEFAULT_CONTROLLER_NAME;
        }

        return (self::CONTROLLERS_PATH.ucwords($controllerName)).'Controller';
    }

    /**
     * Check and return routed Controller Action
     *
     * @param $routes
     * @return string
     */
    public static function setControllerAction($routes)
    {
        /** get action name */
        if (!empty($routes[2])) {
            $controllerAction = $routes[2];
        } else {
            $controllerAction = self::DEFAULT_ACTION_NAME;
        }

        return $controllerAction . 'Action';
    }

    /**
     * Parse Requested Route string
     *
     * @return array
     */
    public static function parseRequest()
    {
        return array_diff(explode('/', $_SERVER['REQUEST_URI']), array('', NULL, false));
    }

    /**
     * Call requested controller instance Action
     *
     * @param $controller
     * @param $action
     * @throws Runner coreException
     */
    public static function callControllerMethod($controller, $action)
    {
        if (method_exists($controller, $action)) {
            $controller->$action();
        } else {
            Runner::coreException("Requested controller method not exist");
        }
    }

    /**
     * Check if controller class exist in filesystem
     *
     * @param $controllerPath
     * @return bool
     */
    public static function isControllerExist($controllerPath)
    {
        return file_exists('app/'.$controllerPath);
    }

    /**
     * Include controller instance from file
     *
     * @param $controllerPath
     * @param $routes
     * @throws Runner coreException
     */
    public static function includeControllerInstance($controllerPath, $routes)
    {
        if (Router::isControllerExist($controllerPath)) {
            include Router::setRequestController($routes) . self::INSTANCE_EXTENSION;
        } else {
            Runner::coreException("Routed file not exist");
        }
    }

    /**
     * Redirect to $url location
     *
     * @param $url string
     */
    public static function redirect($url = null)
    {
        $location = 'Location: http://'.Router::getBaseUrl().'/'.$url;
        header($location);
        die();
    }

    public static function getBaseUrl()
    {
        return $_SERVER['HTTP_HOST'];
    }
}