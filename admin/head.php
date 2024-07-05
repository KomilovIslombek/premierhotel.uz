<?php

// if (substr($_SERVER['HTTP_HOST'], 0, 4) === 'www.') {
//     header('Location: http'.(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 's':'').'://' . substr($_SERVER['HTTP_HOST'], 4).$_SERVER['REQUEST_URI']);
//     exit;
// }

date_default_timezone_set('Asia/Tashkent');

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

defined('_IN_JOHNCMS') or die('Error: restricted access');

/** @var Psr\Container\ContainerInterface $container */
$container = App::getContainer();

/** @var PDO $db2 */
$db2 = $container->get(PDO::class);

/** @var Johncms\Api\ToolsInterface $tools */
$tools = $container->get(Johncms\Api\ToolsInterface::class);

/** @var Johncms\Api\EnvironmentInterface $env */
$env = $container->get(Johncms\Api\EnvironmentInterface::class);

/** @var Johncms\Api\UserInterface $systemUser */
$systemUser = $container->get(Johncms\Api\UserInterface::class);

/** @var Johncms\Api\ConfigInterface $config */
$config = $container->get(Johncms\Api\ConfigInterface::class);

// $act = isset($_REQUEST['act']) ? trim($_REQUEST['act']) : '';
// $headmod = isset($headmod) ? $headmod : '';
// $textl = isset($textl) ? $textl : $config['copyright'];
// $keywords = isset($keywords) ? htmlspecialchars($keywords) : $config->meta_key;
// $descriptions = isset($descriptions) ? htmlspecialchars($descriptions) : $config->meta_desc;


// Фиксация местоположений посетителей
$sql = '';
$set_karma = $config['karma'];

$user_id = $systemUser->id;
$rights = $systemUser->rights;

if ($systemUser["id"]) {
    // Фиксируем местоположение авторизованных
    $movings = $systemUser->movings;

    if ($systemUser->lastdate < (time() - 300)) {
        $movings = 0;
        $sql .= " `sestime` = " . time() . ", ";
    }

    if ($systemUser->browser != $env->getUserAgent()) {
        $sql .= " `browser` = " . $db2->quote($env->getUserAgent()) . ", ";
    }

    $totalonsite = $systemUser->total_on_site;

    if ($systemUser->lastdate > (time() - 300)) {
        $totalonsite = $totalonsite + time() - $systemUser->lastdate;
    }
    
    $db->update("users", [
        "movings" => $movings,
        "total_on_site" => $totalonsite,
        "lastdate" => time(),
    ], [
        "id" => $systemUser["id"]
    ], "no_logging");
} else {
    // Фиксируем местоположение гостей
    $movings = 0;
    $session = md5($env->getIp() . $env->getIpViaProxy() . $env->getUserAgent());
    $req = $db2->query("SELECT * FROM `cms_sessions` WHERE `session_id` = " . $db2->quote($session) . " LIMIT 1");

    if ($req->rowCount()) {
        // Если есть в базе, то обновляем данные
        $res = $req->fetch();
        $movings = ++$res['movings'];

        if ($res['sestime'] < (time() - 300)) {
            $movings = 1;
            $sql .= " `sestime` = '" . time() . "', ";
        }

        $db2->exec("UPDATE `cms_sessions` SET $sql
            `movings` = '$movings',
            `lastdate` = '" . time() . "'
            WHERE `session_id` = " . $db2->quote($session) . "
        ");
    } else {
        // Если еще небыло в базе, то добавляем запись
        $db2->exec("INSERT INTO `cms_sessions` SET
            `session_id` = '" . $session . "',
            `ip` = '" . $env->getIp() . "',
            `ip_via_proxy` = '" . $env->getIpViaProxy() . "',
            `browser` = " . $db2->quote($env->getUserAgent()) . ",
            `lastdate` = '" . time() . "',
            `sestime` = '" . time() . "'
        ");
    }
}

$full_link = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]");


$urls = implode("/", $url);


function isJson($string) {
    return !empty($string) && is_string($string) && is_array(json_decode($string, true)) && json_last_error() == 0;
}

function lng($json, $lng2) {

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

// admin view json datas to string uz language code 

function admin_lng($json, $lng_param = false) {
    $lng2 = "uz";

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
$homeId = $db->assoc('SELECT id FROM home');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <base href="<?=$domain?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="format-detection" content="telephone=no">
	
	<!-- PAGE TITLE HERE -->
	<title>PREMIER - HOTEL</title>
    <!-- Favicon icon -->
    <link rel="icon" sizes="16x16" href="../theme/riorelax/img/logo.png" type="image/png">
    <!-- <link rel="icon" type="image/png" sizes="16x16" href="../theme/vora/images/yangi-asr-logo.png"> -->
    <link href="../theme/vora/vendor/jqvmap/css/jqvmap.min.css?v=1.0.1" rel="stylesheet">
    <link rel="stylesheet" href="../theme/vora/vendor/chartist/css/chartist.min.css?v=1.0.1">
    <!-- Vectormap -->
    <link href="../theme/vora/vendor/jqvmap/css/jqvmap.min.css?v=1.0.1" rel="stylesheet">
    <link href="../theme/vora/vendor/bootstrap-select/dist/css/bootstrap-select.min.css?v=1.0.1" rel="stylesheet">
    <link href="../theme/vora/vendor/owl-carousel/owl.carousel.css?v=1.0.1" rel="stylesheet">
	<link href="../theme/vora/css/style.css?v=1.0.1" rel="stylesheet">
    <link rel="stylesheet" href="../theme/vora/vendor/select2/css/select2.min.css?v=1.0.1">
    <link rel="stylesheet" href="../theme/riorelax/fontawesome/css/all.min.css">
    <!-- Flag icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">

    <!-- plyr -->
    <link rel="stylesheet" href="https://cdn.plyr.io/3.7.3/plyr.css" />


    <!-- Datatable -->
    <link href="../theme/vora/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">

    <? if ($url[0] == "addStudent" || $url[0] == "editStudent" || $url[0] == "importStudent" || $url[0] == "addPayment" || $url[0] == "editPayment") { ?>
        <link href="../theme/vora/vendor/select2/css/select2.min.css?v=1.0.1" rel="stylesheet">
        <link href="../theme/vora/css/style.css?v=1.0.1" rel="stylesheet">
    <? } ?>
</head>
<body>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <?
        include "header.php";
        ?>