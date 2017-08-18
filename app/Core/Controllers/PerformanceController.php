<?php

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
        $data = $this->getPost();
        $responseTime = Runner::getInstance('Core/Models/Performance')->collectResponseTime($data['url']);
        $GLOBALS['performance_test'] = $responseTime;
        $this->renderTemplate('performance/complete');
    }
}