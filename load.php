<?php

/*
 * JohnCMS NEXT Mobile Content Management System (http://johncms.com)
 *
 * For copyright and license information, please see the LICENSE.md
 * Installing the system or redistributions of files must retain the above copyright notice.
 *
 * @link        http://johncms.com JohnCMS Project
 * @copyright   Copyright (C) JohnCMS Community
 * @license     GPL-3
 */

define('_IN_JOHNCMS', 1);

require('system/bootstrap.php');

$id = isset($_REQUEST['id']) ? abs(intval($_REQUEST['id'])) : 0;

/** @var Psr\Container\ContainerInterface $container */
$container = App::getContainer();

/** @var PDO $db2 */
$db2 = $container->get(PDO::class);

/** @var Johncms\Api\UserInterface $systemUser */
$systemUser = $container->get(Johncms\Api\UserInterface::class);

/** @var Johncms\Api\ToolsInterface $tools */
$tools = $container->get(Johncms\Api\ToolsInterface::class);

/** @var Johncms\Api\ConfigInterface $config */
$config = $container->get(Johncms\Api\ConfigInterface::class);

$user_id = $systemUser->id;
$rights = $systemUser->rights;

$REQUEST_URI = $_SERVER['REQUEST_URI'];
if ($_SERVER["QUERY_STRING"]) {
    $REQUEST_URI = explode("?", $REQUEST_URI)[0];
}

$url = [];
$fr2url = explode('/', mb_substr(urldecode($REQUEST_URI), 1, mb_strlen(urldecode($REQUEST_URI))));
if ($fr2url){
    foreach($fr2url as $frurl){
        if ($frurl) $url[] = $frurl;
    }
}


if (!function_exists("name")) {
    function name($str) {
        return mb_strtolower(
            str_replace(" ", "-", $str)
        );
    }
}


if($url[0] != 'admin') {
    
$url2 = $url;
array_shift($url);

$langs_list = $db->in_array("SELECT * FROM langs_list");
$langs_arr = [];
foreach ($langs_list as $lang_arr) {
    array_push($langs_arr, $lang_arr["flag_icon"]);
}

// tilni o'zgaruvchiga olib aniq qilib olish
$lng = !empty($_COOKIE["lang"]) ? $_COOKIE["lang"] : "ru";

if (!$url2[0]) {
    header("Location: /$lng/");
}

if (
    !empty($url2[0]) && 
    !in_array($url2[0], $langs_arr) && 
    $url2[0] != "admin" && 
    $url2[0] != "login" &&
    $url2[0] != "en"
) {
    header("Location: "."/$lng".urldecode($_SERVER["REQUEST_URI"]));
    exit;
}

if ($_COOKIE["lang"] != $url2[0] && $url2[0] != "login" && $url2[0] != "admin") {
    $lng = $url2[0];
    addCookie("lang", $url2[0]);
}
// print_r($_COOKIE);
// exit;

$all_words = $db->in_array("SELECT * FROM words");
function translate($string){
    global $db, $all_words, $lng;

    $lng2 = $lng == "en" ? "gb" : $lng;
    
    if ($lng == "uz") {
        return $string;
    } else {
        foreach ($all_words as $word) {
            if (mb_strtolower($word["uz"]) == mb_strtolower($string)) {
                return $word[$lng2];
            }
        }
        return $string;
    }
}

function isJson($string) {
    return !empty($string) && is_string($string) && is_array(json_decode($string, true)) && json_last_error() == 0;
}

function lng($json, $lng_param = false) {
    global $lng;
    $lng2 = $lng == "en" ? "gb" : $lng;

    if ($lng_param) $lng2 = $lng_param;

    if (isJson($json)){
        $json = json_decode($json, true);
        if ($json[$lng2]) {
            return $json[$lng2];
        } else {
            return "";
        }
    } else {
        return $json;
    } 
}
}

$permissions = false;
if ($systemUser["permissions"]) {
    $permissions = json_decode($systemUser["permissions"], true);
}
// if(!$permissions) {
// }
// print_r($url[0]);
// exit;

if ($url[0] == "admin" && $url[0] != "login" && $url[0] != "exit" && $url[0] != "api" && $url[0] != "auth") {
    if($permissions && $url[1]){
        if (isAuth() === false) {
            header("Location: /login");
        } else {
            if (!$permissions || !in_array($url[1], $permissions)) {
                echo "Sizda ushbu sahifaga kirish uchun huquqlar yetarli emas!";
                http_response_code(404);
                exit;
            }
        }
    }
}


$load_defined = true;
if ($url2[0] == "login") {
    include "login.php";
} else if ($url[0] == "admin" && $url[0] != "auth") {
    if($systemUser["role"] == 'admin' || $systemUser["role"] == 'teacher') {
        $url[1] = $url[1] ? $url[1] : "index";
        // if (substr($url[1], -4) == ".php") $url[1] = substr($url[1], 0, -4);

        if (file_exists("$url[0]/$url[1].php") && !$is_config) {
            include "$url[0]/$url[1].php";
        }
    } else if($systemUser["role"] != '' && $systemUser["role"] == 'student') {
        echo '<h1>siz admin lavozimida emassiz!<br>admin lavozimidagi akkauntga kirish uchun <a class="btn btn-sm btn-danger" href="/exit">akkauntdan chiqish</a> tugmasini bosing.</h1>';
        exit(http_response_code(404));
        exit();
    }
} else if ($url[0] != "admin" && $url[0] != "auth") {
    
    if (file_exists("$url[0]/$url[1].php") && !$is_config) {
        include "$url[0]/$url[1].php";
    }
    if (!$url[0]) {
        include "index.php";
        exit;
    } else if (!$is_config && file_exists("$url[0].php")) {
        include "$url[0].php";
    } else {
        if($url[0] == "admin") {
            echo "404 [1]";
            exit(http_response_code(404));
        }
    }
} else {
    if($url[0] != "auth") {
        echo "404 [2]";
        exit(http_response_code(404));
    }
}
?>