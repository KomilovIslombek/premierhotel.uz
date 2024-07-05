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
    validate(["title", "sub_title"]);
    
    include "modules/uploadImage.php";

    $uploadedBannerImage = uploadImage("image", "images/banners", ["jpg","jpeg","png"]);

    if (!$errors["forms"] || count($errors["forms"]) == 0) {
        $teacher_id = $db->insert("main_banners", [
            "creator_user_id" => $user_id,
            "image_id" => $uploadedBannerImage["image_id"],
            "title" =>  json_encode($_POST["title"], JSON_UNESCAPED_UNICODE),
            "sub_title" => json_encode($_POST["sub_title"], JSON_UNESCAPED_UNICODE),
            "youtube_link" => $_POST["youtube_link"],
        ]);

        header("Location: /admin/mainBannersList/?page=1");
    } else {
        // header("Content-type: text/plain");
        // print_r($errors);
        // exit;
    }
}

include "head.php";

$breadcump_title_1 = "Asosiy banner";
$breadcump_title_2 = "Yangi banner qo'shish";
$form_title = "Yangi banner qo'shish";
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
                                        <label for="formFile" class="form-label">Rasm yuklash (jpg, jpeg, png)</label>
                                        <input class="form-control" type="file" name="image" id="formFile" accept="image/*">
                                    </div>

                                    <?=getError("youtube_link")?>
                                    <div class="form-group col-12">
                                        <label>Youtube link</label>
                                        <input name="youtube_link" class="form-control" placeholder="Youtube link" />
                                    </div>

                                    <? foreach ($db->in_array("SELECT * FROM langs_list") as $lang) { ?>
                                        <div class="form-group col-12" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <?=getError("title")?>
                                            <label>Asosiy sarlavha <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="title[<?=$lang["flag_icon"]?>]" class="form-control" placeholder="asosiy sarlavha" />
                                        </div>
                                        
                                        <div class="form-group col-12" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <?=getError("sub_title")?>
                                            <label>Sarlavha izohi <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="sub_title[<?=$lang["flag_icon"]?>]" class="form-control" placeholder="sarlavha izohi" />
                                        </div>
                                    <? } ?>

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

<!-- Script uchun   -->

<?
include "end.php";
?>