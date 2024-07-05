<?php
include "getid3/getid3/getid3.php";

function uploadVideo($fileKey, $videoFolder, $allowedFileTypes, $required = true) {
    global $errors, $db, $user_id;

    $file = $_FILES[$fileKey];

    $res = [];
    $errorsArr = [];

    if ($file["size"] != 0){
        if (!file_exists($_SERVER["DOCUMENT_ROOT"]."/".$videoFolder)) {
            mkdir($_SERVER["DOCUMENT_ROOT"]."/".$videoFolder, 0777, true);
        }
    
        $file = $file;
        $random_name = date("Y-m-d-H-i-s").'_'.md5(time().rand(0, 10000000000000000));
        $file_type = basename($file["type"]);
        $file_folder = $videoFolder . "/" . $random_name . ".$file_type";
        $file_path = $_SERVER["DOCUMENT_ROOT"] . "/" . $file_folder;
        $uploadOk = 1;
        $file_type = strtolower(pathinfo($file_path, PATHINFO_EXTENSION));
    
        if (file_exists($file_path)) {
            array_push($errorsArr, "Kechirasiz, video allaqachon mavjud.");
            $uploadOk = 0;
        }
        if ($file["size"] > 5000000) {
            array_push($errorsArr, "Kechirasiz, sizning videoingiz juda katta.");
            $uploadOk = 0;
        }
        if (!in_array($file_type, $allowedFileTypes)) {
            array_push(
                $errorsArr,
                "Kechirasiz, faqat ".implode(" ", $allowedFileTypes)." videolarni yuklashga ruxsat berilgan."
            );
            $uploadOk = 0;
        }
        if ($uploadOk == 0) {
            array_push($errorsArr, "Kechirasiz, sizning videoingiz yuklanmadi.");
        } else {
            if (move_uploaded_file($file["tmp_name"], $file_path)) {
                $size = filesize($file_path);
                $getID3 = new getID3;
                $file_info = $getID3->analyze($file_path);
                $duration = $file_info["playtime_seconds"]; // video davomiylik vaqtini olish
                $width  =  $file_info["video"]["resolution_x"];  // video video razmerlarni olish bo'yi
                $height =  $file_info["video"]["resolution_y"];  // video video razmerlarni olish eni
    
                $video_id = $db->insert("videos", [
                    "creator_user_id" => $user_id,
                    "width" => $width,
                    "height" => $height,
                    "size" => $size,
                    "duration" => $duration,
                    "file_folder" => $file_folder
                ]);
    
                if ($video_id > 0) {
                    $res["video_id"] = $video_id;
                } else {
                    array_push(
                        $errorsArr,
                        "Videoni bazaga yozishda xatolik yuzaga keldi"
                    );
                    return;
                }
            } else {
                array_push($errorsArr, "Kechirasiz, videoingizni yuklashda xatolik yuz berdi.");
            }
        }
    } else {
        if ($required) array_push($errorsArr, "videoni tanlashni unutdingiz!");
    }

    if (count($errorsArr) > 0) $errors["forms"][$fileKey] = $errorsArr;
    return $res;
}

// if ($_FILES["video"]["size"] != 0){
//     $video = uploadVideo("video", "videos/sciences", ["mp4"], true);
//     header("Content-type: text/plain");
//     var_dump($video);
//     exit;
// }

function uploadVideoWithUpdate($fileKey, $videoFolder, $allowedFileTypes, $required = true, $video_id_for_change) {
    $uploadedVideo = uploadVideo($fileKey, $videoFolder, $allowedFileTypes, $required);

    $video_id = $video_id_for_change;
    $new_video_id = $uploadedVideo["video_id"];

    $res["video_id"] = $video_id_for_change;

    if ($new_video_id > 0) {
        delete_video($video_id);
        $video_id = $new_video_id;
        $res["video_id"] = $video_id;
    }

    return $res;
}
?>