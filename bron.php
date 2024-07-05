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

$room = $db->assoc("SELECT * FROM rooms WHERE id = ?", [ $_REQUEST["room_id"] ]);
if (empty($room["id"])) exit(http_response_code(404));

$price = str_replace(",", "", lng($room["price"]));
$days = seconds_to_days(strtotime($_REQUEST["to_date"]) - strtotime($_REQUEST["from_date"]));

// $amount += $price;

$users_count = (int)$_REQUEST["adults"] + (int)$_REQUEST["childs"];

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

if ($room["id"] == 1 && (int)$_REQUEST["adults"] > 2) { // Standart xona
    exit("Standart xonaga maximum 2 ta odam");
}

if (!empty($_POST["submit"])) {
    if (!empty($_POST["first_name"]) && !empty($_POST["last_name"]) && !empty($_POST["phone_1"])) {
        $book = $db->assoc("SELECT * FROM room_books WHERE room_id = ? AND chackin = ? AND chackout = ? AND first_name = ? AND last_name = ?", [ $room["id"], $_POST["from_date"], $_POST["to_date"], $_POST["first_name"], $_POST["last_name"]]);

        if (empty($book["id"])) {
            $book_id = $db->insert("room_books", [
                "creator_user_id" => ($user_id ? $user_id : 0),
                "amount" => $amount,
                "room_id" => $room["id"],
                "chackin" => $_POST["from_date"],
                "chackout" => $_POST["to_date"],
                "adu" => $_POST["adults"],
                "child" => $_POST["childs"],
                "rooms_count" => 1,
                "first_name" => $_POST["first_name"],
                "last_name" => $_POST["last_name"],
                "father_first_name" => $_POST["father_first_name"],
                "phone_1" => $_POST["phone_1"],
                "phone_2" => $_POST["phone_2"],
                "email" => $_POST["email"],
            ]);
    
            if ($book_id > 0) {
                $text = "🟢 Sayt orqali ariza qoldirishdi";
                $text .= "\n\n🛎 Xona: " . lng($room["name"], "uz");
                $text .= "\n📅 Sanadan: " . $_POST["from_date"];
                $text .= "\n📅 Sanagacha: " . $_POST["to_date"];
                $text .= "\n👤 Ism: " . $_POST["first_name"];
                $text .= "\n👤 Familiya: " . $_POST["last_name"];
                $text .= "\n👤 Otchestvo: " . $_POST["father_first_name"];
                $text .= "\n☎️ Telefon: " . $_POST["phone_1"];
                $text .= "\n📞 Qo'shimcha telefon: " . $_POST["phone_2"];
                $text .= "\n📩 Email: " . $_POST["email"];
                $text .= "\n\n💰 Summa: " . number_format($amount, 0, "", ",") . " so'm";
    
                include "system/classes/sms.php";
                foreach ([6141103444, 6144316609, 166975358] as $chat_id) {
                    sendMessage($text, $chat_id);
                }
            } else {
                echo "Kutilmagan xatolik yuzaga keldi";
                exit;
            }
        } else {
            $book_id = $book["id"];
        }

        exit(header("Location: invoice/" . encode($book_id)));
    }
}

