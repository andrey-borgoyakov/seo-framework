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
class Core_Origin_Validator extends Core_Origin_Root
{
    /**
     * Validate sitemap availability
     *
     * @param $url | string
     * @param $extension | string
     * @return bool
     */
    public function validateUrl($url, $extension = null)
    {
        /** check if $url param exists */
        if (!$url) {
            $this->addNotice('You must specify url.', self::NOTICE_TYPE_ERROR);
            return false;
        }

        /** if need specific file extension, then check it */
        if ($extension && stripos($url, $extension) === false) {
            $this->addNotice('Invalid URL. You must specify file extension.', self::NOTICE_TYPE_ERROR);
            return false;
        }

        /** check if url contains protocol data */
        if (stripos($url, '://') === false) {
            $this->addNotice('Invalid url, you must specifiied http Protocol.', self::NOTICE_TYPE_ERROR);
            return false;
        }

        /** check url response  */
        if (!$this->getUrlHttpStatus($url) == 200) {
            $this->addNotice('Url not available please check that url specified correctly.', self::NOTICE_TYPE_ERROR);
            return false;
        }

        return true;
    }

        /**
         * Return http status code of Url
         *
         * @param $url
         * @return int
         */
        public function getUrlHttpStatus($url) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        $output   = curl_exec($ch);
        $httpResponse = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return (int)$httpResponse;
    }
}