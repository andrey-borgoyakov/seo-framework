<?php

class Core_Controllers_StylesController extends Core_Origin_Controller
{
    public function indexAction()
    {
        Runner::getInstance('Core/Models/Viewer')->renderTemplate('styles/home');
        Runner::getInstance('Core/Models/Viewer')->renderTemplate('styles/request-form');
    }

    public function processAction()
    {
        $data = $this->getPost();
        if (isset($data['url'])) {
            $content = $this->getContentAction($data['url']);
            $finded = $this->findAction($content);

        }
    }

    public function getContentAction($url)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
        $content = curl_exec($ch);
        curl_close($ch);

        return $content;
    }

    public function findAction($string)
    {
        $pos = strpos($string, 'style');

        if ($pos === false) {
            $result = "The string 'style' was not found in this page.";
        }
        else {
            $result = "The string 'style' was found in the string on this page,";
            $result .= " and exists at position $pos.";
        }
        return $result;
    }
}