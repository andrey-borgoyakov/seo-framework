<?php

class Core_Controllers_SitemapController extends Core_Origin_Controller {

    public $passed = 0;
    public $failed = 0;
    public $failedUrls = array();

    public function indexAction() {
        Runner::getInstance('Core/Models/Viewer')->renderTemplate('sitemap/home');
        Runner::getInstance('Core/Models/Viewer')->renderTemplate('sitemap/request-form');
    }

    public function postAction() {
        $errors     = array();
        $postData   = $this->getPost();
        $sitemapUrl = $postData['sitemap'];
        if ( ! Runner::getInstance('Core/Models/Sitemap')->validateMapUrl($sitemapUrl)) {
            $errors[] = 'Sitemap not valid because return status 404 Not Found';
        }
        if (stripos($sitemapUrl, '://') === false) {
            $errors[] = 'Invalid sitemap, you must specifiied http Protocol';
        }

        if (stripos($sitemapUrl, '.xml') === false) {
            $errors[] = 'Invalid sitemap, you must specifiied extension of file';
        }

        if ($errors) {
            $this->sitemapErrorsAction($errors);
        } else {
            $this->proccessRequestAction($sitemapUrl);
        }

    }

    public function proccessRequestAction($sitemapUrl) {
        $i    = 0;
        $urls = $this->getAllUrlsAction($sitemapUrl);
        foreach ($urls as $url) {
            $i++;
            if (Runner::getInstance('Core/Models/Sitemap')->getUrlHttpStatus($url) == 200) {
                $this->passed ++;
            } else {
                $this->failed ++;
                $this->failedUrls[] = $url;
            }
        }
        $this->completeAction();
    }

    public function completeAction() {
        $completeData                = array();
        $completeData['passed']      = $this->passed;
        $completeData['failed']      = $this->failed;
        $completeData['failed_urls'] = $this->failedUrls;
        $GLOBALS['sitemap_result']   = $completeData;
        Runner::getInstance('Core/Models/Viewer')->renderTemplate('sitemap/complete');
    }


    public function getAllUrlsAction($map) {
        $urls                            = array();
        $DomDocument                     = new DOMDocument();
        $DomDocument->preserveWhiteSpace = false;
        $DomDocument->load($map);
        $DomNodeList = $DomDocument->getElementsByTagName('loc');

        foreach ($DomNodeList as $url) {
            $urls[] = $url->nodeValue;
        }

        return $urls;
    }

    public function sitemapErrorsAction($errors) {
        $GLOBALS['errors'] = $errors;
        Runner::getInstance('Core/Models/Viewer')->renderTemplate('sitemap/errors');
    }
}