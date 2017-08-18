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
class Core_Origin_Controller extends Core_Origin_Root
{

    /**
     * TODO: Need to transfer all into getRequest
     *
     * @deprecated use getRequest instead.
     *
     * @return mixed
     */
    public function getPost() {

        return $_POST;
    }

    public function getRequest()
    {
        $request = null;
        if ($_POST) {
            $request = $_POST;
        }

        if ($_GET) {
            $request = $_GET;
        }

        return $request;
    }

}
