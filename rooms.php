<?
$is_config = true;
if (empty($load_defined)) include 'load.php';

// if (isAuth() === false) {
//     header("Location: /login");
//     exit;
// }


$home = $db->assoc("SELECT * FROM home");
$image = image($home["image_id"]);
$image2 = image($home["image_id2"]);
$image3 = image($home["image_id3"]);
$mainBanners = $db->in_array("SELECT * FROM main_banners");
$advantages = $db->in_array("SELECT * FROM advantages");
$rooms = $db->in_array("SELECT * FROM rooms");
$cards = $db->in_array("SELECT * FROM pictures");
$services = $db->in_array("SELECT * FROM services");
$gallery_images = $db->in_array("SELECT * FROM gallery");

$info = $db->in_array("SELECT * FROM info");
$featured = $db->in_array("SELECT * FROM featured");
$featuredParts = array_chunk($featured, (ceil(count($featured)/3)));
$roomBanner = image($home["image_id4"]);
        

include "system/head.php";

$users_count = (int)$_GET["adults"] + (int)$_GET["childs"];

$days = seconds_to_days(strtotime($_REQUEST["to_date"]) - strtotime($_REQUEST["from_date"]));
?>
      
   <!-- main-area -->
    <main>
        
        <!-- breadcrumb-area -->
        <section class="breadcrumb-area d-flex align-items-center" 
            style="background-image:url(<?=$roomBanner["file_folder"]?>);">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-12 col-lg-12">
                        <div class="breadcrumb-wrap text-center">
                            <div class="breadcrumb-title">
                                <h2><?=translate("Bizning xonalarimiz")?></h2>    
                                <div class="breadcrumb-wrap">
                            
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="/<?=$url2[0]?>"><?=translate("Bosh sahifa")?></a></li>
                                    <li class="breadcrumb-item active" aria-current="page"><?=translate("Bizning xonalarimiz")?></li>
                                </ol>
                            </nav>
                        </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </section>
        <!-- breadcrumb-area-end -->
        <!-- room-area-->
        <section id="rooms" class="services-area pt-120 pb-90">
            
            <div class="container">

            <div class="section-title center-align mb-50 text-center">
                <h2><?=translate("XONALARIMIZ")?></h2>
                <h3><?=str_replace("{day}", $days, translate("{day} kun uchun"))?></h3>
            </div>
                
                <div class="row">
                    <? foreach ($rooms as $room) {
                        if ($users_count > 3) {
                            echo '<h1 class="text-center text-danger">Maximal odamlar soni 3 tagacha mumkin</h1>';
                            break;
                        }

                        if ($room["id"] == 1 && $users_count > 2) continue;

                        $all_image = json_decode($room["images_id"]);
                        $image = image($all_image[0]);
                        
                        $amount = 0;
                        $price = str_replace(",", "", lng($room["price"]));
                        
                        $price = $price * $days;

                        $amount += $price;

                        switch ($users_count) {
                            case 3:
                                $amount += 250000;
                            break;

                            case 2:
                                $amount += 150000;
                            break;
                        }
                           
                    ?>
                        <div class="col-xl-4 col-md-6">
                            <div class="single-services ser-m mb-30">
                                <div class="services-thumb">
                                    <a class="gallery-link popup-image" href="<?=$url2[0]?>/bron/?room_id=<?=$room["id"]?>&from_date=<?=$_GET["from_date"]?>&to_date=<?=$_GET["to_date"]?>&adults=<?=$_GET["adults"]?>&childs=<?=$_GET["childs"]?>">
                                        <img style="width: 100%; height: 331px; object-fit:cover;" src="<?=$image["file_folder"]?>" alt="img">
                                    </a>
                                </div>
                                <div class="services-content"> 
                                    <div class="day-book">
                                        <ul>
                                            <li><?=number_format($amount, 0, "", ",")?> so'm</li>
                                            <li><a href="<?=$url2[0]?>/bron/?room_id=<?=$room["id"]?>&from_date=<?=$_GET["from_date"]?>&to_date=<?=$_GET["to_date"]?>&adults=<?=$_GET["adults"]?>&childs=<?=$_GET["childs"]?>"><?=lng($home["text_2"])?></a></li>
                                        </ul>
                                    </div>
                                    <h4><a href="<?=$url2[0]?>/bron/?room_id=<?=$room["id"]?>&from_date=<?=$_GET["from_date"]?>&to_date=<?=$_GET["to_date"]?>&adults=<?=$_GET["adults"]?>&childs=<?=$_GET["childs"]?>"><?=lng($room["name"])?></a></h4>    
                                    <p><?=(mb_strlen(lng($room["description"])) > 133 ? mb_substr(lng($room["description"]), 0, 133)."..." : lng($room["description"]))?></p>
                                    <div class="icon">
                                        <ul>
                                            <? if($room["bedroom"]) {?>
                                                <li><img src="../theme/riorelax/img/icon/sve-icon1.png" alt="img"></li>
                                            <? }  
                                            if($room["internet"]) {?>
                                                <li><img src="../theme/riorelax/img/icon/sve-icon2.png" alt="img"></li>
                                            <? } 
                                            if($room["car"]) {?>
                                                <li><img src="../theme/riorelax/img/icon/sve-icon3.png" alt="img"></li>
                                            <? }
                                            if($room["coffe"]) {?>
                                                <li><img src="../theme/riorelax/img/icon/sve-icon4.png" alt="img"></li>
                                            <? }
                                            if($room["breakfast"]) {?>
                                                <li><img src="../theme/riorelax/img/icon/sve-icon5.png" alt="img"></li>
                                            <? }
                                            if($room["swim"]) {?>
                                                <li><img src="../theme/riorelax/img/icon/sve-icon6.png" alt="img"></li>
                                            <? } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <? } ?>
                </div>
            </div>
        </section>
        <!-- room-area-end --> 
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

<?
include "system/scripts.php";
?>

<script>
    $(document).on("click", "#submit", function(){
        var elm = $(this);
        var first_name = $(elm).parents(".section").find("[name='first_name']").val();
        var phone = $(elm).parents(".section").find("[name='phone']").val();
        var message = $(elm).parents(".section").find("[name='message']").val();
        
        console.log(first_name);
        console.log(phone);
        console.log(message);

        $.ajax({
            url: "<?=$url2[0]?>/api",
            type: "POST",
            data: {
                method: "addRequest",
                first_name: first_name,
                phone: phone,
                message: message,
                submit: 'ok'
            },
            dataType: 'json',
            success: function(data) {
                if (data.ok == true) {
                    $(elm).parents(".section").find("*[name='first_name']").attr("disabled", "disabled");
                    $(elm).parents(".section").find("*[name='phone']").attr("disabled", "disabled");
                    $(elm).parents(".section").find("*[name='message']").attr("disabled", "disabled");
                    $(elm).parents(".section").find("#submit").text("Yetkazildi").attr("onclick", "return false;");
                } else {
                    alert("Xatolik - " + data.error );
                }
            }
        })
    })

    var lang = getCookieValue("lang");
    if(!lang) {
        $(".modal_container").removeClass("d-none");
        $(".bg-blur").removeClass("d-none");
    } else {
        $(".modal_container").addClass("d-none");
        $(".bg-blur").addClass("d-none");
    }

    $(".language_item").on("click", function () {
        var fName = $(this).attr('data-flag');
        window.history.pushState('title', 'Title', '/'+fName+'/');
        setCookie("lang", fName, 3);
        $(".modal_container").addClass("d-none");
        $(".bg-blur").addClass("d-none");
    })

</script>

<?
include "system/end.php";
?>