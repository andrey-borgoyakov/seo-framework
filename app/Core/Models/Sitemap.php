<?php

class Core_Models_Sitemap extends Core_Origin_Model
{
    public function validateMapUrl($map) {
        $result = false;
        if ($this->getUrlHttpStatus($map) == 200) {
            $result = true;
        }

        return $result;
    }

    public function getUrlHttpStatus($map) {
        $ch = curl_init($map);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $output   = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return $httpcode;
    }

}
