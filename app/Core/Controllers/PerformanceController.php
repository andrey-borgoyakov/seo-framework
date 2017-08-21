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
class Core_Controllers_PerformanceController extends Core_Origin_Controller
{

    /**
     * Default index action
     */
    public function indexAction()
    {
        $this->renderTemplate(array('performance/home', 'performance/request-form'));
    }

    /**
     * Main process action
     */
    public function processAction()
    {
        $url = $this->getRequest('url');
        if (Runner::getInstance('Core/Origin/Validator')->validateUrl($url)) {
            $responseTime = Runner::getInstance('Core/Models/Performance')->collectResponseTime($url);
            $GLOBALS['performance_test'] = $responseTime;
            if ((int)$GLOBALS['performance_test'] > 0.20) {
                $this->addNotice("Your response time slower that needed.", 'warning');
            }
            if ((int)$GLOBALS['performance_test'] < 0.20) {
                $this->addNotice("Test completed. Response time is good!", 'success');
            }
            $this->renderTemplate('performance/complete');
        } else {
            $this->indexAction();
        }
    }
}
