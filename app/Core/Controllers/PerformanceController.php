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
        var_dump($responseTime);
        if ((int)$GLOBALS['performance_test'] > 0.20) {
            $this->addNotice("Your response time slower that needed.", 'warning');
        }
        if ((int)$GLOBALS['performance_test'] < 0.20){
            $this->addNotice("Test completed. Response time is good!", 'success');
        }

        $this->renderTemplate('performance/complete');
    }
}