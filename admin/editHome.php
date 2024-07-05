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

$home = $db->assoc("SELECT * FROM home WHERE id = ?", [$id]);
if (!$home["id"]) {echo"error (home not found)";exit;}


if ($_REQUEST["type"] == $url[1]){

    include "modules/uploadImage.php";

    $uploadedBanerImage = uploadImageWithUpdate("image", "images/home", ["jpg","jpeg","png"], false, false, $home["image_id"]);
    $uploadedBanerImage2 = uploadImageWithUpdate("image2", "images/home", ["jpg","jpeg","png"], false, false, $home["image_id2"]);
    $uploadedBanerImage3 = uploadImageWithUpdate("image3", "images/home", ["jpg","jpeg","png"], false, false, $home["image_id3"]);
    $uploadedBanerImage4 = uploadImageWithUpdate("image4", "images/home", ["jpg","jpeg","png"], false, false, $home["image_id4"]);

    if (!$errors["forms"] || count($errors["forms"]) == 0) {
        
        $home_id = $db->update("home", [
            "image_id" => $uploadedBanerImage["image_id"],
            "image_id2" => $uploadedBanerImage2["image_id"],
            "image_id3" => $uploadedBanerImage3["image_id"],
            "image_id4" => $uploadedBanerImage4["image_id"],
            "text_1" => $_POST["text_1"] == '' ? null : $_POST["text_1"],
            "text_2" => $_POST["text_2"] == '' ? null : json_encode($_POST["text_2"], JSON_UNESCAPED_UNICODE),
            "text_3" => $_POST["text_3"] == '' ? null : json_encode($_POST["text_3"], JSON_UNESCAPED_UNICODE),
            "text_4" => $_POST["text_4"] == '' ? null : json_encode($_POST["text_4"], JSON_UNESCAPED_UNICODE),
            "text_5" => $_POST["text_5"] == '' ? null : json_encode($_POST["text_5"], JSON_UNESCAPED_UNICODE),
            "text_6" => $_POST["text_6"] == '' ? null : json_encode($_POST["text_6"], JSON_UNESCAPED_UNICODE),
            "text_7" => $_POST["text_7"] == '' ? null : json_encode($_POST["text_7"], JSON_UNESCAPED_UNICODE),
            "text_8" => $_POST["text_8"] == '' ? null : json_encode($_POST["text_8"], JSON_UNESCAPED_UNICODE),
            "text_9" => $_POST["text_9"] == '' ? null : json_encode($_POST["text_9"], JSON_UNESCAPED_UNICODE),
            "text_10" => $_POST["text_10"] == '' ? null : json_encode($_POST["text_10"], JSON_UNESCAPED_UNICODE),
            "text_11" => $_POST["text_11"] == '' ? null : json_encode($_POST["text_11"], JSON_UNESCAPED_UNICODE),
            "text_12" => $_POST["text_12"] == '' ? null : json_encode($_POST["text_12"], JSON_UNESCAPED_UNICODE),
            "text_13" => $_POST["text_13"] == '' ? null : json_encode($_POST["text_13"], JSON_UNESCAPED_UNICODE),
            "text_14" => $_POST["text_14"] == '' ? null : json_encode($_POST["text_14"], JSON_UNESCAPED_UNICODE),
            "text_15" => $_POST["text_15"] == '' ? null : json_encode($_POST["text_15"], JSON_UNESCAPED_UNICODE),
            "text_16" => $_POST["text_16"] == '' ? null : json_encode($_POST["text_16"], JSON_UNESCAPED_UNICODE),
            "text_17" => $_POST["text_17"] == '' ? null : json_encode($_POST["text_17"], JSON_UNESCAPED_UNICODE),
            "text_18" => $_POST["text_18"] == '' ? null : json_encode($_POST["text_18"], JSON_UNESCAPED_UNICODE),
            "text_19" => $_POST["text_19"] == '' ? null : json_encode($_POST["text_19"], JSON_UNESCAPED_UNICODE),
            "text_20" => $_POST["text_20"] == '' ? null : json_encode($_POST["text_20"], JSON_UNESCAPED_UNICODE),
            "text_21" => $_POST["text_21"] == '' ? null : json_encode($_POST["text_21"], JSON_UNESCAPED_UNICODE),
            "text_22" => $_POST["text_22"] == '' ? null : json_encode($_POST["text_22"], JSON_UNESCAPED_UNICODE),
            "text_23" => $_POST["text_23"] == '' ? null : json_encode($_POST["text_23"], JSON_UNESCAPED_UNICODE),
            "text_24" => $_POST["text_24"] == '' ? null : json_encode($_POST["text_24"], JSON_UNESCAPED_UNICODE),
            "text_25" => $_POST["text_25"] == '' ? null : json_encode($_POST["text_25"], JSON_UNESCAPED_UNICODE),
            "text_26" => $_POST["text_26"] == '' ? null : json_encode($_POST["text_26"], JSON_UNESCAPED_UNICODE),
            "text_27" => $_POST["text_27"] == '' ? null : json_encode($_POST["text_27"], JSON_UNESCAPED_UNICODE),
            "text_28" => $_POST["text_28"] == '' ? null : json_encode($_POST["text_28"], JSON_UNESCAPED_UNICODE),
            "text_29" => $_POST["text_29"] == '' ? null : json_encode($_POST["text_29"], JSON_UNESCAPED_UNICODE),
            "text_30" => $_POST["text_30"] == '' ? null : json_encode($_POST["text_30"], JSON_UNESCAPED_UNICODE),
            "text_31" => $_POST["text_31"] == '' ? null : json_encode($_POST["text_31"], JSON_UNESCAPED_UNICODE),
            "text_32" => $_POST["text_32"] == '' ? null : json_encode($_POST["text_32"], JSON_UNESCAPED_UNICODE),
            "text_33" => $_POST["text_33"] == '' ? null : $_POST["text_33"],
            "text_34" => $_POST["text_34"] == '' ? null : $_POST["text_34"],
            "text_35" => $_POST["text_35"] == '' ? null : $_POST["text_35"],
            "text_36" => $_POST["text_36"] == '' ? null : $_POST["text_36"],
            "text_37" => $_POST["text_37"] == '' ? null : json_encode($_POST["text_37"], JSON_UNESCAPED_UNICODE),
            "text_38" => $_POST["text_38"] == '' ? null : json_encode($_POST["text_38"], JSON_UNESCAPED_UNICODE),
            "text_39" => $_POST["text_39"] == '' ? null : json_encode($_POST["text_39"], JSON_UNESCAPED_UNICODE),
            "text_40" => $_POST["text_40"] == '' ? null : $_POST["text_40"],
            "text_41" => $_POST["text_41"] == '' ? null : $_POST["text_41"],
            "text_42" => $_POST["text_42"] == '' ? null : $_POST["text_42"],
            "text_43" => $_POST["text_43"] == '' ? null : $_POST["text_43"],
            "text_44" => $_POST["text_44"] == '' ? null : json_encode($_POST["text_44"], JSON_UNESCAPED_UNICODE),
            "text_45" => $_POST["text_45"] == '' ? null : $_POST["text_45"],
            "text_46" => $_POST["text_46"] == '' ? null : $_POST["text_46"],
            "text_47" => $_POST["text_47"] == '' ? null : $_POST["text_47"],
            "text_48" => $_POST["text_48"] == '' ? null : $_POST["text_48"],
            "text_49" => $_POST["text_49"] == '' ? null : $_POST["text_49"],
            "text_50" => $_POST["text_50"] == '' ? null : $_POST["text_50"],
            "text_51" => $_POST["text_51"] == '' ? null : json_encode($_POST["text_51"], JSON_UNESCAPED_UNICODE),
            "text_52" => $_POST["text_52"] == '' ? null : json_encode($_POST["text_52"], JSON_UNESCAPED_UNICODE),
            "text_53" => $_POST["text_53"] == '' ? null : json_encode($_POST["text_53"], JSON_UNESCAPED_UNICODE),
            "text_54" => $_POST["text_54"] == '' ? null : json_encode($_POST["text_54"], JSON_UNESCAPED_UNICODE),
        ], [
            "id" => $home["id"]
        ]);

        header("Location: /admin/editHome/?id=" . $id);
        exit;
    } else {
        // header("Content-type: text/plain");
        // print_r($errors);
        // exit;
    }
}
// if ($_REQUEST["type"] == "deletehome") {
//     $db->delete("home", $home["id"], "id");


