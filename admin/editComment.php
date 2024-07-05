<?
$is_config = true;
if (empty($load_defined)) include 'load.php';

if (isAuth() === false) {
    header("Location: /login");
    exit;
}

$page = (int)$_REQUEST["page"];
if (empty($page)) $page = 1;

$id = isset($_REQUEST["id"]) ? $_REQUEST["id"] : null;
if (!$id) {echo"error id not found";return;}

$comment = $db->assoc("SELECT * FROM comments WHERE id = ?", [$id]);
if (!$comment["id"]) {echo"error (comment not found)";exit;}


if ($_REQUEST["type"] == $url[1]){
    validate(["comment", "first_name", "last_name", "who"]);

    include "modules/uploadImage.php";
    
    $uploadedCommentImage = uploadImageWithUpdate("image", "images/comments", ["jpg","jpeg","png"], false, false, $comment["image_id"]);

    if (!$errors["forms"] || count($errors["forms"]) == 0) {
        
        $db->update("comments", [
            "image_id" => $uploadedCommentImage["image_id"],
            "comment" => $_POST["comment"],
            "first_name" => $_POST["first_name"],
            "last_name" => $_POST["last_name"],
            "who" => $_POST["who"],
        ], [
            "id" => $comment["id"]
        ]);

        header("Location: /admin/commentsList/?page=" . $page);
        exit;
    } else {
        // header("Content-type: text/plain");
        // print_r($errors);
        // exit;
    }
}

if ($_REQUEST["type"] == "deletecomment") {
    $db->delete("comments", $comment["id"], "id");

    if ($comment["image_id"] > 0) delete_image($comment["image_id"]);

    header("Location: /admin/commentsList/?page=" . $page);
    exit;
}

include "head.php";

$breadcump_title_1 = "Izohlar";
$breadcump_title_2 = "Izohni tahrirlash";
$form_title = "Izohni tahrirlash";
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
                                <input type="hidden" name="id" value="<?=$comment["id"]?>">

                                <div class="form-row">

                                    <?
                                        if ($comment["image_id"] > 0) {
                                            $image = image($comment["image_id"]);
                                            echo '<image style="object-fit:cover;" src="'.$image["file_folder"].'" width="100px">';
                                        }
                                    ?>

                                    <?=getError("image")?>
                                    <div class="form-group col-12">
                                        <label for="formFile" class="form-label">Rasm yuklash (jpg, jpeg, png)</label>
                                        <input class="form-control" type="file" name="image" id="formFile" accept="image/*">
                                    </div>
                                    
                                    <?=getError("comment")?>
                                    <div class="form-group col-12">
                                        <label>izoh:</label>
                                        <textarea class="form-control"  name="comment"><?=$comment["comment"]?></textarea>
                                    </div>
                                    
                                    <?=getError("first_name")?>
                                    <div class="form-group col-12">
                                        <label>mijozning ismi:</label>
                                        <input type="text" name="first_name" class="form-control" placeholder="mijozning ismi" value="<?=$comment["first_name"]?>">
                                    </div>
                                    
                                    <?=getError("last_name")?>
                                    <div class="form-group col-12">
                                        <label>mijozning familyasi:</label>
                                        <input type="text" name="last_name" class="form-control" placeholder="mijozning familyasi" value="<?=$comment["last_name"]?>">
                                    </div>
                                    
                                    <?=getError("who")?>
                                    <div class="form-group col-12">
                                        <label>mijozning kimligi:</label>
                                        <input type="text" name="who" class="form-control" placeholder="mijozning kimligi" value="<?=$comment["who"]?>">
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

include "end.php";
?>