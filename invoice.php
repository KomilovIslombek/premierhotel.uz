<?
$is_config = true;
if (empty($load_defined)) include 'load.php';


$home = $db->assoc("SELECT * FROM home");
$image = image($home["image_id"]);
$image2 = image($home["image_id2"]);
$image3 = image($home["image_id3"]);
$mainBanners = $db->in_array("SELECT * FROM main_banners");
$advantages = $db->in_array("SELECT * FROM advantages");
// $rooms = $db->in_array("SELECT * FROM rooms");
$cards = $db->in_array("SELECT * FROM pictures");
$services = $db->in_array("SELECT * FROM services");
$gallery_images = $db->in_array("SELECT * FROM gallery");

$info = $db->in_array("SELECT * FROM info");
$featured = $db->in_array("SELECT * FROM featured");
$featuredParts = array_chunk($featured, (ceil(count($featured)/3)));

$book = $db->assoc("SELECT * FROM room_books WHERE id = ?", [ decode($url[1]) ]);
if (empty($book["id"])) exit(http_response_code(404));

$room = $db->assoc("SELECT * FROM rooms WHERE id = ?", [ $book["room_id"] ]);
$days = seconds_to_days(strtotime($book["chackout"]) - strtotime($book["chackin"]));
$price = str_replace(",", "", lng($room["price"]));

$users_count = $book["adu"] + $book["child"];

$users_amount = 0;
switch ($users_count) {
    case 3:
        $users_amount = 250000;
    break;
    case 2:
        $users_amount = 150000;
    break;
}

$total_price = ($price * $days);
$users_amount_total = ($users_amount * $days);
$amount = $total_price + $users_amount_total;

include "system/head.php";
?>

