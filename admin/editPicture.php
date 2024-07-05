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

$picture = $db->assoc("SELECT * FROM pictures WHERE id = ?", [$id]);
if (!$picture["id"]) {echo"error (picture not found)";exit;}


if ($_REQUEST["type"] == $url[1]){

    include "modules/uploadImage.php";

    $uploadedPictureImage = uploadImageWithUpdate("image", "images/pictures", ["jpg","jpeg","png"], false, false, $picture["image_id"]);

    if (!$errors["forms"] || count($errors["forms"]) == 0) {
        
        $picture_id = $db->update("pictures", [
            "image_id" => $uploadedPictureImage["image_id"],
        ], [
            "id" => $picture["id"]
        ]);

        header("Location: /admin/picturesList/?page=" . $page);
        exit;
    } else {
        // header("Content-type: text/plain");
        // print_r($errors);
        // exit;
    }
}
if ($_REQUEST["type"] == "deletepicture") {
    $db->delete("pictures", $picture["id"], "id");
    
    if ($picture["image_id"] > 0) delete_image($picture["image_id"]);
    

    header("Location: /admin/picturesList/?page=" . $page);
    exit;
}

include "head.php";

$breadcump_title_1 = "Rasmlar";
$breadcump_title_2 = "Rasmni tahrirlash";
$form_title = "Rasmni tahrirlash";
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
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="/admin/<?=$url[1]?>" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="type" value="<?=$url[1]?>">
                                <input type="hidden" name="page" value="<?=$page?>">
                                <input type="hidden" name="id" value="<?=$picture["id"]?>">
                                <input type="hidden" name="type" value="<?=$url[1]?>">

                                <div class="form-row">
                                
                                    <?
                                    if ($picture["image_id"] > 0) {
                                        $image = image($picture["image_id"]);

                                        if ($image["file_folder"]) {
                                            echo '<image style="object-fit:cover;" src="'.$image["file_folder"].'" width="125px">';
                                        }
                                    }
                                    ?>

                                    <?=getError("image")?>
                                    <div class="form-group col-12">
                                        <label for="formFile" class="form-label">Rasm yuklash (jpg, jpeg, png)</label>
                                        <input class="form-control" type="file" name="image" id="formFile" accept="image/*">
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

<!-- Script uchun -->

<?
include "end.php";
?>