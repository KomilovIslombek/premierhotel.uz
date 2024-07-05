<?php
function bot($method, $callback_datas=[]){
    define("key", "5534397905:AAGKWPQVE0LMMBG8OA9SZjEBn8HCSYMTRqE");
    $url = "https://api.telegram.org/bot".key."/".$method;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $callback_datas);
    $res = curl_exec($ch);

    if (curl_error($ch)) {
      var_dump(curl_error($ch));
    } else {
      $res_arr = json_decode($res, true);
      return $res_arr;
    }
}

function sendMessage($message) {
    bot("sendMessage", [
        "chat_id" => -1001635762912,
        "text" => $message,
        "parse_mode" => "html"
    ]);
}
?>