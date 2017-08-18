<?php

class Core_Controllers_SitemapController extends Core_Origin_Controller {

    public $passed = 0;
    public $failed = 0;
    public $failedUrls = array();

    /**
     * Default action
     */
    public function indexAction()
    {
        $this->renderTemplate(array('sitemap/home', 'sitemap/request-form'));
    }

    /**
     * Main post action with triggering process
     */
    public function postAction()
    {
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

    /**
     * Process parsing and collection response of each url
     *
     * @param $sitemapUrl
     */
    public function proccessRequestAction($sitemapUrl)
    {
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

    /**
     * Final action with summary information
     */
    public function completeAction()
    {
        $completeData                = array();
        $completeData['passed']      = $this->passed;
        $completeData['failed']      = $this->failed;
        $completeData['failed_urls'] = $this->failedUrls;
        $GLOBALS['sitemap_result']   = $completeData;
        Runner::getInstance('Core/Models/Viewer')->renderTemplate('sitemap/complete');
    }


    /**
     * Return all urls from sitemap.xml as Array
     *
     * @param $map
     * @return array
     */
    public function getAllUrlsAction($map)
    {
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

    /**
     * Collect sitemap errors
     *
     * @param $errors
     */
    public function sitemapErrorsAction($errors)
    {
        $GLOBALS['errors'] = $errors;
        $this->renderTemplate('sitemap/errors');
    }
}