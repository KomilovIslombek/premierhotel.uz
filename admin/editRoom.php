<?
$is_config = true;
if (empty($load_defined)) include 'load.php';

if (isAuth() === false) {
    header("Location: /login");
    exit;
} else if ($systemUser["role"] != "admin") {
    header("Location: /exit");
    exit;
}

$page = (int)$_REQUEST["page"];
if (empty($page)) $page = 1;

$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : null;
if (!$id) {echo"error id not found";return;}

$room = $db->assoc("SELECT * FROM rooms WHERE id = ?", [$id]);
if (!$room["id"]) {echo"error (room not found)";exit;}

$roomImages = json_decode($room["images_id"]);

if ($_REQUEST["type"] == $url[1]){
    validate(["name", "description", "price",]);
    
    $resImages = [];
    include "modules/uploadImage.php";
    
    foreach ($_FILES["images"]["name"] as $key => $value) {
        
        $uploadedImage = uploadImageMultiple("images/rooms", $_FILES["images"]["name"][$key], $_FILES["images"]["tmp_name"][$key], $_FILES["images"]["size"][$key], $_FILES["images"]["type"][$key],  ["jpg","jpeg","png"]);
        if($roomImages) {
            foreach ($roomImages as $image_id_for_change) {
                
                $image_id = $image_id_for_change;
                $new_image_id = $uploadedImage["image_id"];
    
                $res["image_id"] = $image_id_for_change;
    
                if ($new_image_id > 0) {
                    delete_image($image_id);
                    $image_id = $new_image_id;
                    $res["image_id"] = $image_id;
                }
                if(!in_array($res["image_id"], $resImages)) {
                    array_push($resImages, $res["image_id"]);
                }
            }
        } else{
            if(!in_array($uploadedImage["image_id"], $resImages)) {
                array_push($resImages, $uploadedImage["image_id"]);
            }
        }
    }

    if (!$errors["forms"] || count($errors["forms"]) == 0) {
        
        $db->update("rooms", [
            // "image_id" => $uploadedRoomImage["image_id"],
            "images_id" => $resImages ? json_encode($resImages, JSON_UNESCAPED_UNICODE) : null,
            "name" => json_encode($_POST["name"], JSON_UNESCAPED_UNICODE),
            "description" => json_encode($_POST["description"], JSON_UNESCAPED_UNICODE),
            "bedroom" => $_POST["bedroom"] ? $_POST["bedroom"] : null,
            "internet" => $_POST["internet"] ? $_POST["internet"] : null,
            "car" => $_POST["car"] ? $_POST["car"] : null,
            "coffe" => $_POST["coffe"] ? $_POST["coffe"] : null,
            "breakfast" => $_POST["breakfast"] ? $_POST["breakfast"] : null,
            "swim" => $_POST["swim"] ? $_POST["swim"] : null,
            "tv" => $_POST["tv"] ? $_POST["tv"] : null,
            "air" => $_POST["air"] ? $_POST["air"] : null,
            "heater" => $_POST["heater"] ? $_POST["heater"] : null,
            "phone" => $_POST["phone"] ? $_POST["phone"] : null,
            "laundry" => $_POST["laundry"] ? $_POST["laundry"] : null,
            "adults" => $_POST["adults"] ? $_POST["adults"] : null,
            "size" => $_POST["size"] ? $_POST["size"] : null,
            "bed" => $_POST["bed"] ? $_POST["bed"] : null,
            "price" => json_encode($_POST["price"], JSON_UNESCAPED_UNICODE),
            "services" => ($_POST["services"] ? json_encode($_POST["services"]) : NULL),
        ], [
            "id" => $room["id"]
        ]);

        header("Location: /admin/roomsList/?page=" . $page);
        exit;
    } else {
        // header("Content-type: text/plain");
        // print_r($errors);
        // exit;
    }
}
if ($_REQUEST["type"] == "deleteroom") {
    $db->delete("rooms", $room["id"], "id");

    $delRoomImages = json_decode($room["images_id"]);
    foreach ($delRoomImages as $delRoomImageId) {
        if ($delRoomImageId > 0) {
            if ($delRoomImageId > 0) delete_image($delRoomImageId);
        }
        
    }

    header("Location: /admin/roomsList/?page=" . $page);
    exit;
}

include "head.php";

