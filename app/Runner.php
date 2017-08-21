<?php
/**
 * GNU GENERAL PUBLIC LICENSE.
 * Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
 * {Disclaimer}.
 * {Licence}. You can read public licence here
 * @link https://github.com/andrey-borgoyakov/seo-framework/blob/master/LICENSE
 * {version}.
 * {copyright} Seo Framework. (c) 2017
 * Created by Andrey Borgoyakov. @link
 */
final class Runner
{
    /**
     * Retrieve instance of model class
     * Example request:  Runner::getInstance('Core/Origin/Session') returned you instance of @Core_Origin_Session
     *
     * @param string $instanceClass
     * @return object
     */
    public static function getInstance($instanceClass)
    {
        if (!$instanceClass || !is_string($instanceClass)) {
            Runner::coreException('Class name does not exist or is not a string');
            die();
        }
        if (stripos($instanceClass, '/')) {
            $requiredInstance = explode('/', $instanceClass);
            $pathToFile = __DIR__ . '/' . Runner::getRequiredInstancePath($requiredInstance);
            require_once $pathToFile . Router::INSTANCE_EXTENSION;
            $instanceClass = str_replace('/', '_', $instanceClass);
        }

        return new $instanceClass;
    }

    /**
     * Render Core exception with passed text.
     *
     * @param string $exceptionText
     * @param string $method
     * @throws Exception
     */
    public static function coreException($exceptionText = '', $method = '')
    {
        $additionalMethod = '';
        if ($method) {
            $additionalMethod = ' in ' . $method;
        }
        $showException = 'Framework Core Exception' . $additionalMethod . ': ' . $exceptionText;
        throw new Exception($showException);
    }

    /**
     * Render Core exception with passed text.
     *
     * @param string $exceptionText. Required parameter. Exception message text.
     * @param string $method. Not Required. If pass exception will show in what exactly method throws Exception
     * @throws Exception
     */
    public static function sqlException($exceptionText, $method = '')
    {
        $additionalMethod = '';
        if ($method) {
            $additionalMethod = ' in ' . $method;
        }
        $showException = 'Framework MySQL Exception' . $additionalMethod . ': ' . $exceptionText;
        throw new Exception($showException);
    }

    /**
     * Directly include class file
     * @param $instance
     * @return string
     */
    public static function getRequiredInstancePath($instance)
    {
        $realPath = '';
        foreach ($instance as $part) {
            $realPath .= $part.'/';
        }
        return substr($realPath, 0, -1);
    }

    public static function getRequiredFiles()
    {
        return array(
            'Loader.php',
            'Router.php',
            'Config.php',
            'Core/Origin/Root.php',
            'Core/Origin/Controller.php',
            'Core/Origin/Model.php',
            'Core/Origin/View.php');
    }
}
