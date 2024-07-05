<?
$is_config = true;
if (empty($load_defined)) include 'load.php';

if (isAuth() === false) {
    header("Location: /login");
    exit;
}

if ($_REQUEST["type"] == $url[1]){
    validate(["comment", "first_name", "last_name", "who"]);
    if (!$errors["forms"] || count($errors["forms"]) == 0) {

        include "modules/uploadImage.php";
        
        $uploadedCommentImage = uploadImage("image", "images/comments", ["jpg","jpeg","png"]);
        
        $comment_id = $db->insert("comments", [
            "creator_user_id" => $user_id,
            "image_id" => $uploadedCommentImage["image_id"],
            "comment" => $_POST["comment"],
            "first_name" => $_POST["first_name"],
            "last_name" => $_POST["last_name"],
            "who" => $_POST["who"],
        ]);

        header("Location: /admin/commentsList/?page=1");
    } else {
        // header("Content-type: text/plain");
        // print_r($errors);
        // exit;
    }
}

include "head.php";

$breadcump_title_1 = "Izohlar";
$breadcump_title_2 = "yangi izoh qo'shish";
$form_title = "yangi izoh qo'shish";
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
                                        <label for="formFile" class="form-label">Rasm yuklash (jpg, jpeg, png)</label>
                                        <input class="form-control" type="file" name="image" id="formFile" accept="image/*">
                                    </div>

                                    <?=getError("comment")?>
                                    <div class="form-group col-12">
                                        <label>izoh:</label>
                                        <textarea class="form-control" name="comment"></textarea>
                                    </div>

                                    <?=getError("first_name")?>
                                    <div class="form-group col-12">
                                        <label>mijozning ismi:</label>
                                        <input type="text" name="first_name" class="form-control" placeholder="mijozning ismi" value="<?=$_POST["first_name"]?>">
                                    </div>

                                    <?=getError("last_name")?>
                                    <div class="form-group col-12">
                                        <label>mijozning familyasi:</label>
                                        <input type="text" name="last_name" class="form-control" placeholder="mijozning familyasi" value="<?=$_POST["last_name"]?>">
                                    </div>
                                    
                                    <?=getError("who")?>
                                    <div class="form-group col-12">
                                        <label>mijozning kimligi:</label>
                                        <input type="text" name="who" class="form-control" placeholder="mijozning kimligi" value="<?=$_POST["who"]?>">
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