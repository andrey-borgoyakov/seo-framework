<?php

class Core_Models_Performance extends Core_Origin_Model {

    /** @var array used for collecting time tests data */
    public $allTests = array();

    /**
     * Return avarage value for connection time.
     *
     * @param $url
     * @return array
     */
    public function collectResponseTime($url)
    {
        $responseTime = null;
        $ch = null;
        for ($x = 0; $x <= 10; $x ++) {
            $ch           = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_exec($ch);
            $responseTime += curl_getinfo($ch, CURLINFO_STARTTRANSFER_TIME);
        }
        $average                        = $responseTime / 10;
        $this->allTests['average_time'] = number_format($average, 2, '.', '');
        curl_close($ch);

        return $this->allTests;

    }

}