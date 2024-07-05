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

$service = $db->assoc("SELECT * FROM services WHERE id = ?", [$id]);
if (!$service["id"]) {echo"error (service not found)";exit;}


if ($_REQUEST["type"] == $url[1]){
    validate(["name",]);

    if (!$errors["forms"] || count($errors["forms"]) == 0) {
        
        $db->update("services", [
            "name" =>  json_encode($_POST["name"], JSON_UNESCAPED_UNICODE),
        ], [
            "id" => $service["id"]
        ]);

        header("Location: /admin/servicesList/?page=" . $page);
        exit;
    } else {
        // header("Content-type: text/plain");
        // print_r($errors);
        // exit;
    }
}
if ($_REQUEST["type"] == "deleteservice") {
    $db->delete("services", $service["id"], "id");

    header("Location: /admin/servicesList/?page=" . $page);
    exit;
}

include "head.php";

$breadcump_title_1 = "Xizmatlar";
$breadcump_title_2 = "Xizmatni tahrirlash";
$form_title = "Xizmatni tahrirlash";
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
                                <input type="hidden" name="page" value="<?=$page?>">
                                <input type="hidden" name="id" value="<?=$service["id"]?>">
                                <input type="hidden" name="type" value="<?=$url[1]?>">

                                <div class="form-row">

                                    <? foreach ($db->in_array("SELECT * FROM langs_list") as $lang) { ?>
                                        <div class="form-group col-12" form-lang="<?=$lang["flag_icon"]?>" style="<?=($lang["flag_icon"] != "uz" ? "display:none" : "")?>">
                                            <?=getError("name")?>
                                            <label>Xizmat nomi <span class="flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span></label>
                                            <input name="name[<?=$lang["flag_icon"]?>]" class="form-control" value="<?=lng($service['name'], $lang["flag_icon"])?>" placeholder="xizmat nomi" />
                                        </div>

                                    <? } ?>

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