<?php

/**
 * Created by PhpStorm.
 * User: andre
 * Date: 3/12/2017
 * Time: 7:53 PM
 */
class Core_Origin_Admin_Settings extends Root
{

    public function getConfigValue($setting)
    {
       $dbConnection = Runner::getInstance('Core/Origin/Connector')->getConnection();
    }

}
