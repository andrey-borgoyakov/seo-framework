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
class FileSystem_Commuter
{

    /**
     * Return root directory path
     *
     * @return string
     */
    public function getRootDirPath()
    {
        return $_SERVER['DOCUMENT_ROOT'];
    }

    public function getSkinDirectoryPath()
    {
        return $this->getRootDirPath(). '/app/themes/';
    }
}
