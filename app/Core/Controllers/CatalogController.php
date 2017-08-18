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
class Core_Controllers_CatalogController extends Core_Origin_Controller
{

    public function indexAction()
    {
        $this->renderLayout(array('category/view'));
    }
}