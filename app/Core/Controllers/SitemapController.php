<?php
class Core_Controllers_SitemapController extends Core_Origin_Controller
{
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
        $url = $this->getRequest('sitemap');
        if (Runner::getInstance('Core/Origin/Validator')->validateUrl($url , '.xml')) {
            $this->proccessRequestAction($url);
        } else {
            $this->indexAction();
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
        $this->renderTemplate('sitemap/complete');
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
}