//     if ($home["image_id"] > 0) delete_image($home["image_id"]);

//     header("Location: /admin/homeList/?page=" . $page);
//     exit;
// }

include "head.php";

$breadcump_title_1 = "Bosh sahifa";
$breadcump_title_2 = "Bosh sahifani tahrirlash";
$form_title = "Bosh sahifani tahrirlash";
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
                                <input type="hidden" name="id" value="<?=$home["id"]?>">
                                <input type="hidden" name="type" value="<?=$url[1]?>">

                                <div class="form-row">
                                    <?=getError("text_1")?>
                                    <div class="form-group col-6">
                                        <label>Tepadagi raqam</span></label>
                                        <textarea name="text_1" class="form-control" placeholder="Tepadagi raqam"><?=$home["text_1"]?></textarea>
                                    </div>
                                    
                                    <? foreach ($db->in_array("SELECT * FROM langs_list") as $lang) { ?>
                                        <div class="form-group col-6" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <?=getError("text_2")?>
                                            <label>Navbar knopkasi matni <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="text_2[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($home["text_2"], $lang["flag_icon"])?>" placeholder="Navbar knopkasi matni" />
                                        </div>

                                        <div class="form-group col-6" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <?=getError("text_3")?>
                                            <label>Banner knopka matni <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="text_3[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($home["text_3"], $lang["flag_icon"])?>" placeholder="Banner 1 knopka matni" />
                                        </div>

                                        <div class="form-group col-6" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <?=getError("text_4")?>
                                            <label>Banner video knopka matni <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="text_4[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($home["text_4"], $lang["flag_icon"])?>" placeholder="Banner video knopka matni" />
                                        </div>
                                    <? } ?>
                                    <div class="bg-primary text-white border-bottom col-12 ms-2 mb-3">Etap 2 Bannerda ustida turgan buyurtma berish</div>
                                    
                                    <? foreach ($db->in_array("SELECT * FROM langs_list") as $lang) { ?>
                                        <div class="form-group col-6" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <?=getError("text_5")?>
                                            <label>Buyurtma berish 1 chi matni <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="text_5[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($home["text_5"], $lang["flag_icon"])?>" placeholder="Buyurtma berish 1 chi matni" />
                                        </div>

                                        <?=getError("text_6")?>
                                        <div class="form-group col-6" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>2 chi matni <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="text_6[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($home["text_6"], $lang["flag_icon"])?>" placeholder="2 chi matni" />
                                        </div>
                                        
                                        <?=getError("text_7")?>
                                        <div class="form-group col-6" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>3 chi matni <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="text_7[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($home["text_7"], $lang["flag_icon"])?>" placeholder="3 chi matni" />
                                        </div>

                                        <?=getError("text_8")?>
                                        <div class="form-group col-6" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>4 chi matni <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="text_8[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($home["text_8"], $lang["flag_icon"])?>" placeholder="4 chi matni" />
                                        </div>

                                        <?=getError("text_9")?>
                                        <div class="form-group col-12" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>5 chi matni <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="text_9[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($home["text_9"], $lang["flag_icon"])?>" placeholder="5 chi matni" />
                                        </div>
                                    <? } ?>
                                    <div class="bg-primary text-white border-bottom col-12 ms-2 mb-3">Etap 3 Biz haqimizda</div>
                                    

                                    <?
                                        if ($home["image_id"] > 0) {
                                            $image = image($home["image_id"]);
                                            echo '<image style="object-fit:cover;" src="'.$image["file_folder"].'" width="125px">';
                                        }
                                    ?>

                                    <?=getError("image")?>
                                    <div class="form-group col-12">
                                        <label for="formFile" class="form-label">Biz haqimizda 1 banner (jpg, jpeg, png)</label>
                                        <input class="form-control" type="file" name="image" id="formFile" accept="image/*">
                                    </div>
                                    
                                    <?
                                        if ($home["image_id2"] > 0) {
                                            $image = image($home["image_id2"]);
                                            echo '<image style="object-fit:cover;" src="'.$image["file_folder"].'" width="125px">';
                                        }
                                    ?>

                                    <?=getError("image2")?>
                                    <div class="form-group col-12">
                                        <label for="formFile" class="form-label">Biz haqimizda 2 banner (jpg, jpeg, png)</label>
                                        <input class="form-control" type="file" name="image2" id="formFile" accept="image/*">
                                    </div>
                                    
                                    <? foreach ($db->in_array("SELECT * FROM langs_list") as $lang) { ?>
                                        <div class="form-group col-6" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <?=getError("text_10")?>
                                            <label>kichik sarlavha <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="text_10[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($home["text_10"], $lang["flag_icon"])?>" placeholder="kichik sarlavha" />
                                        </div>
                                        
                                        <?=getError("text_11")?>
                                        <div class="form-group col-6" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>Asosiy sarlavha <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="text_11[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($home["text_11"], $lang["flag_icon"])?>" placeholder="Asosiy sarlavha" />
                                        </div>

                                        <?=getError("text_12")?>
                                        <div class="form-group col-12" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>Biz haqimizda izoh 1 <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <textarea name="text_12[<?=$lang["flag_icon"]?>]" class="form-control border-primary"><?=lng($home["text_12"], $lang["flag_icon"])?></textarea>
                                        </div>
                                        
                                        <?=getError("text_13")?>
                                        <div class="form-group col-12" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>Biz haqimizda izoh 2 <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <textarea name="text_13[<?=$lang["flag_icon"]?>]" class="form-control border-primary"><?=lng($home["text_13"], $lang["flag_icon"])?></textarea>
                                        </div>

                                        <?=getError("text_14")?>
                                        <div class="form-group col-12" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>Biz haqimizda qulaylik 1 <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="text_14[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($home["text_14"], $lang["flag_icon"])?>" placeholder="qulaylik 1"/>
                                        </div>
                                        
                                        <?=getError("text_15")?>
                                        <div class="form-group col-12" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>Biz haqimizda qulaylik 2 <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="text_15[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($home["text_15"], $lang["flag_icon"])?>" placeholder="qulaylik 1"/>
                                        </div>

                                        <?=getError("text_16")?>
                                        <div class="form-group col-12" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>Biz haqimizda qulaylik 3 <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="text_16[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($home["text_16"], $lang["flag_icon"])?>" placeholder="qulaylik 1"/>
                                        </div>

                                        <?=getError("text_17")?>
                                        <div class="form-group col-12" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>knopka matni <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="text_17[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($home["text_17"], $lang["flag_icon"])?>" placeholder="knopka matni"/>
                                        </div>

                                        <?=getError("text_51")?>
                                        <div class="form-group col-12" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>Site kalit so'zlari (mehmonxona, ...)<span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <textarea name="text_51[<?=$lang["flag_icon"]?>]" class="form-control border-primary"><?=lng($home["text_51"], $lang["flag_icon"])?></textarea>
                                        </div>
                                        
                                        <?=getError("text_52")?>
                                        <div class="form-group col-12" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>Site tavsifi <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <textarea name="text_52[<?=$lang["flag_icon"]?>]" class="form-control border-primary"><?=lng($home["text_52"], $lang["flag_icon"])?></textarea>
                                        </div>

                                    <? } ?>
                                    <div class="bg-primary text-white border-bottom col-12 ms-2 mb-3">Etap 4 Afzalliklarimiz</div>

                                    <? foreach ($db->in_array("SELECT * FROM langs_list") as $lang) { ?>
                                        <?=getError("text_18")?>
                                        <div class="form-group col-6" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>Kichik sarlavha <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="text_18[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($home["text_18"], $lang["flag_icon"])?>" placeholder="Kichik sarlavha" />
                                        </div>
                                        
                                        <?=getError("text_19")?>
                                        <div class="form-group col-6" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>Asosiy sarlavha <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="text_19[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($home["text_19"], $lang["flag_icon"])?>" placeholder="Asosiy sarlavha" />
                                        </div>
                                        
                                        <?=getError("text_20")?>
                                        <div class="form-group col-12" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>Izoh <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <textarea name="text_20[<?=$lang["flag_icon"]?>]" class="form-control" placeholder="Izoh"><?=lng($home["text_20"], $lang["flag_icon"])?></textarea>
                                        </div>
                                        
                                        <?=getError("text_53")?>
                                        <div class="form-group col-12" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>Mehmonxona haqida ma'lumot sarlavhasi <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <textarea name="text_53[<?=$lang["flag_icon"]?>]" class="form-control" placeholder="Mehmonxona haqida ma'lumot sarlavhasi"><?=lng($home["text_53"], $lang["flag_icon"])?></textarea>
                                        </div>
                                        
                                        <?=getError("text_54")?>
                                        <div class="form-group col-12" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>Mehmonxona xususiyatlari sarlavhasi <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <textarea name="text_54[<?=$lang["flag_icon"]?>]" class="form-control" placeholder="Mehmonxona xususiyatlari sarlavhasi"><?=lng($home["text_54"], $lang["flag_icon"])?></textarea>
                                        </div>
                                    <? } ?>

                                    <div class="bg-primary text-white border-bottom col-12 ms-2 mb-3">Etap 5 XONA TURLARIMIZ</div>

                                    <? foreach ($db->in_array("SELECT * FROM langs_list") as $lang) { ?>
                                        <?=getError("text_21")?>
                                        <div class="form-group col-6" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>Kichik sarlavha <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="text_21[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($home["text_21"], $lang["flag_icon"])?>" placeholder="Kichik sarlavha" />
                                        </div>
                                        
                                        <?=getError("text_22")?>
                                        <div class="form-group col-6" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>Asosiy sarlavha <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="text_22[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($home["text_22"], $lang["flag_icon"])?>" placeholder="Asosiy sarlavha" />
                                        </div>
                                        
                                        <?=getError("text_23")?>
                                        <div class="form-group col-12" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>Izoh <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <textarea name="text_23[<?=$lang["flag_icon"]?>]" class="form-control" placeholder="Izoh"><?=lng($home["text_23"], $lang["flag_icon"])?></textarea>
                                        </div>
                                    <? } ?>

                                    <div class="bg-primary text-white border-bottom col-12 ms-2 mb-3">Etap 6 MEHMONXONA XIZMATLARINI TAQQOSLASH</div>

                                    <? foreach ($db->in_array("SELECT * FROM langs_list") as $lang) { ?>
                                        <?=getError("text_24")?>
                                        <div class="form-group col-6" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>Asosiy sarlavha <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="text_24[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($home["text_24"], $lang["flag_icon"])?>" placeholder="Asosiy sarlavha" />
                                        </div>

                                        <?=getError("text_25")?>
                                        <div class="form-group col-6" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>№ - shundan keyingi matn <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="text_25[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($home["text_25"], $lang["flag_icon"])?>" placeholder="Kichik sarlavha" />
                                        </div>
                                    <? } ?>

                                    <div class="bg-primary text-white border-bottom col-12 ms-2 mb-3">Etap 7 BIZ BILAN BOG'LANING.</div>

                                    <? foreach ($db->in_array("SELECT * FROM langs_list") as $lang) { ?>
                                        <?=getError("text_26")?>
                                        <div class="form-group col-6" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>Asosiy sarlavha <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="text_26[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($home["text_26"], $lang["flag_icon"])?>" placeholder="Asosiy sarlavha" />
                                        </div>

                                        <?=getError("text_27")?>
                                        <div class="form-group col-6" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>Kichik sarlavha <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <textarea name="text_27[<?=$lang["flag_icon"]?>]" class="form-control" placeholder="Kichik sarlavha" ><?=lng($home["text_27"], $lang["flag_icon"])?></textarea>
                                        </div>
                                        
                                        <?=getError("text_28")?>
                                        <div class="form-group col-6" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>Knopka matni <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="text_28[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($home["text_28"], $lang["flag_icon"])?>" placeholder="Knopka matni" />
                                        </div>
                                    <? } ?>

                                    <div class="bg-primary text-white border-bottom col-12 ms-2 mb-3">Etap 8 XONA BRON QILISH.</div>
                                    
                                    <? foreach ($db->in_array("SELECT * FROM langs_list") as $lang) { ?>
                                        <?=getError("text_29")?>
                                        <div class="form-group col-6" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>Kichik sarlavha <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <textarea name="text_29[<?=$lang["flag_icon"]?>]" class="form-control" placeholder="Kichik sarlavha" ><?=lng($home["text_29"], $lang["flag_icon"])?></textarea>
                                        </div>

                                        <?=getError("text_30")?>
                                        <div class="form-group col-6" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>Asosiy sarlavha <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="text_30[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($home["text_30"], $lang["flag_icon"])?>" placeholder="Asosiy sarlavha" />
                                        </div>

                                    <? } ?>
                                    <?
                                        if ($home["image_id3"] > 0) {
                                            $image = image($home["image_id3"]);
                                            echo '<image style="object-fit:cover;" src="'.$image["file_folder"].'" width="125px">';
                                        }
                                    ?>

                                    <?=getError("image3")?>
                                    <div class="form-group col-12">
                                        <label for="formFile" class="form-label">Xona bron qilish rasmini yuklash (jpg, jpeg, png)</label>
                                        <input class="form-control" type="file" name="image3" id="formFile" accept="image/*">
                                    </div>

                                    <div class="bg-primary text-white border-bottom col-12 ms-2 mb-3">Etap 9  Odamlar sig'imi, Vokzal va masjidgacha bo'lgan masofa.</div>
                                    
                                    <? foreach ($db->in_array("SELECT * FROM langs_list") as $lang) { ?>
                                        <?=getError("text_31")?>
                                        <div class="form-group col-6" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>Chap rasmdagi sarlavha <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="text_31[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($home["text_31"], $lang["flag_icon"])?>" placeholder="Chap rasmdagi sarlavha" />
                                        </div>
                                        
                                        <?=getError("text_32")?>
                                        <div class="form-group col-6" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>Ong tomondagi sarlavha <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="text_32[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($home["text_32"], $lang["flag_icon"])?>" placeholder="Ong tomondagi sarlavha" />
                                        </div>
                                    <? } ?>

                                    <?=getError("text_33")?>
                                    <div class="form-group col-6">
                                        <label>Xonalar soni</span></label>
                                        <input name="text_33" type="number" value="<?=$home["text_33"]?>" class="form-control" placeholder="Xonalar soni" />
                                    </div>

                                    <?=getError("text_34")?>
                                    <div class="form-group col-6">
                                        <label>Umumiy odamlar soni</label>
                                        <input name="text_34" type="number" class="form-control" value="<?=$home["text_34"]?>" placeholder="Umumiy odamlar soni" />
                                    </div>
                                    
                                    <?=getError("text_35")?>
                                    <div class="form-group col-6">
                                        <label>Mehmonxonadan vokzalgacha bo'lgan masofa</label>
                                        <input name="text_35" type="number" value="<?=$home["text_35"]?>" class="form-control" placeholder="Mehmonxonadan vokzalgacha bo'lgan masofa" />
                                    </div>

                                    <?=getError("text_36")?>
                                    <div class="form-group col-6">
                                        <label>Mehmonxonadan masjidagacha bo'lgan masofa</label>
                                        <input name="text_36" type="number" class="form-control" value="<?=$home["text_36"]?>" placeholder="Mehmonxonadan masjidagacha bo'lgan masofa" />
                                    </div>

                                    <div class="bg-primary text-white border-bottom col-12 ms-2 mb-3">Etap 10 Sitdi eng past qismi .</div>
                                    <? foreach ($db->in_array("SELECT * FROM langs_list") as $lang) { ?>
                                        <?=getError("text_37")?>
                                        <div class="form-group col-6" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>Ortadagi sarlavha <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="text_37[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($home["text_37"], $lang["flag_icon"])?>" placeholder="Ortadagi sarlavha" />
                                        </div>
                                        
                                        <?=getError("text_38")?>
                                        <div class="form-group col-6" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>Ong tomondagi sarlavha <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="text_38[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($home["text_38"], $lang["flag_icon"])?>" placeholder="Ong tomondagi sarlavha" />
                                        </div>
                                        
                                        <?=getError("text_39")?>
                                        <div class="form-group col-6" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>Ong tomondi pasidagi sarlavha <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="text_39[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($home["text_39"], $lang["flag_icon"])?>" placeholder="Ong tomondagi sarlavha" />
                                        </div>
                                    <? } ?>

                                    <?=getError("text_40")?>
                                    <div class="form-group col-6">
                                        <label>Menejer raqami</span></label>
                                        <input name="text_40" class="form-control" value="<?=$home["text_40"]?>" placeholder="Menejer raqami" id="phone-mask2"/>
                                    </div>
                                    
                                    <?=getError("text_41")?>
                                    <div class="form-group col-6">
                                        <label>Qo'shimcha telefon raqami</span></label>
                                        <input name="text_41" class="form-control" value="<?=$home["text_41"]?>" placeholder="Qo'shimcha telefon raqami" id="phone-mask3"/>
                                    </div>
                                    
                                    <?=getError("text_45")?>
                                    <div class="form-group col-6">
                                        <label>Qo'shimcha telefon raqami 2</span></label>
                                        <input name="text_45" class="form-control" value="<?=$home["text_45"]?>" placeholder="Qo'shimcha telefon raqami 2" id="phone-mask4"/>
                                    </div>

                                    <?=getError("text_42")?>
                                    <div class="form-group col-6">
                                        <label>Email pochta</label>
                                        <input name="text_42" class="form-control" value="<?=$home["text_42"]?>" placeholder="Email pochta" />
                                    </div>
                                    
                                    <?=getError("text_43")?>
                                    <div class="form-group col-6">
                                        <label>Qo'shimcha email pochta</label>
                                        <input name="text_43" class="form-control" value="<?=$home["text_43"]?>" placeholder="Qo'shimcha email pochta" id="phone-musk4"/>
                                    </div>
                                    
                                    <? foreach ($db->in_array("SELECT * FROM langs_list") as $lang) { ?>
                                        <?=getError("text_44")?>
                                        <div class="form-group col-6" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <label>Manzil <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <textarea name="text_44[<?=$lang["flag_icon"]?>]" class="form-control" placeholder="Manzil" ><?=lng($home["text_44"], $lang["flag_icon"])?></textarea>
                                        </div>
                                    <? } ?>
                                    

                                    <?
                                        if ($home["image_id4"] > 0) {
                                            $image = image($home["image_id4"]);
                                            echo '<image style="object-fit:cover;" src="'.$image["file_folder"].'" width="125px">';
                                        }
                                    ?>

                                    <?=getError("image4")?>
                                    <div class="form-group col-12">
                                        <label for="formFile" class="form-label">Xona sahifasidagi bannerni yuklash (jpg, jpeg, png)</label>
                                        <input class="form-control" type="file" name="image4" id="formFile" accept="image/*">
                                    </div>

                                    <?=getError("text_46")?>
                                    <div class="form-group col-6">
                                        <label><i style="color: #1d9bf0;" class="fa-brands fa-twitter"></i> 1. link twitter</span></label>
                                        <input name="text_46" class="form-control" value="<?=$home['text_46']?>" placeholder="link twitter" />
                                    </div>
                                    
                                    <?=getError("text_47")?>
                                    <div class="form-group col-6">
                                        <label><i style="color: #f7715f;" class="fa-brands fa-instagram"></i> 2. link instagram</span></label>
                                        <input name="text_47" class="form-control" value="<?=$home['text_47']?>" placeholder="link instagram" />
                                    </div>
                                    
                                    <?=getError("text_48")?>
                                    <div class="form-group col-6">
                                        <label><i style="color: #4867aa;" class="fa-brands fa-facebook"></i> 3. link facebook</span></label>
                                        <input name="text_48" class="form-control" value="<?=$home['text_48']?>" placeholder="link facebook" />
                                    </div>
                                    
                                    <?=getError("text_49")?>
                                    <div class="form-group col-6">
                                        <label><i style="color: #f7715f;" class="fa-brands fa-youtube"></i> 4. link youtube</span></label>
                                        <input name="text_49" class="form-control" value="<?=$home['text_49']?>" placeholder="link youtube" />
                                    </div>
                                    
                                    <?=getError("text_50")?>
                                    <div class="form-group col-6">
                                        <label><i style="color: #f7715f;" class="fa-brands fa-telegram"></i> 4. link telegram</span></label>
                                        <input name="text_50" class="form-control" value="<?=$home['text_50']?>" placeholder="link telegram" />
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
    $("#phone-mask").on("input keyup", function(e){
        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,2})(\d{0,3})(\d{0,2})(\d{0,2})/);
        // console.log(x);
        e.target.value = !x[2] ? '+' + (x[1].length == 3 ? x[1] : '998') : '+' + x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '') + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '');
    });

    $("#phone-mask").keyup();
   
    $("#phone-mask2").on("input keyup", function(e){
        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,2})(\d{0,3})(\d{0,2})(\d{0,2})/);
        // console.log(x);
        e.target.value = !x[2] ? '+' + (x[1].length == 3 ? x[1] : '998') : '+' + x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '') + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '');
    });

    $("#phone-mask2").keyup();
  
    $("#phone-mask3").on("input keyup", function(e){
        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,2})(\d{0,3})(\d{0,2})(\d{0,2})/);
        // console.log(x);
        e.target.value = !x[2] ? '+' + (x[1].length == 3 ? x[1] : '998') : '+' + x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '') + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '');
    });

    $("#phone-mask3").keyup();
    
    $("#phone-mask4").on("input keyup", function(e){
        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,2})(\d{0,3})(\d{0,2})(\d{0,2})/);
        // console.log(x);
        e.target.value = !x[2] ? '+' + (x[1].length == 3 ? x[1] : '998') : '+' + x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '') + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '');
    });

</script>

<?
include "end.php";
?>