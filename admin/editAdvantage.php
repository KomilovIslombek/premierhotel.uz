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

$advantage = $db->assoc("SELECT * FROM advantages WHERE id = ?", [$id]);
if (!$advantage["id"]) {echo"error (advantage not found)";exit;}


if ($_REQUEST["type"] == $url[1]){
    validate(["name", "description", "btn_name"]);

    include "modules/uploadImage.php";
    
    $uploadedAdvantageImage = uploadImageWithUpdate("image", "images/advantage", ["jpg","jpeg","png"], false, false, $advantage["image_id"]);

    if (!$errors["forms"] || count($errors["forms"]) == 0) {
        
        $advantage_id = $db->update("advantages", [
            "image_id" => $uploadedAdvantageImage["image_id"],
            "name" => json_encode($_POST["name"], JSON_UNESCAPED_UNICODE),
            "description" => json_encode($_POST["description"], JSON_UNESCAPED_UNICODE),
            "btn_name" => json_encode($_POST["btn_name"], JSON_UNESCAPED_UNICODE),
            "btn_link" => $_POST["btn_link"] ? $_POST["btn_link"] : null,
        ], [
            "id" => $advantage["id"]
        ]);

        header("Location: /admin/advantagesList/?page=" . $page);
        exit;
    } else {
        // header("Content-type: text/plain");
        // print_r($errors);
        // exit;
    }
}
if ($_REQUEST["type"] == "deleteadvantage") {
    $db->delete("advantages", $advantage["id"], "id");

    if ($advantage["image_id"] > 0) {
        if ($advantage["image_id"] > 0) delete_image($advantage["image_id"]);
    }

    header("Location: /admin/advantagesList/?page=" . $page);
    exit;
}

include "head.php";

$breadcump_title_1 = "Afzalliklarimiz";
$breadcump_title_2 = "Afzallikni tahrirlash";
$form_title = "Afzallikni tahrirlash";
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
                                <input type="hidden" name="id" value="<?=$advantage["id"]?>">

                                <div class="form-row">
                                    <?
                                        if ($advantage["image_id"] > 0) {
                                            $image = image($advantage["image_id"]);
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
                                            <input name="name[<?=$lang["flag_icon"]?>]" value="<?=lng($advantage['name'], $lang["flag_icon"])?>" class="form-control" placeholder="Nomi" />
                                        </div>
                                        
                                        <div class="form-group col-12" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <?=getError("description")?>
                                            <label>Izohi <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="description[<?=$lang["flag_icon"]?>]" value="<?=lng($advantage['description'], $lang["flag_icon"])?>" class="form-control" placeholder="Izohi" />
                                        </div>

                                        <div class="form-group col-12" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <?=getError("btn_name")?>
                                            <label>knopka matni <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input type="text" name="btn_name[<?=$lang["flag_icon"]?>]" value="<?=lng($advantage['btn_name'], $lang["flag_icon"])?>" class="form-control" placeholder="knopka matni">
                                        </div>
                                    <? } ?>

                                    <?=getError("btn_link")?>
                                    <div class="form-group col-12">
                                        <label>knopkani ustiga bo'sganda qayoqa yuborish manzili</label>
                                        <input type="text" name="btn_link" value="<?=$advantage["btn_link"]?>" class="form-control" placeholder="knopkani ustiga bo'sganda qayoqa yuborish manzili">
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