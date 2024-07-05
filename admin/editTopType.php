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

$topType = $db->assoc("SELECT * FROM types WHERE id = ?", [$id]);
if (!$topType["id"]) {echo"error (topType not found)";exit;}


if ($_REQUEST["type"] == $url[1]){
    validate(["name", "privilege"]);

    include "modules/uploadImage.php";
    
    $uploadedTopTypeImage = uploadImageWithUpdate("image", "images/topTypes", ["jpg","jpeg","png"], false, false, $topType["image_id"]);

    if (!$errors["forms"] || count($errors["forms"]) == 0) {
        
        $topType_id = $db->update("types", [
            "image_id" => $uploadedTopTypeImage["image_id"],
            "name" => $_POST["name"],
            "privilege" => $_POST["privilege"],
            "package_id" => $_POST["package_id"],
        ], [
            "id" => $topType["id"]
        ]);

        header("Location: /admin/topTypesList/?page=" . $page);
        exit;
    } else {
        // header("Content-type: text/plain");
        // print_r($errors);
        // exit;
    }
}
if ($_REQUEST["type"] == "deletetoptype") {
    $db->delete("types", $topType["id"], "id");

    if ($topType["image_id"] > 0) {
        if ($topType["image_id"] > 0) delete_image($topType["image_id"]);
    }

    header("Location: /admin/topTypesList/?page=" . $page);
    exit;
}

include "head.php";

$breadcump_title_1 = "Sara turlar";
$breadcump_title_2 = "Turni tahrirlash";
$form_title = "Turni tahrirlash";
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
            <div class="col-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" style="text-transform:none;"><?=$form_title?></h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="/admin/<?=$url[1]?>" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="type" value="<?=$url[1]?>">
                                <input type="hidden" name="page" value="<?=$page?>">
                                <input type="hidden" name="id" value="<?=$topType["id"]?>">
                                <input type="hidden" name="type" value="<?=$url[1]?>">

                                <div class="form-row">

                                    <?
                                        if ($topType["image_id"] > 0) {
                                            $image = image($topType["image_id"]);
                                            echo '<image style="object-fit:cover;" src="'.$image["file_folder"].'" width="180px">';
                                        }
                                    ?>

                                    <?=getError("image")?>
                                    <div class="form-group col-12 mt-2">
                                        <label for="formFile" class="form-label">Sara tur rasmini yuklash (jpg, jpeg, png)</label>
                                        <input class="form-control" type="file" name="image" id="formFile" accept="image/*">
                                    </div>

                                    <?=getError("name")?>
                                    <div class="form-group col-12">
                                        <label>Sara tur nomi</span></label>
                                        <input type="text" name="name" class="form-control" value="<?=$topType['name']?>" placeholder="Sara tur nomi" />
                                    </div>

                                    <?=getError("privilege")?>
                                    <div class="form-group col-12">
                                        <label>Sara tur imtiyozi</span></label>
                                        <input type="text" name="privilege" class="form-control" value="<?=$topType['privilege']?>" placeholder="Sara tur imtiyozi" />
                                    </div>

                                    <?=getError("package_id")?>
                                    <div class="form-group col-12">
                                        <label>Paketlar ro'yxati:</label>
                                        <select name="package_id" class="form-control default-select form-control-lg">
                                            <? foreach ($db->in_array("SELECT * FROM packages") as $package) { ?>
                                                <option value="<?=$package["id"]?>" <?=($package["id"] == $topType["package_id"] ? 'selected=""' : '')?>><?=$package["name"]?></option>
                                            <? } ?>
                                        </select>
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

<?
include "end.php";
?>