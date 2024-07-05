<?php
// echo "<pre>";
// exit(print_r([
//     "encode" => encode("Pr#mR@Hol#L2023"), // pasword_encrypted
//     "md5(md5(encode(" => md5(md5(encode("Pr#mR@Hol#L2023"))), // password uchun
// ]));
// echo "</pre>";
// exit;
date_default_timezone_set("Asia/Tashkent");

// print_r($permissions[0]);
// echo "Hello";
// exit;
if (isAuth() == true) {
    header("Location: /admin/$permissions[0]");
    // header("Location: /admin/");
    exit;
}

$error = false;
if ($_POST["submit"]) {
    $login = trim(htmlspecialchars($_POST['login'], ENT_QUOTES));
    $password = trim(htmlspecialchars($_POST['password'], ENT_QUOTES));

    if (!$login) {
        $error = "loginni kiritishni unutdingiz!";
    }

    if (!$password) {
        $error = "parolni kiritishni unutdingiz!";
    }

    if ($login && $password) {
        $user = $db->assoc("SELECT * FROM users WHERE login = ? AND password = ?", [ $login, md5(md5(encode($password))) ]);
    }

    if ($login && $password && empty($user["id"])) {
        $error = "Login yoki parol xato!";
    } else {
        $db->update("users", [
            // "password" => md5(md5(encode($password))),
            // "password_encryped" => encode($password),
            "failed_login" => 0,
            // "blocked_time" => date("Y.m.d H:i:s", time() - 60),
            "sestime" => time()
        ], [
            "id" => $user['id']
        ]);

        $session = md5($env->getIp() . $env->getIpViaProxy() . $env->getUserAgent());
        $sessionArr = $db->assoc("SELECT * FROM cms_sessions WHERE session_id = ?", [ $session ]);

        if (!empty($sessionArr["session_id"])) {
            $sql_arr = [];
            $movings = ++$user["movings"];

            if ($user["sestime"] < (time() - 300)) {
                $movings = 1;
                $sql_arr["sestime"] = time();
            }

            if ($user["place"] != $headmod) {
                $sql_arr["place"] = "/login";
            }

            $sql_arr["movings"] = $movings;
            $sql_arr["lastdate"] = time();

            $db->update("cms_sessions", $sql_arr, [
                "session_id" => $session
            ]);
        } else {
            $db->insert("cms_sessions", [
                "session_id" => $session,
                "ip" => $env->getIp(),
                "ip_via_proxy" => $env->getIpViaProxy(),
                "browser" => $env->getUserAgent(),
                "lastdate" => time(),
                "sestime" => time(),
                "place" => "/login"
            ]);
        }

        // exit($session);
    
        // Cookie ni o'rnatish
        $cuid = base64_encode($user['id']);
        $cups = md5(encode($password));
        addCookie("cuid", $cuid);
        addCookie("cups", $cups);
    
        // header("Location: /");
        header("Location: /admin/$permissions[0]");
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <base href="<?=$domain?>">
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="format-detection" content="telephone=no">
    <link rel="shortcut icon" type="image/x-icon" href="../theme/riorelax/img/fav-logo.ico">
	
	<!-- PAGE TITLE HERE -->
	<title>PREMIER - HOTEL</title>
	<!-- FAVICONS ICON -->
	<!-- <link rel="shortcut icon" type="image/png" href="theme/vora/images/favicon.png" /> -->
	<link href="theme/vora/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Icons"rel="stylesheet">
    <link href="theme/vora/css/style.css" rel="stylesheet">

</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
					<div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
									<div class="text-center mb-3">
										<a href="/<?=$url[0]?>">
                                            <!-- <img src="theme/vora/images/full-logo.png" alt="brand logo"> -->
                                            <!-- <img src="theme/vora/images/left-WHITE.png" alt="logo icon"> -->
                                            <img style="width: 220px;" src="../theme/riorelax/img/logo/p-logo.png" alt="">
                                            <!-- <img style="margin-left: -7px; !important" src="theme/vora/images/right-WHITE.png" alt=""> -->
                                        </a>
									</div>
                                    <h4 class="text-center mb-4 text-white">Akkauntga kirish</h4>

                                    <? if ($error) { ?>
                                        <h5 class="text-center mb-4 text-white"><?=$error?></h5>
                                    <? } ?>
                                    
                                    <form method="POST">
                                        <div class="form-group">
                                            <label class="mb-1 text-white"><strong>Login</strong></label>
                                            <input type="text" name="login" class="form-control" placeholder="login" value="<?=$_POST["login"]?>">
                                        </div>

                                        <div class="form-group">
                                            <label class="mb-1 text-white"><strong>Parol</strong></label>
                                            <input type="password" name="password" class="form-control" placeholder="******">
                                        </div>

                                        <div class="text-center mt-4">
                                            <button type="submit" name="submit" class="btn bg-white text-primary btn-block" value="Kirish">Kirish</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<!--**********************************
	Scripts
***********************************-->
<!-- Required vendors -->
<script src="theme/vora/vendor/global/global.min.js"></script>
<script src="theme/vora/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>

<script src="theme/vora/js/custom.min.js"></script>
<script src="theme/vora/js/dlabnav-init.js"></script>

</body>
</html>