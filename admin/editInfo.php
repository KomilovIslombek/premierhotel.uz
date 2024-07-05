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

$info = $db->assoc("SELECT * FROM info WHERE id = ?", [$id]);
if (!$info["id"]) {echo"error (info not found)";exit;}


if ($_REQUEST["type"] == $url[1]){
    validate(["name", "description", ]);

    include "modules/uploadImage.php";
    
    $uploadedInfoImage = uploadImageWithUpdate("image", "images/info", ["jpg","jpeg","png", "svg"], false, false, $info["image_id"]);

    if (!$errors["forms"] || count($errors["forms"]) == 0) {
        
        $info_id = $db->update("info", [
            "image_id" => $uploadedInfoImage["image_id"],
            "name" => json_encode($_POST["name"], JSON_UNESCAPED_UNICODE),
            "description" => json_encode($_POST["description"], JSON_UNESCAPED_UNICODE)
        ], [
            "id" => $info["id"]
        ]);

        header("Location: /admin/infoList/?page=" . $page);
        exit;
    } else {
        // header("Content-type: text/plain");
        // print_r($errors);
        // exit;
    }
}
if ($_REQUEST["type"] == "deleteinfo") {
    $db->delete("info", $info["id"], "id");

    if ($info["image_id"] > 0) {
        if ($info["image_id"] > 0) delete_image($info["image_id"]);
    }

    header("Location: /admin/infoList/?page=" . $page);
    exit;
}

include "head.php";

$breadcump_title_1 = "Qo'shimcha ma'lumotlar";
$breadcump_title_2 = "Ma'lumotni tahrirlash";
$form_title = "Ma'lumotni tahrirlash";
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
                                <input type="hidden" name="id" value="<?=$info["id"]?>">

                                <div class="form-row">
                                    <?
                                        if ($info["image_id"] > 0) {
                                            $image = image($info["image_id"]);
                                            echo '<image style="object-fit:cover;" src="'.$image["file_folder"].'" width="100px">';
                                        }
                                    ?>

                                    <?=getError("image")?>
                                    <div class="form-group col-12">
                                        <label for="formFile" class="form-label">Rasm yuklash (jpg, jpeg, png)</label>
                                        <input class="form-control" type="file" name="image" id="formFile" accept="image/*">
                                    </div>
                                    
                                    <? foreach ($db->in_array("SELECT * FROM langs_list") as $lang) { ?>
                                        <div class="form-group col-12" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <?=getError("name")?>
                                            <label>Nomi <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="name[<?=$lang["flag_icon"]?>]" value="<?=lng($info['name'], $lang["flag_icon"])?>" class="form-control" placeholder="Nomi" />
                                        </div>
                                        
                                        <div class="form-group col-12" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <?=getError("description")?>
                                            <label>Izohi <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="description[<?=$lang["flag_icon"]?>]" value="<?=lng($info['description'], $lang["flag_icon"])?>" class="form-control" placeholder="Izohi" />
                                        </div>
                                    <? } ?>
    
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

<?
include "end.php";
?>