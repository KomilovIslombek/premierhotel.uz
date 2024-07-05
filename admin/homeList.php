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

$page = (int)$_GET['page'];
if (empty($page)) $page = 1;

if (!empty($_GET["page_count"])) {
    $page_count = $_GET["page_count"];
} else {
    $page_count = 20;
}

// $page_count = 20;
$page_end = $page * $page_count;
$page_start = $page_end - $page_count;

    $home = $db->in_array("SELECT * FROM home  ORDER BY id ASC LIMIT $page_start, $page_count");

include "head.php";

$breadcump_title_1 = "Bosh sahifadagilar";
$breadcump_title_2 = "Bosh sahifadagilar ro'yxati";
?>

<!--**********************************
    Content body start
***********************************-->

<div class="content-body">
    <div class="container-fluid">
        <!-- Add Order -->
        <div class="page-titles d-flex justify-content-between align-items-center">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?=$breadcump_title_1?></a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)"><?=$breadcump_title_2?></a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div style="min-height: 250px;" class="table-responsive">
                            <table class="table table-responsive-md mb-0 table-bordered" id="table">
                                <thead>
                                    <tr>
                                        <th>#id</th>
                                        <th id="table_image">Biz haqimizda 1 banner</th>
                                        <th id="table_image">Biz haqimizda 2 banner</th>
                                        <th>Call markaz raqami</th>
                                        <th>Navbar knopka matni</th>
                                        <th>Banner knopka matni</th>
                                        <th>Qo'shilgan sana</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="customers">
                                    <? foreach ($home as $home){ ?>
                                        <?
                                            $image = image($home["image_id"]);
                                            $image2 = image($home["image_id2"]);
                                        ?>
                                        
                                        <tr class="btn-reveal-trigger">
                                            <td class="py-2"><?=$home["id"]?></td>
                                            <td id="home_image" class="py-2"><img src="<?=$image["file_folder"]?>" width="125px"></td>
                                            <td id="home_image" class="py-2"><img src="<?=$image2["file_folder"]?>" width="125px"></td>
                                            <td class="py-2"><?=$home["text_1"]?></td>
                                            <td class="py-2"><?=$home["text_2"]?></td>
                                            <td class="py-2"><?=$home["text_3"]?></td>
                                            <td class="py-2"><?=$home["created_date"]?></td>
                                            <td class="py-2 text-end">
                                                <div class="dropdown">
                                                    <button class="btn btn-primary tp-btn-light sharp" type="button" data-bs-toggle="dropdown">
                                                        <span class="fs--1"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="18px" height="18px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg></span>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right border py-0">
                                                        <div class="py-2">
                                                            <a class="dropdown-item"  href="/admin/editHome/?id=<?=$home["id"]?>">Tahrirlash</a>
                                                            <a class="dropdown-item text-danger" href="admin/editHome/?id=<?=$home["id"]?>&type=deletehome">O'chirish</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <? } ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <?
                        include "./modules/pagination.php";

                        // count
                            $count = (int)$db->assoc("SELECT COUNT(*) FROM home")["COUNT(*)"];
                            echo pagination($count, $url[0]."/", $page_count); 
                        ?>
                        <!-- End Pagination -->
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