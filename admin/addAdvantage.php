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

if ($_REQUEST["type"] == $url[1]){
    validate(["name", "description", "btn_name", ]);

    include "modules/uploadImage.php";
    
    $uploadedAdvantageFrontImage = uploadImage("image", "images/advantage", ["jpg","jpeg","png"]);

    if (!$errors["forms"] || count($errors["forms"]) == 0) {
        $advantage_id = $db->insert("advantages", [
            "creator_user_id" => $user_id,
            "image_id" => $uploadedAdvantageFrontImage["image_id"],
            "name" => json_encode($_POST["name"], JSON_UNESCAPED_UNICODE),
            "description" => json_encode($_POST["description"], JSON_UNESCAPED_UNICODE),
            "btn_name" => json_encode($_POST["btn_name"], JSON_UNESCAPED_UNICODE),
            "btn_link" => $_POST["btn_link"] ? $_POST["btn_link"] : null,
        ]);

        header("Location: /admin/advantagesList/?page=1");
    } else {
        // header("Content-type: text/plain");
        // print_r($errors);
        // exit;
    }
}

include "head.php";

$breadcump_title_1 = "Afzalliklarimiz";
$breadcump_title_2 = "Yangi afzallik qo'shish";
$form_title = "Yangi Afzallik qo'shish";
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
            <div class="col-lg-8 col-sm-12">
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
                                <div class="form-row">
                                
                                    <?=getError("image")?>
                                    <div class="form-group col-12">
                                        <label for="formFile" class="form-label">Afzallik asosiy rasmini yuklash (jpg, jpeg, png)</label>
                                        <input class="form-control" type="file" name="image" id="formFile" accept="image/*">
                                    </div>
                                    
                                    <? foreach ($db->in_array("SELECT * FROM langs_list") as $lang) { ?>
                                        <div class="form-group col-12" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <?=getError("name")?>
                                            <label>Nomi <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="name[<?=$lang["flag_icon"]?>]" class="form-control" placeholder="Nomi" />
                                        </div>
                                        
                                        <div class="form-group col-12" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <?=getError("description")?>
                                            <label>Izohi <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="description[<?=$lang["flag_icon"]?>]" class="form-control" placeholder="Izohi" />
                                        </div>

                                        <div class="form-group col-12" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <?=getError("btn_name")?>
                                            <label>knopka matni <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input type="text" name="btn_name[<?=$lang["flag_icon"]?>]" class="form-control" placeholder="knopka matni">
                                        </div>
                                    <? } ?>

                                    <?=getError("btn_link")?>
                                    <div class="form-group col-12">
                                        <label>knopkani ustiga bo'sganda qayoqa yuborish manzili</label>
                                        <input type="text" name="btn_link" class="form-control" placeholder="knopkani ustiga bo'sganda qayoqa yuborish manzili">
                                    </div>
                                </div>

                                <div class="toolbar toolbar-bottom" role="toolbar" style="text-align: right;">
                                    <button type="submit" class="btn btn-primary">Qo'shish</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
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