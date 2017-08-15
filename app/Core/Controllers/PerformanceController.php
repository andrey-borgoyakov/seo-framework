<?php

class Core_Controllers_PerformanceController extends Core_Origin_Controller
{

    public function indexAction()
    {
        Runner::getInstance('Core/Models/Viewer')->renderTemplate('performance/home');
        Runner::getInstance('Core/Models/Viewer')->renderTemplate('performance/request-form');
    }

    public function processAction()
    {
        $data = $this->getPost();
        $responseTime = Runner::getInstance('Core/Models/Performance')->collectResponseTime($data['url']);
        $GLOBALS['performance_test'] = $responseTime;
        Runner::getInstance('Core/Models/Viewer')->renderTemplate('performance/complete');


    }
}