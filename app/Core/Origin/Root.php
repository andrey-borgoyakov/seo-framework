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
    /** define basic types of framework notices for using in Core_Origin_Root::addNotice */
    const NOTICE_TYPE_ERROR   = 'error';
    const NOTICE_TYPE_WARNING = 'warning';
    const NOTICE_TYPE_NOTICE  = 'notice';
    const NOTICE_TYPE_SUCCESS = 'success';

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
        return 'Copyright (c) 2018 by Andrey Borgoyakov. | Development Preview v.' . $this->getVersion();
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
