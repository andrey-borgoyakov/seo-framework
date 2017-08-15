<?php

/**
 * GNU GENERAL PUBLIC LICENSE.
 * Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
 * {Disclaimer}.
 * {Licence}. You can read public licence here
 * @link https://github.com/andrey-borgoyakov/microshop/blob/master/LICENSE
 * {version}.
 * {copyright} Seo Framework. (c) 2017
 * Created by Andrey Borgoyakov. @link
 */
class Core_Origin_Session
{
    const SESSION_STARTED = TRUE;
    const SESSION_NOT_STARTED = FALSE;

    // The state of the session
    private $sessionState = self::SESSION_NOT_STARTED;

    // THE only instance of the class
    private static $instance;


    /**
     * Returns THE instance of 'Session'.
     * The session is automatically initialized if it wasn't.
     *
     *  @return object
     */

    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }
        self::$instance->startSession();
        return self::$instance;
    }


    /**
     * (Re)starts the session.
     *
     * @return bool TRUE if the session has been initialized, else FALSE.
     */

    public function startSession()
    {
        if ($this->sessionState == self::SESSION_NOT_STARTED) {
            $this->sessionState = session_start();
        }

        return $this->sessionState;
    }


    /**
     * Stores datas in the session.
     * Example: $instance->foo = 'bar';
     *
     * @param $name | of the data.
     * @param $value | Your data.
     * @return void
     */

    public function __set($name, $value)
    {
        $_SESSION[$name] = $value;
    }


    /**
     * Gets data from the session.
     * Example: echo $instance->foo;
     *
     * @param $name | Name of the datas to get.
     * @return mixed Data stored in session.
     */

    public function __get($name)
    {
        $value = null;
        if (isset($_SESSION[$name])) {
            $value = $_SESSION[$name];
        }

        return $value;
    }


    public function __isset($name)
    {
        return isset($_SESSION[$name]);
    }


    public function __unset($name)
    {
        unset($_SESSION[$name]);
    }


    /**
     * Destroy current session.
     *
     * @return bool TRUE is session has been deleted, else FALSE.
     */

    public function destroy()
    {
        if ($this->sessionState == self::SESSION_STARTED) {
            $this->sessionState = !session_destroy();
            unset($_SESSION);

            return !$this->sessionState;
        }

        return false;
    }
}