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
    validate(["video"]);
    
    include "modules/uploadImage.php";

    $uploadedVideoImage = uploadImage("image", "images/video_images", ["jpg","jpeg","png"]);

    if (!$errors["forms"] || count($errors["forms"]) == 0) {
        $video_id = $db->insert("youtube_videos", [
            "creator_user_id" => $user_id,
            "image_id" => $uploadedVideoImage["image_id"],
            "video" => $_POST["video"],
        ]);

        header("Location: /admin/videosList/?page=1");
    } else {
        // header("Content-type: text/plain");
        // print_r($errors);
        // exit;
    }
}

include "head.php";

$breadcump_title_1 = "Videolar";
$breadcump_title_2 = "yangi video qo'shish";
$form_title = "Yangi video qo'shish";
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

                                    <?=getError("video")?>
                                    <div class="form-group col-12">
                                        <label>Video linki misol: (WVl6g5hvcDA)</span></label>
                                        <input type="text" name="video" class="form-control" placeholder="Video linki " />
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

<!-- Script uchun   -->

<?
include "end.php";
?>