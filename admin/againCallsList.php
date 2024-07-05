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

$page_end = $page * $page_count;
$page_start = $page_end - $page_count;

$againCalls = $db->in_array("SELECT * FROM again_calls ORDER BY id ASC LIMIT $page_start, $page_count");

include "head.php";

$breadcump_title_1 = "Qayta qo'ng'iroqlar";
$breadcump_title_2 = "Qayta qo'ng'iroqlar ro'yxati";
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
                        <div class="table-responsive">
                            <table class="table table-responsive-md mb-0 table-bordered" id="table">
                                <thead>
                                    <tr>
                                        <th>#id</th>
                                        <th>Telefon raqamlar</th>
                                        <th>Qoshilgan sana</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="customers">
                                    <? foreach ($againCalls as $againCall){ ?>
                                        <tr class="btn-reveal-trigger">
                                            <td class="py-2"><?=$againCall["id"]?></td>
                                            <td class="py-2"><a href="tel:<?=$againCall["phone"]?>"><?=$againCall["phone"]?></a></td>
                                            <td class="py-2"><?=$againCall["created_date"]?></td>
                                            <td class="py-2 text-end">
                                                <a class="dropdown-item text-danger btn btn-danger" href="/admin/editAgainCall/?id=<?=$againCall["id"]?>&type=deleteagaincall">O'chirish</a>
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
                            $count = (int)$db->assoc("SELECT COUNT(*) FROM again_calls")["COUNT(*)"];
                            echo pagination($count, "admin/".$url[1]."/", $page_count); 
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