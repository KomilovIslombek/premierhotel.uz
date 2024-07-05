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


if ($_REQUEST["type"] == $url[1]){
    validate(["name",]);
    $flag_icon = $_POST["flag_icon"];
    if (!$errors["forms"] || count($errors["forms"]) == 0) {
        
        $db->update("langs_list", [
            "name" => $_POST["name"],
            "flag_icon" => $_POST["flag_icon"],
        ], [
            "id" => $lang["id"]
        ]);

        $db->query("ALTER TABLE `words` CHANGE ".$lang["flag_icon"]." $flag_icon TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL");


        header("Location: /admin/langsList/?page=" . $page);
        exit;
    } else {
        // header("Content-type: text/plain");
        // print_r($errors);
        // exit;
    }
}

if ($_REQUEST["type"] == "deletelang") {
    $db->delete("langs_list", $lang["id"], "id");
    $db->query("ALTER TABLE words DROP " . $lang["flag_icon"]);

    header("Location: /admin/langsList/?page=" . $page);
    exit;
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
                                <input type="hidden" name="id" value="<?=$lang["id"]?>">
                                
                                <? $langs_icons = ["ad","ae","af","ag","ai","al","am","ao","aq","ar","as","at","au","aw","ax","az","ba","bb","bd","be","bf","bg","bh","bi","bj","bl","bm","bn","bo","bq","br","bs","bt","bv","bw","by","bz","ca","cc","cd","cf","cg","ch","ci","ck","cl","cm","cn","co","cr","cu","cv","cw","cx","cy","cz","de","dj","dk","dm","do","dz","ec","ee","eg","eh","er","es","es-ca","es-ga","et","eu","fi","fj","fk","fm","fo","fr","ga","gb","gb-eng","gb-nir","gb-sct","gb-wls","gd","ge","gf","gg","gh","gi","gl","gm","gn","gp","gq","gr","gs","gt","gu","gw","gy","hk","hm","hn","hr","ht","hu","id","ie","il","im","in","io","iq","ir","is","it","je","jm","jo","jp","ke","kg","kh","ki","km","kn","kp","kr","kw","ky","kz","la","lb","lc","li","lk","lr","ls","lt","lu","lv","ly","ma","mc","md","me","mf","mg","mh","mk","ml","mm","mn","mo","mp","mq","mr","ms","mt","mu","mv","mw","mx","my","mz","na","nc","ne","nf","ng","ni","nl","no","np","nr","nu","nz","om","pa","pe","pf","pg","ph","pk","pl","pm","pn","pr","ps","pt","pw","py","qa","re","ro","rs","ru","rw","sa","sb","sc","sd","se","sg","sh","si","sj","sk","sl","sm","sn","so","sr","ss","st","sv","sx","sy","sz","tc","td","tf","tg","th","tj","tk","tl","tm","tn","to","tr","tt","tv","tw","tz","ua","ug","um","un","us","uy","uz","va","vc","ve","vg","vi","vn","vu","wf","ws","xk","ye","yt","za","zm","zw"]; ?>

                                <div class="form-row">

                                    <?=getError("name")?>
                                    <div class="form-group col-12">
                                        <label>Til nomi:</label>
                                        <input class="form-control"  name="name" value="<?=$lang["name"]?>" />
                                    </div>

                                    <?=getError("flag_icon")?>
                                    <div class="form-group col-12">
                                        <label>Tilni tanlang <span class="flag-icon flag-icon-<?=$lang['flag_icon']?>" id="lang_icon"></span></label>

                                        <select name="flag_icon" data-live-search="true" class="refresh mt-2 btn-sm form-control default-select form-control-lg no-overflow">
                                            <? foreach ($langs_icons as $lang_name) { 
                                                $been_lang = $db->assoc("SELECT * FROM langs_list WHERE flag_icon = ? AND id != ?", [ $lang_name, $lang["id"] ]);
                                                if(!$been_lang["id"]) {
                                            ?>
                                                <option value="<?=$lang_name?>" <?=($lang["flag_icon"] == $lang_name ? 'selected=""' : '')?>><?=$lang_name?></option>
                                            <? } 
                                              } ?>
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

include "end.php";
?>