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

$topPlace = $db->assoc("SELECT * FROM top_places WHERE id = ?", [$id]);
if (!$topPlace["id"]) {echo"error (topPlace not found)";exit;}


if ($_REQUEST["type"] == $url[1]){
    validate(["package_id"]);

    if (!$errors["forms"] || count($errors["forms"]) == 0) {
        
        $topPlace_id = $db->update("top_places", [
            "package_id" => $_POST["package_id"],
        ], [
            "id" => $topPlace["id"]
        ]);

        header("Location: /admin/topPlacesList/?page=" . $page);
        exit;
    } else {
        header("Content-type: text/plain");
        print_r($errors);
        exit;
    }
}
if ($_REQUEST["type"] == "deletetopplace") {
    $db->delete("top_places", $topPlace["id"], "id");

    if ($topPlace["image_id"] > 0) {
        if ($topPlace["image_id"] > 0) delete_image($topPlace["image_id"]);
    }

    header("Location: /admin/topPlacesList/?page=" . $page);
    exit;
}

include "head.php";

$breadcump_title_1 = "Sayohatlar";
$breadcump_title_2 = "Sayohatni tahrirlash";
$form_title = "Sayohatni tahrirlash";
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
                                <input type="hidden" name="id" value="<?=$topPlace["id"]?>">
                                <input type="hidden" name="type" value="<?=$url[1]?>">

                                <div class="form-row">

                                    <?=getError("package_id")?>
                                    <div class="form-group col-12">
                                        <label>Paketlar ro'yxati:</label>
                                        <select name="package_id" class="form-control default-select form-control-lg">
                                            <? foreach ($db->in_array("SELECT * FROM packages") as $package) { ?>
                                                <option value="<?=$package["id"]?>" <?=($package["id"] == $topPlace["package_id"] ? 'selected=""' : '')?>><?=$package["name"]?></option>
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