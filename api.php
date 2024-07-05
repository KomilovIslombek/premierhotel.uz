<?
header("content-type: application/json");
$req = $_REQUEST;
$res = [];

function errorMessage($error) {
    $res_text = json_encode([
        "ok" => false,
        "error" => $error
    ]);

    apiLog($res_text);

    return exit(
        $res_text
    );
}

function getToken($token) {
    global $db;

    return $db->assoc("SELECT * FROM tokens WHERE token = ?", [
        $token
    ]);
}

function createToken($user_id, $callback = 0) {
    global $db, $env;

    if ($callback > 2) {
        exit("error!");
    }

    $token = bin2hex(openssl_random_pseudo_bytes("14")).uniqid();
    $tokenArr = getToken($token);

    if (!empty($tokenArr["token"])) {
        return createToken($user_id, $callback + 1);
    } else {
        $db->insert("tokens", [
            "user_id" => $user_id,
            "token" => $token,
            "ip" => $env->getIp(),
            "ip_via_proxy" => $env->getIpViaProxy(),
            "browser" => $env->getUserAgent()
        ]);

        $tokenArr = getToken($token);

        if ($tokenArr["token"]) {
            return $token;
        } else {
            return createToken($user_id, $callback + 1);
        }
    }
}

function validateForms($forms) {
    global $req;
    foreach ($forms as $form) {
        if (!isset($req[$form])) errorMessage("$form is empty");
    }
}

validateForms(["method"]);

// if (!$user_id || $user_id == 0) {
//     errorMessage("You are not authorized");
// }

function apiLog($res) {
    global $db, $user_id, $req, $env;

    $db->insert("api_requests", [
        "user_id" => $user_id,
        "req" => json_encode($req, JSON_UNESCAPED_UNICODE),
        "res" => $res,
        "ip" => $env->getIp()
    ]);
}

function bot($method, $callback_datas=[]){
    global $db;
    
    define("api_key", "5845308266:AAEGRSi1URzarAsp1iIpnw0lBo66Kqt0ksw");

    $url = "https://api.telegram.org/bot".api_key."/".$method;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $callback_datas);
    $res = curl_exec($ch);

    if (curl_error($ch)) {
        var_dump(curl_error($ch));
    } else {
        $res_arr = json_decode($res, true);
    }
}

