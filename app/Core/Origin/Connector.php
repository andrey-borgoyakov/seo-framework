<?php

/**
 * GNU GENERAL PUBLIC LICENSE.
 * Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
 * {Disclaimer}.
 * {Licence}. You can read public licence here
 * @link https://github.com/andrey-borgoyakov/microshop/blob/master/LICENSE
 * {version}.
 * {copyright} Tiny Shop CMS. (c) 2017
 * Created by Andrey Borgoyakov. @link
 */
class Core_Origin_Connector
{

    public function getConnection()
    {
        $server = "localhost";
        $username = "root";
        $password = "mul2ler0";
        $db = 'runnerstore';

        try {
            $pdo = new PDO("mysql:host=$server;dbname=$db", $username, $password);
            // set the PDO error mode to exception
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e)
        {
            Runner::sqlException($e->getMessage(), 'getConnection');
        }

        return $pdo;
    }

    /**
     * Insert to database method.
     *
     * @param $table string
     * @param $data array()
     *
     * @throws Exception
     */
    public function insert($table, $data = array())
    {
        $attributes = array();
        $values     = array();
        foreach ($data as $key => $value) {
            $attributes[] = $key;
            $values[]     = $value;
        }

        $preparedAttributes = $this->prepareAttributesString($attributes);
        $preparedValues = $this->prepareValuesString($values);

       // 'INSERT INTO config (firstname, lastname, username) VALUES ('Andrey', 'Sorname', 'test1')';
        try {
            $pdo = $this->getConnection();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $sql = "INSERT INTO $table ($preparedAttributes) VALUES ('$preparedValues')";
            $pdo->exec($sql);
        } catch (PDOException $e) {
            Runner::sqlException($e->getMessage(), 'Core_Origin_Connector::insert()');
        }

        $pdo = null;
    }

    /**
     * Select form database method.
     *
     * @param $attribute
     * @param $table
     * @param $data
     * @param $value
     *
     * @throws Exception
     */
    public function select($attribute, $table, $data, $value)
    {

        try {
            $pdo = $this->getConnection();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo->prepare("SELECT $attribute FROM $table WHERE $data = $value");
            $stmt->execute();

            $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
            var_dump($result);
        } catch (PDOException $e) {
            Runner::sqlException($e->getMessage(), 'Core_Origin_Connector::select()');
        }
        $connection = null;
    }

    /**
     * Prepare attributes string without '' for each attribute in string
     *
     * @param $attributes
     * @return string
     */
    private function prepareAttributesString($attributes)
    {
        return implode(', ', $attributes);
    }

    /**
     * Prepare attributes string with '' for each attribute in string
     *
     * @param $values
     * @return string
     */
    private function prepareValuesString($values)
    {
        return implode("', '",  $values);
    }

}