include "system/head.php";
?>
      
   <!-- main-area -->
    <main>
        <!-- booking-area -->
        <section id="booking" class="booking mt-150 pb-120 p-relative fix section">
            <div class="animations-01"><img src="../theme/riorelax/img/bg/an-img-01.png" alt="an-img-01"></div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12 col-md-12">
                            <div class="contact-bg02">
                            <div class="section-title center-align">
                                <h2>
                                    <?=lng($room["name"])?>
                                </h2>
                                <h4 class="mt-2">Kattalar: <?=(int)$_GET["adults"]?></h4>
                                <h4>Bolalar: <?=(int)$_GET["childs"]?></h4>
                                <h4><?=translate("Kelish sanasi")?>: <?=$_REQUEST["from_date"]?></h4>
                                <h4><?=translate("Ketish sanasi")?>: <?=$_REQUEST["to_date"]?></h4>
                                <h4>Jami: <?=number_format($amount, 0, "", ",")?> so'm</h4>
                            </div>                                
                            <form action="/<?=$url2[0]?>/bron" method="POST" class="contact-form mt-30">
                                <input type="hidden" name="room_id" value="<?=$_GET["room_id"]?>">
                                <input type="hidden" name="from_date" value="<?=$_GET["from_date"]?>">
                                <input type="hidden" name="to_date" value="<?=$_GET["to_date"]?>">
                                <input type="hidden" name="adults" value="<?=$_GET["adults"]?>">
                                <input type="hidden" name="childs" value="<?=$_GET["childs"]?>">
                                
                                <div class="row">
                                    <div class="col-12">
                                        <div class="contact-field p-relative c-name mb-20">                                    
                                            <label><i class="fal fa-badge-check"></i> <?=translate("Ismingiz")?></label>
                                                <input type="text" required id="first_name" placeholder="<?=translate("Ismingiz")?>" name="first_name" required="">
                                        </div>                               
                                    </div>

                                    <div class="col-12">                               
                                        <div class="contact-field p-relative c-subject mb-20">                                   
                                            <label><i class="fal fa-times-octagon"></i> <?=translate("Familiyangiz")?></label>
                                                <input type="text" required id="last_name" placeholder="<?=translate("Familiyangiz")?>" name="last_name" required="">
                                        </div>
                                    </div>		
                                    
                                    <div class="col-12">                               
                                        <div class="contact-field p-relative c-subject mb-20">                                   
                                            <label><i class="fal fa-times-octagon"></i> <?=translate("Otangizni ismi")?></label>
                                                <input type="text"  id="father_first_name" placeholder="<?=translate("Otangizni ismi")?>" name="father_first_name">
                                        </div>
                                    </div>		
                                    
                                    <div class="col-12">                               
                                        <div class="contact-field p-relative c-subject mb-20">                                   
                                            <label><i class="fal fa-times-octagon"></i> <?=translate("Telefon raqamingiz")?></label>
                                                    <input type="text" required class=" placeholder="<?=translate("Telefon raqamingiz")?>" name="phone_1" required="">
                                        </div>
                                    </div>		
                                    
                                    <div class="col-12">                               
                                        <div class="contact-field p-relative c-subject mb-20">                                   
                                            <label><i class="fal fa-times-octagon"></i> <?=translate("Qo'shimcha raqamingiz")?></label>
                                                <input type="text"  class="" placeholder="<?=translate("Qo'shimcha raqamingiz")?>" name="phone_2">
                                        </div>
                                    </div>		
                                    
                                    <div class="col-12">                               
                                        <div class="contact-field p-relative c-subject mb-20">                                   
                                            <label><i class="fal fa-times-octagon"></i> <?=translate("Elektron pochtangiz")?></label>
                                                <input type="text" required id="email" placeholder="<?=translate("Elektron pochtangiz")?>" name="email">
                                        </div>
                                    </div>		
                                    
                                    <div class="col-lg-12">
                                        <div class="slider-btn mt-15">                                       
                                            <button type="submit" name="submit" value="submit" id="bookingRoom" class="btn ss-btn" data-animation="fadeInRight" data-delay=".8s"><span><?=lng($home["text_2"])?></span></button>				
                                        </div>                             
                                    </div>
                                </div>
                            </form>                            
                        </div>  
                                            
                    </div>
                </div>
            </div>
        </section>
        <!-- booking-area-end -->
        <!-- brand-area -->
        <div class="brand-area pt-60 pb-60" style="background-color:#f7f5f1">
            <div class="container">
                <div class="row brand-active">
                    <? foreach ($cards as $card) {
                        $card_image = image($card["image_id"]);
                    ?>
                        <div class="col-xl-2">
                            <div class="single-brand">
                                <img style="width: 140px; height: 48px; object-fit:cover;" src="<?=$card_image["file_folder"]?>" alt="img">
                            </div>
                        </div>
                    <? } ?>
                    
                </div>
            </div>
        </div>
        <!-- brand-area-end -->
    </main>
   <!-- main-area-end -->

   <div class="modal_container d-none">
       <div class="language_modal">
        <? foreach ($db->in_array("SELECT * FROM langs_list") as $lang) { ?>
            <div class="language_item" data-flag="<?=str_replace("gb", "en", $lang["flag_icon"])?>">
                <span class="me-3 flag-icon flag-icon-<?=$lang["flag_icon"]?>"></span>
                <p><?=$lang["name"]?></p>
            </div>
        <? } ?>
       </div>
   </div>
   <div class="bg-blur d-none"></div>

   <style>
    .bg-blur{
        width: 100%;
        height: 100%;
        background: rgba(37, 37, 37, 0.881);
        opacity: 1;
        position: fixed;
        inset:0;
        z-index: 99;
    }
    .modal_container{
        width: 100%;
        height: 100%;
        z-index: 9999;
        display: flex;
        justify-content: center;
        align-items:center;
        position: absolute;
        inset: 0;
        position: fixed;
    }
    .language_item:last-child {
        border: none !important;
    }
    .language_modal{
        width: 450px;
        border-radius: 16px;
        background: white;
        display: flex;
        flex-direction: column;
        justify-content: space-evenly;
        color:black;
    }
    .language_item{
        padding: 20px;
        display: flex;
        justify-content: flex-start;
        align-items:center;
        cursor: pointer;
        font-size: 23px;
        font-family: sans-serif;
        font-weight: 600;
        border-bottom: 1px solid #ccc;
    }
    .language_item p{
        margin: 0;
    }
    .single-slider::before{
        background: black !important;
        content: '' !important;
        position: absolute !important;
        width: 100% !important;
        height: 100% !important;
        top: 0 !important;
        left: 0 !important;
        z-index: 1 !important;
        opacity: 0.4 !important;
    }
    .gallery-image{
        height: 300px !important;
    }
    .back_img{
        /* padding: 20px;  */
        width: 94px;
        height: 94px;
        display: grid;
        place-items: center;
        border-radius: 50%;
        background: #242527;
        /* background: rgba(30, 29, 29, 0.749); */

        /* background: rgba(12, 12, 12, 0.758); */

        width: 94px;
    }
    @media (max-width: 810px) {
        .l_change {
            padding-left: 0 !important;
        }
        .r_change {
            padding-right: 0 !important;
        }
    }
   </style>

