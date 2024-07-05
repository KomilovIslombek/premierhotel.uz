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
    validate(["name", "privilege"]);

    include "modules/uploadImage.php";
    
    $uploadedTopTypeImage = uploadImage("image", "images/topTypes", ["jpg","jpeg","png"]);

    if (!$errors["forms"] || count($errors["forms"]) == 0) {
        $science_id = $db->insert("types", [
            "creator_user_id" => $user_id,
            "image_id" => $uploadedTopTypeImage["image_id"],
            "name" => $_POST["name"],
            "privilege" => $_POST["privilege"],
            "package_id" => $_POST["package_id"],
        ]);

        header("Location: /admin/topTypesList/?page=1");
    } else {
        // header("Content-type: text/plain");
        // print_r($errors);
        // exit;
    }
}

include "head.php";

$breadcump_title_1 = "Sara turlar";
$breadcump_title_2 = "Yangi tur qo'shish";
$form_title = "Yangi tur qo'shish";
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
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="/admin/<?=$url[1]?>" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="type" value="<?=$url[1]?>">
                                <div class="form-row">
                                
                                    <?=getError("image")?>
                                    <div class="form-group col-12">
                                        <label for="formFile" class="form-label">Sara tur rasmi yuklash (jpg, jpeg, png)</label>
                                        <input class="form-control" type="file" name="image" id="formFile" accept="image/*">
                                    </div>
                                    
                                    <?=getError("name")?>
                                    <div class="form-group col-12">
                                        <label>Sara tur nomi</span></label>
                                        <input type="text" name="name" class="form-control" placeholder="Sara tur nomi" />
                                    </div>
                                    
                                    <?=getError("privilege")?>
                                    <div class="form-group col-12">
                                        <label>Sara tur imtiyozi</span></label>
                                        <input type="text" name="privilege" class="form-control" placeholder="Sara tur imtiyozi" />
                                    </div>

                                    <?=getError("package_id")?>
                                    <div class="form-group col-12">
                                        <label>Paketlar ro'yxati:</label>
                                        <select name="package_id" class="form-control default-select form-control-lg">
                                            <? foreach ($db->in_array("SELECT * FROM packages") as $package) { ?>
                                                <option value="<?=$package["id"]?>"><?=$package["name"]?></option>
                                            <? } ?>
                                        </select>
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

<?
include "end.php";
?>