<?php

/**
 * GNU GENERAL PUBLIC LICENSE.
 * Copyright (C) 2007 Free Software Foundation, Inc. <http://fsf.org/>
 * {Disclaimer}.
 * {Licence}. You can read public licence here
 * @link https://github.com/andrey-borgoyakov/microshop/blob/master/LICENSE
 * {version}.
 * {copyright} Seo Framework. (c) 2017
 * Created by Andrey Borgoyakov. @link
 */
class Core_Controllers_AjaxController extends Core_Origin_Controller
{

    public function indexAction()
    {
        echo 1; exit;
    }

    /**
     * Default action
     */
    public function requestAction()
    {

        // Array with names
        $a[] = "Anna";
        $a[] = "Brittany";
        $a[] = "Cinderella";
        $a[] = "Diana";
        $a[] = "Eva";
        $a[] = "Fiona";
        $a[] = "Gunda";
        $a[] = "Hege";
        $a[] = "Inga";
        $a[] = "Johanna";
        $a[] = "Kitty";
        $a[] = "Linda";
        $a[] = "Nina";
        $a[] = "Ophelia";
        $a[] = "Petunia";
        $a[] = "Amanda";
        $a[] = "Raquel";
        $a[] = "Cindy";
        $a[] = "Doris";
        $a[] = "Eve";
        $a[] = "Evita";
        $a[] = "Sunniva";
        $a[] = "Tove";
        $a[] = "Unni";
        $a[] = "Violet";
        $a[] = "Liza";
        $a[] = "Elizabeth";
        $a[] = "Ellen";
        $a[] = "Wenche";
        $a[] = "Vicky";

// get the q parameter from URL
        $q = $_REQUEST["q"];

        $hint = "";

// lookup all hints from array if $q is different from ""
        if ($q !== "") {
            $q = strtolower($q);
            $len = strlen($q);
            foreach ($a as $name) {
                if (stristr($q, substr($name, 0, $len))) {
                    if ($hint === "") {
                        $hint = $name;
                    } else {
                        $hint .= ", $name";
                    }
                }
            }
        }

// Output "no suggestion" if no hint was found or output correct values
        echo $hint === "" ? "no suggestion" : $hint;
    }

}