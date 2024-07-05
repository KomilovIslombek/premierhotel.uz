<?php

if (substr($_SERVER['HTTP_HOST'], 0, 4) === 'www.') {
    header('Location: http'.(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on' ? 's':'').'://' . substr($_SERVER['HTTP_HOST'], 4).$_SERVER['REQUEST_URI']);
    exit;
}

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

?>
<!DOCTYPE html>
<html lang="<?=$url2[0]?>">
<head>
    <meta name="google-site-verification" content="0F-qejnWxtLH30wDGTjtk8GIhemSB9HJ5C8W7-zV60g" />
    <base href="<?=$domain?>">
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>PREMIER HOTEL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="keywords" content="<?=lng($home['text_51'])?>">
    <meta name="author" content="premierhotel.uz">
    <!-- Telegram -->
    <meta property="og:type" content="article">
    <meta property="og:url" content="<?=$full_link?>">
    <meta property="og:site_name" content="premierhotel.uz">
    <? if($url[0] == 'room') {?>
        <meta name="description" content="premierhotel.uz <?=lng($room['description'])?>">
        <meta property="og:title" content="<?=lng($room['name'])?>">
        <meta property="og:description" content="premierhotel.uz <?=lng($room['description'])?>">
    <? } else { ?>
        <meta name="description" content="premierhotel.uz <?=lng($home['text_52'])?>">
        <meta property="og:title" content="Хотел в андижане">
        <meta property="og:description" content="premierhotel.uz <?=lng($home['text_52'])?>">
    <? } ?>
    <meta property="og:image" content="<?=$domain?>/theme/vora/images/logo.png">
    <meta property="og:image:width" content="100">
    <meta property="og:image:height" content="100">
    <!-- <meta property="og:image" content="<img class="  >" -->
    
    <meta property="article:author" content="premierhotel.uz">
    <!-- Place favicon.ico in the root directory -->
    
    <!-- CSS here -->
    <link rel="shortcut icon" type="image/x-icon" href="../theme/riorelax/img/fav-logo.ico" defer>
    <link rel="stylesheet" href="../theme/riorelax/css/bootstrap.min.css" defer>
    <link rel="stylesheet" href="../theme/riorelax/css/animate.min.css" defer>
    <link rel="stylesheet" href="../theme/riorelax/css/magnific-popup.css" defer>
    <link rel="stylesheet" href="../theme/riorelax/fontawesome/css/all.min.css" defer>
    <link rel="stylesheet" href="../theme/riorelax/css/dripicons.css" defer>
    <link rel="stylesheet" href="../theme/riorelax/css/slick.css" defer>
    <link rel="stylesheet" href="../theme/riorelax/css/meanmenu.css" defer>
    <link rel="stylesheet" href="../theme/riorelax/css/default.css" defer>
    <link rel="stylesheet" href="../theme/riorelax/css/style.css?v=1.0.2" defer>
    <link rel="stylesheet" href="../theme/riorelax/css/responsive.css" defer>

    <!-- Flag icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css">

    <? if($url[0] == "room") { ?>
        <link rel="stylesheet" href="theme/riorelax/css/swiper-bundle.css?v=1.0.1">
    <? } ?>
</head>
<body>
    
    <?
    include "header.php";
    ?>