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

$lang = $db->assoc("SELECT * FROM langs_list WHERE id = ?", [$id]);
if (!$lang["id"]) {echo"error (lang not found)";exit;}

$flag_icon = isset($lang['flag_icon']) ? $lang['flag_icon'] : null;
if ($flag_icon == "uz") exit("Ushbu tilning tarjimasi yo'q !!!");

if ($_REQUEST["type"] == "add_word"){
    $lang_word_1 = isset($_REQUEST['lang_word_1']) ? $_REQUEST['lang_word_1'] : null;
    if (!$lang_word_1) {echo"error: lang_word_1";exit;}

    $lang_word_2 = isset($_REQUEST['lang_word_2']) ? $_REQUEST['lang_word_2'] : null;
    if (!$lang_word_2) {echo"error: lang_word_2";exit;}

    if ($db->assoc("SELECT COUNT(*) FROM words WHERE uz = ?", [ $lang_word_1 ])["COUNT(*)"] != 0) {
        exit("Bunday so'z bazada mavjud !!!");
    }
    
    if (!$flag_icon) {echo"error: flag_icon";exit;}
    
    $db->insert("words", [
        "uz" => $lang_word_1,
        "$flag_icon" => $lang_word_2
    ]);

    header("Location: /admin/words?id=".$id);
}

if ($_REQUEST["type"] == "deleteword") {
    if (!is_array($lang) || count($lang) == 0) exit("Bunday so'z bazada mavjud emas");

    $word_id = isset($_REQUEST["word_id"]) ? $_REQUEST["word_id"] : null;
    if (!$word_id) {echo"error: word_id";exit;}
    
    $db->delete("words", $word_id, "id");
    header("Location: /admin/words?id=".$id);
}

if ($_REQUEST["type"] == "update_words") {
    foreach ($_REQUEST["words"] as $word_id => $words) {
        foreach ($words as $key2 => $value2) {
            if ($key2 == "uz" && $db->assoc('SELECT COUNT(*) FROM words WHERE uz = "'.$value2.'" ')["COUNT(*)"] == 0) {
                exit("Kechirasiz <b>O'zbek</b> tilidagi barcha so'zlarni tahrirlash mumkin emas !!!<br>sababi o'zbek tilidagi so'zlar saytga indenfikator sifatida berilgan.");  
            } 
        }
        foreach ($words as $key2 => $value2) {
            $db->update("words", [
                "$key2" => $value2
            ], [
                "id" => $word_id
            ]);
        }
    }
    header("Location: /admin/words?id=".$id);
}

include "head.php";

$breadcump_title_1 = "Tillar";
$breadcump_title_2 = "Tillni tahrirlash";
$form_title = "Tillni tahrirlash";
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
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" style="text-transform:none;"><?=$form_title?></h4>
                    </div>
                    <div class="card-body">
                        <form action="/admin/<?=$url[1]?>" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="type" value="update_words">
                            <input type="hidden" name="page" value="<?=$page?>">
                            <input type="hidden" name="id" value="<?=$lang["id"]?>">
                            <div class="table-responsive">
                                <table class="table table-responsive-md mb-0 table-bordered" id="table">
                                    <thead>
                                        <tr class="bg-dark text-white">
                                            <th>O'zbekcha <span class="flag-icon flag-icon-uz" id="lang_icon"></span></th>
                                            <th><?=$lang['name']?> <span class="flag-icon flag-icon-<?=$lang['flag_icon']?>" id="lang_icon"></th>
                                            <th width="50px">o'chirish</th>
                                        </tr>
                                    </thead>
                                    <tbody id="customers">
                                        <? foreach($db->in_array("SELECT * FROM words") as $word) { ?>
                                            <tr>
                                                <td>
                                                <input type="text" name="words[<?=$word['id']?>][uz]" class="form-control border-primary" placeholder="so'z" id="userinput5" value="<?=$word['uz']?>" readonly="" style="background-color:#fff;">
                                                </td>
                                                <td>
                                                <input type="text" name="words[<?=$word['id']?>][<?=$lang['flag_icon']?>]" class="form-control border-primary" placeholder="so'z" id="userinput5" value="<?=$word[$lang['flag_icon']]?>">
                                                </td>
                                                <td>
                                                <div class="text-center"><a href="/admin/words?type=deleteword&word_id=<?=$word['id']?>&id=<?=$_GET['id']?>" class="btn btn-sm btn-danger text-white bg-danger"><i class="fa-solid fa-xmark"></i></a></div>
                                                </td>
                                            </tr>
                                        <? } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="card-block mt-3">
                                <div class="form-actions" style="text-align:right">
                                    <button type="submit" name="submit_update" class="btn btn-primary">
                                        <i class="fa-solid fa-check"></i> Barchas so'zlarni yangilash
                                    </button>
                                </div>  
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!--  -->

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" id="basic-layout-colored-form-control" style="text-transform:none">Yangi so'z qo'shish</h4>
                        <a class="heading-elements-toggle"><i class="icon-ellipsis font-medium-3"></i></a>
                        <div class="heading-elements">
                            <ul class="list-inline mb-0">
                                <li><a data-action="collapse"><i class="fa-solid fa-minus"></i></a></li>
                                <li class="mx-2"><a data-action="reload"><i class="icon-reload"></i></a></li>
                                <li class="me-2"><a data-action="expand"><i class="fa-solid fa-expand"></i></a></li>
                                <li><a data-action="close"><i class="fa-solid fa-xmark"></i></a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-block">
                            <form action="/admin/<?=$url[1]?>" method="POST" class="form col-md-12" enctype="multipart/form-data" disable-progress="true">
                                <input type="hidden" name="type" value="add_word">
                                <input type="hidden" name="page" value="<?=$page?>">
                                <input type="hidden" name="id" value="<?=$lang['id']?>">

                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="userinput5">O'zbekcha <span class="flag-icon flag-icon-uz" id="lang_icon"></span></label>
                                            <input type="text" name="lang_word_1" class="form-control border-primary" placeholder="so'z" required>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="userinput5"><?=$lang['name']?> <span class="flag-icon flag-icon-<?=$lang['flag_icon']?>" id="lang_icon"></label>
                                            <input type="text" name="lang_word_2" class="form-control border-primary" placeholder="so'z" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-actions" style="text-align:right">
                                    <button type="submit" name="submit" class="btn btn-primary">
                                        <i class="fa-solid fa-check"></i> Qo'shish
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!--  -->
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