<?
include "system/scripts.php";
?>

<script>
    $(document).on("click", "#bookingRoom", function(){
        var elm = $(this);
        var roomId = $(elm).parents(".section").find("[name='room_id']").val();
        var first_name = $(elm).parents(".section").find("[name='first_name']").val();
        var last_name = $(elm).parents(".section").find("[name='last_name']").val();
        var father_first_name = $(elm).parents(".section").find("[name='father_first_name']").val();
        var phone_1 = $(elm).parents(".section").find("[name='phone_1']").val();
        var phone_2 = $(elm).parents(".section").find("[name='phone_2']").val();
        var email = $(elm).parents(".section").find("[name='email']").val();
        
        var chackin = getCookieValue("chackin");
        var chackout = getCookieValue("chackout");
        var adu = getCookieValue("adu");
        var child = getCookieValue("child") != 'sports-massage' ? getCookieValue("child") : null;
        
        if(!first_name) {
            $(".modal-title").text(`Ismingizni kiritishni unutdingiz`);
            $(".modal_err").modal("show");
        } else if(!last_name) {
            $(".modal-title").text(`Familiyangiz kiritishni unutdingiz`);
            $(".modal_err").modal("show");
        } else if(!phone_1) {
            $(".modal-title").text(`Telefon raqamingizni kiritishni unutdingiz`);
            $(".modal_err").modal("show");
        } else if(!email) {
            $(".modal-title").text(`Elektron pochtangizni kiritishni unutdingiz`);
            $(".modal_err").modal("show");
        } else {
           
        }

    })

    // var lang = getCookieValue("lang");
    // if(!lang) {
    //     $(".modal_container").removeClass("d-none");
    //     $(".bg-blur").removeClass("d-none");
    // } else {
    //     $(".modal_container").addClass("d-none");
    //     $(".bg-blur").addClass("d-none");
    // }

    // $(".language_item").on("click", function () {
    //     var fName = $(this).attr('data-flag');
    //     window.history.pushState('title', 'Title', '/'+fName+'/');
    //     setCookie("lang", fName, 3);
    //     $(".modal_container").addClass("d-none");
    //     $(".bg-blur").addClass("d-none");
    // })

</script>

<?
include "system/end.php";
?>