switch ($req["method"]) {
    // addRequest 

    case "addRequest":

            $request_id = $db->insert("requests", [
                "creator_user_id" => $user_id,
                "first_name" => $req["first_name"],
                "phone" => $req["phone"],
                "message" => $req["message"]
            ]);
            
            if($request_id) {
                // foreach ([737322295, 166975358] as $admin_id) {
                //     bot("sendMessage", [
                //         "chat_id" => $admin_id,
                //         "text" => "$domain\n<b>Sayt orqali ro'yxatdan o'tildi!</b>\n\nIsm: <b>$req[first_name]</b>\nTelefon: <b>$req[phone]</b>\Izohingiz: <b>".$req["message"]."</b>",
                //         "parse_mode" => "html"
                //     ]);
                // }
                
                $res["ok"] = true;
            } else {
                $res["error"] = 'no inserted'; 
                $res["ok"] = false; 
            }

    break;

    // case "addRequest":
    //         validateForms([ "package_id", "first_name", "phone_1" ]);
            
    //         if(!$req['first_name'] || !$req['last_name']) {
    //             errorMessage("ismingizni yo'ki familyangizni kiritmadingiz");
    //         } else if(!$req["age"]) {
    //             errorMessage("Yoshingizni kiritmadingiz");
    //         } else if(mb_strlen($req['phone_1']) < 17) {
    //             errorMessage("Telefon raqam 17 ta raqamdan iborat bo'lishi shart");
    //         } else {
    //             $package = $db->assoc("SELECT * FROM `packages` WHERE id = ?", [ $req["package_id"] ]);
    
    //             $request_id = $db->insert("requests", [
    //                 "creator_user_id" => $user_id,
    //                 "package_id" => $package["id"],
    //                 "first_name" => $req["first_name"],
    //                 "last_name" => $req["last_name"],
    //                 "age" => $req["age"],
    //                 "sex" => $req["sex"],
    //                 "phone_1" => $req["phone_1"],
    //                 "phone_2" => $req["phone_2"] == '+998' ? null : $req["phone_2"],
    //             ]);

    //             if($request_id) {
    //                 foreach ([166975358] as $admin_id) {
    //                     bot("sendMessage", [
    //                         "chat_id" => $admin_id,
    //                         "text" => "$domain\n<b>Sayt orqali ariza qoldirishdi!</b>\n\nPaket nomi: <b>$package[name]</b>\nIsm: <b>$req[first_name]</b>\nFamiliya: <b>$req[last_name]</b>\nYoshi: <b>$req[age]</b>\nJinsi: <b>$req[sex]</b>\nTelefon: <b>$req[phone_1]</b>\nQo'shimcha telefon: <b>$req[phone_2]</b>",
    //                         "parse_mode" => "html"
    //                     ]);
    //                 }
                    
    //                 $res["ok"] = true;
    //             } else {
    //                 $res["error"] = 'no inserted'; 
    //                 $res["ok"] = false; 
    //             }
    //         }

    // break;
    
    case "room_books":
            // validateForms([ "courseId" ]);
            
            $beenBooking = $db->assoc("SELECT * FROM room_books WHERE room_id = ? AND first_name = ? AND last_name = ? AND father_first_name = ? AND chackin = ?", [ 
                $req["roomId"], $req["first_name"], $req["last_name"], $req["father_first_name"], $req["chackin"]
             ]);
            $room = $db->assoc("SELECT * FROM rooms WHERE id = ?", [ $req["roomId"] ]);

            if(!$beenBooking) {
                $roomBookId = $db->insert("room_books", [
                    "creator_user_id" => $user_id,
                    "room_id" => $req["roomId"],
                    "chackin" => $req["chackin"],
                    "chackout" => $req["chackout"],
                    "adu" => $req["adu"],
                    "child" => $req["child"] ? : null,
                    "first_name" => $req["first_name"],
                    "last_name" => $req["last_name"],
                    "father_first_name" => $req["father_first_name"],
                    "phone_1" => $req["phone_1"],
                    "phone_2" => $req["phone_2"],
                    "email" => $req["email"],
                ]);
                $xonaNomi = lng($room["name"]);
                
                if($roomBookId) {
                    foreach ([1121838673] as $admin_id) { // 6141103444
                        bot("sendMessage", [
                            "chat_id" => $admin_id,
                            "text" => "$domain\n<b> $xonaNomi shu xona uchun ariza qoldirishdi!</b>\nTelefon raqami: <b>$req[phone_1]</b>",
                            "parse_mode" => "html"
                        ]);
                    }
                    $res["ok"] = true;
                } else {
                    $res["error"] = 'no inserted'; 
                    $res["ok"] = false; 
                }
            } else {
                $res["error"] = 'no inserted'; 
                $res["ok"] = false; 
            }

    break;

    // case "addAgainCall":
    //         validateForms([ "phone" ]);
                
    //         if(mb_strlen($req['phone']) < 17) {
    //             errorMessage("Telefon raqam 17 ta raqamdan iborat bo'lishi shart");
    //         } else {
    //             $againCall_id = $db->insert("again_calls", [
    //                 "creator_user_id" => $user_id,
    //                 "phone" => $req["phone"],
    //             ]);
                
    //             if($againCall_id) {
    //                 foreach ([166975358] as $admin_id) {
    //                     bot("sendMessage", [
    //                         "chat_id" => $admin_id,
    //                         "text" => "$domain\n<b>Sayt orqali qayta qo'ng'iroq qilishga ariza qoldirishdi!</b>\nTelefon raqami: <b>$req[phone]</b>",
    //                         "parse_mode" => "html"
    //                     ]);
    //                 }
    //                 $res["ok"] = true;
                    
    //             } else {
    //                 $res["error"] = 'no inserted'; 
    //                 $res["ok"] = false; 
    //             }
    //         }

    // break;

    default:
        errorMessage("this method not found!");
}


if ($res) {
    $res_text = json_encode($res, JSON_UNESCAPED_UNICODE);
    apiLog($res_text);
    exit($res_text);
}
?>