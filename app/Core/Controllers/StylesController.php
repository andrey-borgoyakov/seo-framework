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
 *
 * Class Core_Controllers_StylesController
 */
class Core_Controllers_StylesController extends Core_Origin_Controller
{

    /**
     * Index Action
     */
    public function indexAction()
    {
        $this->renderTemplate(array('styles/home', 'styles/request-form'));
    }

    /**
     * Process finding inline styles
     */
    public function processAction()
    {
        $count = null;
        $url   = $this->getRequest('url');
        if (Runner::getInstance('Core/Origin/Validator')->validateUrl($url)) {
            $content = $this->getContentAction($url);
            preg_match_all('/style=/', $content, $matches, PREG_PATTERN_ORDER);
            foreach ($matches as $match) {
                $count = count($match);
            }
            if ($count) {
                $this->addNotice('Inline Style found', 'warning');
                $this->renderTemplate('styles/recs/found');
            }
        } else {
            $this->indexAction();
        }
    }

    /**
     * Return html response of url
     *
     * @param $url
     * @return mixed
     */
    public function getContentAction($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        $content = curl_exec($ch);
        curl_close($ch);

        return $content;
    }
}