<div class="container" style="margin-top:170px;margin-bottom:80px;">
   <div class="col-md-12">
      <div class="invoice">
         <!-- begin invoice-company -->
         <div class="invoice-company text-inverse f-w-600">
            <span class="pull-right hidden-print">
            <!-- <a href="javascript:;" class="btn btn-sm btn-white m-b-10 p-l-5"><i class="fa fa-file t-plus-1 text-danger fa-fw fa-lg"></i> <?=translate("PDFni yuklab olish")?></a> -->
            <a href="javascript:;" class="btn btn-sm btn-white m-b-10 p-l-5" id="print-invoice"><i class="fa fa-print t-plus-1 fa-fw fa-lg"></i> <?=translate("Chop etish")?></a>
            </span>
            <?=translate("Hisob-faktura")?>
         </div>
         <!-- end invoice-company -->
         <!-- begin invoice-header -->
         <div class="invoice-header">
            <div class="invoice-from">
               <small><?=translate("Buyurtma beruvchi")?>:</small>
               <address class="m-t-5 m-b-5">
                    <?=translate("Ism")?>: <b><?=$book["first_name"]?></b><br>
                    <?=translate("Familiya")?>: <b><?=$book["last_name"]?></b><br>
                    <?=translate("Otasining ismi")?>: <b><?=$book["father_first_name"]?></b><br>
                    <?=translate("Telefon")?>: <b><?=$book["phone_1"]?></b><br>
                    <? if (!empty($book["phone_2"])) { ?>
                        <?=translate("Qo'shimcha raqam")?>: <b><?=$book["phone_2"]?></b><br>
                    <? } ?>
                    <? if (!empty($book["email"])) { ?>
                        <?=translate("Elektron pochta")?>: <b><?=$book["email"]?></b><br>
                    <? } ?>
               </address>
            </div>
            <div class="invoice-to">
               <small><?=translate("Buyurtma ma'lumotlari")?></small>
               <address class="m-t-5 m-b-5">
                    <?=translate("Xona turi")?>: <b><?=lng($room["name"])?></b><br>
                    <?=translate("Kattalar")?>: <b><?=$book["adu"]?> <?=translate("ta")?></b><br>
                    <?=translate("Bolalar")?>: <b><?=$book["child"]?> <?=translate("ta")?></b><br>
                    <?=translate("Kelish sanasi")?>: <b><?=$book["chackin"]?></b><br>
                    <?=translate("Ketish sanasi")?>: <b><?=$book["chackout"]?></b>
               </address>
            </div>
            <div class="invoice-date">
               <small><?=translate("Tafsilotlar")?></small>
               <div class="date text-inverse m-t-5"><?=date("M", strtotime($book["created_date"]))?> <?=date("d", strtotime($book["created_date"]))?>, <?=date("Y", strtotime($book["created_date"]))?></div>
               <div class="date text-inverse m-t-5"><?=date("H:i:s", strtotime($book["created_date"]))?></div>
               <div class="invoice-detail">
                  <?=translate("Buyurtma raqami")?>: #<?=$book["id"]?><br>
               </div>
            </div>
         </div>
         <!-- end invoice-header -->
         <!-- begin invoice-content -->
         <div class="invoice-content">
            <!-- begin table-responsive -->
            <div class="table-responsive">
                <table class="table table-invoice">
                    <thead>
                        <tr>
                            <th><?=translate("Buyurtma ro'yxati")?></th>
                            <th class="text-center" width="10%"><?=translate("Kattalar")?></th>
                            <th class="text-center" width="10%"><?=translate("Bolalar")?></th>
                            <th class="text-right" width="20%"><?=translate("Jami")?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                            <span class="text-inverse"><?=lng($room["name"])?></span><br>
                            </td>
                            <td class="text-center"><?=$book["adu"]?> <?=translate("ta")?></td>
                            <td class="text-center"><?=$book["child"]?> <?=translate("ta")?></td>
                            <td class="text-right"><?=number_format($price, 0, "", ",")?> so'm</td>
                        </tr>
                        <? if ($users_count > 1) { ?>
                            <tr>
                                <td>
                                <span class="text-inverse"><?=str_replace("{users_count}", ($users_count-1), translate("Qo'shimcha {users_count} ta odam uchun"))?></span><br>
                                </td>
                                <td class="text-center"><?=$book["adu"]?> <?=translate("ta")?></td>
                                <td class="text-center"><?=$book["child"]?> <?=translate("ta")?></td>
                                <td class="text-right"><?=number_format($users_amount, 0, "", ",")?> so'm</td>
                            </tr>
                        <? } ?>
                    </tbody>
                </table>
            </div>
            <!-- end table-responsive -->
            <!-- begin invoice-price -->
            <div class="invoice-price">
               <div class="invoice-price-left">
                    <div class="invoice-price-row">
                        <div class="sub-price">
                            <small><?=translate("Xona narxi")?></small>
                            <span class="text-inverse"><?=number_format($total_price, 0, "", ",")?> so'm</span>
                        </div>
                        <? if ($users_count > 1) { ?>
                            <div class="sub-price">
                                <i class="fa fa-plus text-muted"></i>
                            </div>
                            <div class="sub-price">
                                <small><?=translate("Qo'shimcha odam")?> (<?=($users_count - 1)?> <?=translate("ta")?>)</small>
                                <span class="text-inverse"><?=number_format($users_amount_total, 0, "", ",")?> so'm</span>
                            </div>
                        <? } ?>
                    </div>
               </div>
               <div class="invoice-price-right">
                  <small>Jami</small> <span class="f-w-600"><?=number_format($book["amount"], 0, "", ",")?> so'm</span>
               </div>
            </div>
            <!-- end invoice-price -->
         </div>
         <!-- end invoice-content -->
         <!-- begin invoice-note -->
         <div class="invoice-note">
            <?=translate("* Agar sizda ushbu hisob-faktura bo'yicha savollaringiz bo'lsa, [Ism, telefon raqami, elektron pochta] bilan bog'laning.")?>
         </div>
         <!-- end invoice-note -->
         <!-- begin invoice-footer -->
         <div class="invoice-footer">
            <p class="text-center m-b-5 f-w-600">
               <?=translate("Bizni tanlaganingiz uchun rahmat")?>
            </p>
            <p class="text-center">
               <span class="m-r-10"><i class="fa fa-fw fa-lg fa-globe"></i> <?=$domain?></span>
               <span class="m-r-10"><i class="fa fa-fw fa-lg fa-phone-volume"></i> <?=$home["text_40"]?></span>
               <span class="m-r-10"><i class="fa fa-fw fa-lg fa-envelope"></i> <?=$home["text_42"]?></span>
            </p>
         </div>
         <!-- end invoice-footer -->
      </div>
   </div>