$breadcump_title_1 = "Xonalar";
$breadcump_title_2 = "Xonani tahrirlash";
$form_title = "Xonani tahrirlash";
?>

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?=$breadcump_title_1?></a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)"><?=$breadcump_title_2?></a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" style="text-transform:none;"><?=$form_title?></h4>
                        <div>
                            <? foreach ($db->in_array("SELECT * FROM langs_list") as $lang) { ?>
                                <span select-form-lang="<?=$lang["flag_icon"]?>" style="cursor:pointer;font-size:30px;border:1px solid #f1f1f1;margin:15px 10px" class="flag-icon flag-icon-<?=$lang["flag_icon"]?>" id="form_lang_select"></span>
                            <? } ?>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="/admin/<?=$url[1]?>" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="type" value="<?=$url[1]?>">
                                <input type="hidden" name="page" value="<?=$page?>">
                                <input type="hidden" name="id" value="<?=$room["id"]?>">

                                <div class="form-row">
                                    
                                    <?
                                        if ($roomImages[0] > 0) {
                                            $image = image($roomImages[0]);
                                            echo '<image style="object-fit:cover;" src="'.$image["file_folder"].'" width="125px">';
                                        }
                                    ?>

                                    
                                    <?=getError("images")?>
                                    <div class="form-group col-12">
                                        <label for="formFile" class="form-label">Rasm yuklash (jpg, jpeg, png)</label>
                                        <input multiple class="form-control" type="file" name="images[]" id="formFile" accept="image/*">
                                    </div>
                                   
                                    <? foreach ($db->in_array("SELECT * FROM langs_list") as $lang) { ?>
                                        <div class="form-group col-12" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <?=getError("name")?>
                                            <label>Xona nomi <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="name[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($room['name'], $lang["flag_icon"])?>" placeholder="Xona nomi" />
                                        </div>

                                        <div class="form-group col-12" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <?=getError("description")?>
                                            <label>Xona izohi <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <textarea name="description[<?=$lang["flag_icon"]?>]" class="form-control" placeholder="Xona izoh" ><?=lng($room['description'], $lang["flag_icon"])?></textarea>
                                        </div>
                                        
                                        <div class="form-group col-12" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <?=getError("price")?>
                                            <label>Xona narxi <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input type="text" name="price[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($room["price"], $lang["flag_icon"])?>" placeholder="Xona narxi" id="price-input">
                                        </div>
                                    <? } ?>

                                    <!-- <div class="form-group col-12">
                                        <label>Paket haqida ma'lumot</span></label>
                                        <textarea cols="80" editor="" name="information" rows="6" class="form-control border-primary"></textarea>
                                    </div> -->
                                    <div class="form-group col-12">
                                        <div class="col-8 d-flex justify-content-between">
                                            <div class="form-check custom-checkbox mb-3 check-xs">
                                                <input name="bedroom" value="bedroom" <?=($room["bedroom"] ? 'checked=""' : '')?> type="checkbox" class="checkitem form-check-input" id="page_bedroom" >
                                                <label class="form-check-label mx-2" for="page_bedroom"><img style="width: 22px;" src="../theme/riorelax/img/icon/sve-icon1.png" alt="img"></label>
                                            </div>
                                            <div class="form-check custom-checkbox mb-3 check-xs">
                                                <input name="internet" <?=($room["internet"] ? 'checked=""' : '')?> value="internet" type="checkbox" class="checkitem form-check-input" id="page_internet" >
                                                <label class="form-check-label mx-2" for="page_internet"><img style="width: 20px;" src="../theme/riorelax/img/icon/sve-icon2.png" alt="img"></label>
                                            </div>
                                            <div class="form-check custom-checkbox mb-3 check-xs">
                                                <input name="car" value="car" <?=($room["car"] ? 'checked=""' : '')?> type="checkbox" class="checkitem form-check-input" id="page_car" >
                                                <label class="form-check-label mx-2" for="page_car"><img style="width: 20px;" src="../theme/riorelax/img/icon/sve-icon3.png" alt="img"></label>
                                            </div>
                                            <div class="form-check custom-checkbox mb-3 check-xs">
                                                <input name="coffe" value="coffe" <?=($room["coffe"] ? 'checked=""' : '')?> type="checkbox" class="checkitem form-check-input" id="page_coffe" >
                                                <label class="form-check-label mx-2" for="page_coffe"><img style="width: 20px;" src="../theme/riorelax/img/icon/sve-icon4.png" alt="img"></label>
                                            </div>
                                            <div class="form-check custom-checkbox mb-3 check-xs">
                                                <input name="breakfast" value="breakfast" <?=($room["breakfast"] ? 'checked=""' : '')?> type="checkbox" class="checkitem form-check-input" id="page_breakfast" >
                                                <label class="form-check-label mx-2" for="page_breakfast"><img style="width: 20px;" src="../theme/riorelax/img/icon/sve-icon5.png" alt="img"></label>
                                            </div>
                                            <div class="form-check custom-checkbox mb-3 check-xs">
                                                <input name="swim" value="swim" <?=($room["swim"] ? 'checked=""' : '')?> type="checkbox" class="checkitem form-check-input" id="page_swim" >
                                                <label class="form-check-label mx-2" for="page_swim"><img style="width: 20px;" src="../theme/riorelax/img/icon/sve-icon6.png" alt="img"></label>
                                            </div>
                                        </div>
                                        <div class="col-6 d-flex justify-content-between">
                                            <div class="form-check custom-checkbox mb-3 check-xs">
                                                <input name="tv" <?=($room["tv"] ? 'checked=""' : '')?> value="TV" type="checkbox" class="checkitem form-check-input" id="page_tv" >
                                                <label class="form-check-label mx-2" for="page_tv"><i style="color: #000000a8; font-size: 20px;" class="fal fa-tv-retro"></i></label>
                                            </div>
                                            <div class="form-check custom-checkbox mb-3 check-xs">
                                                <input name="air" <?=($room["air"] ? 'checked=""' : '')?> value="Air Condition" type="checkbox" class="checkitem form-check-input" id="page_air" >
                                                <label class="form-check-label mx-2" for="page_air"><i style="color: #000000a8; font-size: 20px;" class="fal fa-air-conditioner"></i></label>
                                            </div>
                                            <div class="form-check custom-checkbox mb-3 check-xs">
                                                <input name="heater" <?=($room["heater"] ? 'checked=""' : '')?> value="Heater" type="checkbox" class="checkitem form-check-input" id="page_heater" >
                                                <label class="form-check-label mx-2" for="page_heater"><i style="color: #000000a8; font-size: 20px;" class="fal fa-dumpster-fire"></i></label>
                                            </div>
                                            <div class="form-check custom-checkbox mb-3 check-xs">
                                                <input name="phone" <?=($room["phone"] ? 'checked=""' : '')?> value="Phone" type="checkbox" class="checkitem form-check-input" id="page_phone" >
                                                <label class="form-check-label mx-2" for="page_phone"><i style="color: #000000a8; font-size: 20px;" class="fal fa-phone-rotary"></i></label>
                                            </div>
                                            <div class="form-check custom-checkbox mb-3 check-xs">
                                                <input name="laundry" <?=($room["laundry"] ? 'checked=""' : '')?> value="Laundry" type="checkbox" class="checkitem form-check-input" id="page_laundry" >
                                                <label class="form-check-label mx-2" for="page_laundry"><i style="color: #000000a8; font-size: 20px;" class="fal fa-dryer-alt"></i></label>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <?=getError("adults")?>
                                    <div class="form-group col-12">
                                        <label>Kattalar soni </label>
                                        <input name="adults" type="number" class="form-control" value="<?=$room["adults"]?>" placeholder="Kattalar soni" />
                                    </div>
                                    
                                    <?=getError("size")?>
                                    <div class="form-group col-12">
                                        <label>Xona xajmi (24m<sup>2</sup>)</label>
                                        <input name="size" class="form-control" value="<?=$room["size"]?>" placeholder="Xona xajmi" />
                                    </div>
                                    
                                    <?=getError("bed")?>
                                    <div class="form-group col-12">
                                        <label>Yotoqlar soni</label>
                                        <input name="bed" type="number" class="form-control" value="<?=$room["bed"]?>" placeholder="Yotoqlar soni" />
                                    </div>

                                    <div class="table-responsive col-12">
                                        <table class="table table-hover table-bordered table-responsive-md">
                                            <tbody>
                                                <tr class="bg-dark text-white">
                                                    <th><label class="form-check-label" for="checkAll2">Hamasini belgilash</label></th>
                                                    <td><input type="checkbox" class="form-check-input" id="checkAll2"></td>
                                                </tr>
                                                <? foreach($db->in_array("SELECT * FROM services") as $service) { ?>
                                                <tr>
                                                    <th><label class="form-check-label" for="id_<?=$service["id"]?>"><?=admin_lng($service["name"])?></label></th>
                                                    <td>
                                                        <div class="col">
                                                            <div class="form-check custom-checkbox mb-3 check-xs">
                                                                <? if ($room["services"] && in_array($service["id"], json_decode($room["services"]))) { ?>
                                                                    <input name="services[]" value="<?=$service["id"]?>" type="checkbox" class="mineitem checkitem form-check-input" id="id_<?=$service["id"]?>" checked="">
                                                                <? } else { ?>
                                                                    <input name="services[]" value="<?=$service["id"]?>" type="checkbox" class="mineitem checkitem form-check-input" id="id_<?=$service["id"]?>">
                                                                <? } ?>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <? } ?>
                                            </tbody>
                                        </table>
                                    </div>
    
                                </div>
                                <div class="toolbar toolbar-bottom" role="toolbar" style="text-align: right;">
                                    <button type="submit" class="btn btn-primary">Saqlash</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--**********************************
    Content body end
***********************************-->

<?
include "scripts.php";
?>

<script>
    $("#price-input").on("input", function(){
        var val = $(this).val().replaceAll(",", "").replaceAll(" ", "");
        console.log(val);

        if (val.length > 0) {    
            $(this).val(
                String(val).replace(/(.)(?=(\d{3})+$)/g,'$1,')
            );
        }
    });
</script>

<?
include "end.php";
?>