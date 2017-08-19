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
abstract class Core_Origin_Root
{

    public function renderTemplate($path)
    {
       return Runner::getInstance('Core/Origin/View')->renderTemplate($path);
    }

    public function getVersion()
    {
        return '0.0.2 ( α )';
    }

    public function getCopyRight()
    {
        return 'Copyright by Andrey Borgoyakov . All right reserved with GNU GENERAL PUBLIC LICENSE. (c) 2017 '
            . $this->getVersion();
    }

    public function addNotice($message, $type = null)
    {
        if (!$type) {
            Runner::coreException('Required type of notice not specified', 'Core_Origin_Root::addNotice');
        }

        $GLOBALS['core_notification'] = $message;
        $this->renderTemplate('notices/' . $type);
    }
}