</div>

<style>
body {
    /* margin-top:20px; */
    background:#eee;
}

.pull-right {
    margin-top: -6px;
}

.pull-right .btn {
    border: 1px solid #d9dfe3;
    padding: 0.7rem 0.5rem;
    border-radius: 0.2rem;
    border-color: #d9dfe3;
}

.invoice {
    background: #fff;
    padding: 20px;
    color: #000000 !important;
}

.invoice-company {
    font-size: 20px
}

.invoice-header {
    margin: 0 -20px;
    background: #f0f3f4;
    padding: 20px
}

.invoice-date,
.invoice-from,
.invoice-to {
    display: table-cell;
    width: 1%
}

.invoice-from,
.invoice-to {
    padding-right: 20px
}

.invoice-date .date,
.invoice-from strong,
.invoice-to strong {
    font-size: 16px;
    font-weight: 600
}

.invoice-date {
    text-align: right;
    padding-left: 20px
}

.invoice-price {
    background: #f0f3f4;
    display: table;
    width: 100%
}

.invoice-price .invoice-price-left,
.invoice-price .invoice-price-right {
    display: table-cell;
    padding: 20px;
    font-size: 20px;
    font-weight: 600;
    width: 75%;
    position: relative;
    vertical-align: middle
}

.invoice-price .invoice-price-left .sub-price {
    display: table-cell;
    vertical-align: middle;
    padding: 0 20px
}

.invoice-price small {
    font-size: 12px;
    font-weight: 400;
    display: block
}

.invoice-price .invoice-price-row {
    display: table;
    float: left
}

.invoice-price .invoice-price-right {
    width: 25%;
    background: #2d353c;
    color: #fff;
    font-size: 28px;
    text-align: right;
    vertical-align: bottom;
    font-weight: 300
}

.invoice-price .invoice-price-right small {
    display: block;
    opacity: .6;
    position: absolute;
    top: 10px;
    left: 10px;
    font-size: 12px
}

.invoice-footer {
    border-top: 1px solid #ddd;
    padding-top: 10px;
    font-size: 10px
}

.invoice-note {
    color: #999;
    margin-top: 80px;
    font-size: 85%
}

.invoice>div:not(.invoice-footer) {
    margin-bottom: 20px
}

.btn.btn-white, .btn.btn-white.disabled, .btn.btn-white.disabled:focus, .btn.btn-white.disabled:hover, .btn.btn-white[disabled], .btn.btn-white[disabled]:focus, .btn.btn-white[disabled]:hover {
    color: #2d353c;
    background: #fff;
    border-color: #d9dfe3;
}
</style>

<?
include "system/scripts.php";
?>

<script>
    function PrintElem(elm) {
        var mywindow = window.open('', 'PRINT', 'height=1080,width=1920');

        var html = "";
        html += '<html><head>'+$("head").prop("innerHTML")+'</head>';

        html += '<body>';
        html += $(elm).prop("innerHTML");
        html += '</body>';
        html += '</html>';
        console.log(html);
        mywindow.document.write(html);

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        mywindow.print();
        mywindow.close();

        return true;
    }

    $(document).on("click", "#print-invoice", function(){
        PrintElem($(".invoice"));
    });
</script>

<?
include "system/end.php";
?>