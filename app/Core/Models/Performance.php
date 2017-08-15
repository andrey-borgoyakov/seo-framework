<?php

class Core_Models_Performance extends Core_Origin_Model {
    public $allTests = array();

    public function collectResponseTime($url)
    {
        $responseTime = null;
        $ch = null;
        for ($x = 0; $x <= 50; $x ++) {
            $ch           = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_exec($ch);
            $responseTime += curl_getinfo($ch, CURLINFO_STARTTRANSFER_TIME);
        }
        $average                        = $responseTime / 50;
        $this->allTests['average_time'] = number_format($average, 2, '.', '');
        curl_close($ch);

        return $this->allTests;

    }

}