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
class Core_Origin_View extends Core_Origin_Root
{
    const DEFAULT_THEME = 'default';

    /**
     * Render Template file via path
     * @param string $template
     */
    public function renderTemplate($template = '')
    {
        include $this->getTemplate($template);
    }

    public function getTemplate($template)
    {
        if (!$template) {
            Runner::coreException('Template name must be specified');
            die();
        }

        $themePath = Runner::getInstance('Filesystem/Commuter')->getSkinDirectoryPath() . self::DEFAULT_THEME;
        $templateFile = $themePath.'/templates/' . $template. Router::TEMPLATE_EXTENSION;

      /*  if(!file_exists($templateFile)) {
            Runner::coreException('Template file not exits. Path: ' . $templateFile);
            die();
        } */

        return $themePath . '/templates/' . $template . Router::TEMPLATE_EXTENSION;
    }

    /**
     * Get currently used theme. Should configure in admin (nearest future)
     *
     * @return string
     */
    public function getUsedTheme()
    {
        return self::DEFAULT_THEME;
    }

    /**
     * Get currently used theme CSS folder
     *
     * @return string
     */
    public function getThemeCssPath()
    {
        /** check if custom theme set in admin */
        if($this->getUsedTheme()) {
            $usedTheme = $this->getUsedTheme();
        } else {
            $usedTheme = self::DEFAULT_THEME;
        }

        return '/app/themes/'. $usedTheme. '/css/';
    }

    /**
     * Get currently used theme JS folder
     *
     * @return string
     */
    public function getThemeJsPath()
    {
        /** check if custom theme set in admin */
        if($this->getUsedTheme()) {
            $usedTheme = $this->getUsedTheme();
        } else {
            $usedTheme = self::DEFAULT_THEME;
        }

        return '/app/themes/'. $usedTheme. '/js/';
    }

    public function getVersion()
    {
        return '0.0.0 (Alpha Preview)';
    }

    public function getCopyRight()
    {
        return 'Copyright by ABDev. All right reserved. (c) 2017';
    }


    public function getHeader()
    {
        $this->renderTemplate('header');
    }

    public function getFooter()
    {
        $this->renderTemplate('footer');
    }

    /**
     * If Param not passed return base Url
     *
     * @param $path
     *
     * @return string
     */
    public function getUrl( $path = null ) {
        $result = '/';
        if ( $path ) {
            $result = 'http://' . $_SERVER['HTTP_HOST'] . '/' . $path;
        }

        return $result;
    }

}
