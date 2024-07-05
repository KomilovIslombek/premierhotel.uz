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

$room_books = $db->in_array("SELECT * FROM room_books ORDER BY id ASC LIMIT $page_start, $page_count");

include "head.php";

$breadcump_title_1 = "Bronlar";
$breadcump_title_2 = "Bronlar ro'yxati";
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
                                        <th>Xona #id</th>
                                        <th>Kelish sanasi</th>
                                        <th>Ketish sanasi</th>
                                        <th>Kattalar so'ni</th>
                                        <th>Bolalar so'ni</th>
                                        <th>Ismi</th>
                                        <th>Familyasi</th>
                                        <th>Otasini ismi</th>
                                        <th>Telefon raqami</th>
                                        <th>Qoshilgan sana</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="customers">
                                    <? foreach ($room_books as $room_book){ ?>
                                        <tr class="btn-reveal-trigger">
                                            <td class="py-2"><?=$room_book["room_id"]?></td>
                                            <td class="py-2"><?=$room_book["chackin"]?></td>
                                            <td class="py-2"><?=$room_book["chackout"]?></td>
                                            <td class="py-2"><?=$room_book["adu"]?></td>
                                            <td class="py-2"><?=$room_book["child"]?></td>
                                            <td class="py-2"><?=$room_book["first_name"]?></td>
                                            <td class="py-2"><?=$room_book["last_name"]?></td>
                                            <td class="py-2"><?=$room_book["father_first_name"]?></td>
                                            <td class="py-2"><a href="tel:<?=$room_book["phone_1"]?>"><?=$room_book["phone_1"]?></a></td>
                                            <td class="py-2"><?=$room_book["created_date"]?></td>
                                            <td class="py-2 text-end">
                                                <a class="dropdown-item text-danger btn btn-danger" href="/admin/editRoomBooking/?id=<?=$room_book["id"]?>&type=deleteroomBron">O'chirish</a>
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
                            $count = (int)$db->assoc("SELECT COUNT(*) FROM room_books")["COUNT(*)"];
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