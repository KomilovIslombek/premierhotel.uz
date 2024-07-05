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

$video = $db->assoc("SELECT * FROM youtube_videos WHERE id = ?", [$id]);
if (!$video["id"]) {echo"error (video not found)";exit;}


if ($_REQUEST["type"] == $url[1]){

    include "modules/uploadImage.php";

    $uploadedVideoImage = uploadImageWithUpdate("image", "images/video_images", ["jpg","jpeg","png"], false, false, $video["image_id"]);

    if (!$errors["forms"] || count($errors["forms"]) == 0) {
        
        $video_id = $db->update("youtube_videos", [
            "image_id" => $uploadedVideoImage["image_id"],
            "video" => $_POST["video"]
        ], [
            "id" => $video["id"]
        ]);

        header("Location: /admin/videosList/?page=" . $page);
        exit;
    } else {
        // header("Content-type: text/plain");
        // print_r($errors);
        // exit;
    }
}
if ($_REQUEST["type"] == "deletevideo") {
    $db->delete("youtube_videos", $video["id"], "id");
    
    if ($video["image_id"] > 0) delete_image($video["image_id"]);
    

    header("Location: /admin/videosList/?page=" . $page);
    exit;
}

include "head.php";

$breadcump_title_1 = "Videolar";
$breadcump_title_2 = "Videoni tahrirlash";
$form_title = "Videoni tahrirlash";
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
                                <input type="hidden" name="id" value="<?=$video["id"]?>">
                                <input type="hidden" name="type" value="<?=$url[1]?>">

                                <div class="form-row">
                                
                                    <?
                                    if ($video["image_id"] > 0) {
                                        $image = image($video["image_id"]);

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

                                    <?=getError("video")?>
                                    <div class="form-group col-12">
                                        <label>Video linki misol: (WVl6g5hvcDA)</span></label>
                                        <input type="text" name="video" class="form-control" value="<?=$video['video']?>" placeholder="Video linki misol: (WVl6g5hvcDA)" />
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