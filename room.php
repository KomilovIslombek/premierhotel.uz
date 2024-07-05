<?
$is_config = true;
if (empty($load_defined)) include 'load.php';

// if (isAuth() === false) {
//     header("Location: /login");
//     exit;
// }

if(!$url[1]) exit("id topilmadi");
$roomId = $url[1];
$home = $db->assoc("SELECT * FROM home");
$room = $db->assoc("SELECT * FROM rooms WHERE id = ?", [ $roomId ]);
$images = json_decode($room["images_id"]);
$roomImage = image($images[0]);
// $roomImage = image($room["image_id"]);
// $roomImage2 = image($room["image_id2"]);
// $roomImage3 = image($room["image_id3"]);

include "system/head.php";
$roomBanner = image($home["image_id4"]);
?>

<style>
    .course__wrapper img {
        max-width: 100%;
    }

    .swiper-container {
        width: 100%;
        height: 100%;
    }

    .swiper-slide {
        text-align: center;
        font-size: 18px;
        background: #fff;

        /* Center slide text vertically */
        display: -webkit-box;
        display: -ms-flexbox;
        display: -webkit-flex;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        -webkit-justify-content: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        -webkit-align-items: center;
        align-items: center;
    }

    .swiper-slide img {
        width: 100%;
    }

    .gallery-thumbs {
        margin-top: 10px;
    }
</style>

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
                            <h2><?=lng($room["name"])?></h2>
                            <div class="breadcrumb-wrap">

                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a
                                                href="/<?=$url2[0]?>/"><?=translate("Bosh sahifa")?></a></li>
                                        <li class="breadcrumb-item active" aria-current="page">
                                            <?=translate("Xona tafsilotlari")?></li>
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
    <!-- service-details-area -->
    <div class="about-area5 about-p p-relative">
        <div class="container pt-120 pb-40">
            <div class="row">
                <!-- #right side -->
                <div class="col-sm-12 col-md-12 col-lg-4 order-2">
                    <aside class="sidebar services-sidebar">

                        <!-- Category Widget -->
                        <div class="sidebar-widget categories">
                            <div class="widget-content">
                                <h2 class="widget-title"> <?=lng($home["text_30"])?> </h2>
                                <!-- Services Category -->
                                <!-- booking-area -->
                                <div class="booking">
                                    <div class="contact-bg">
                                        <form action="/bron" method="GET" class="contact-form mt-30">
                                            <input type="hidden" name="room_id" value="<?=$room["id"]?>">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="contact-field p-relative c-name mb-20">
                                                        <label><i class="fal fa-badge-check"></i>
                                                            <?=lng($home["text_5"])?></label>
                                                        <input type="date" id="chackin" name="from_date">
                                                    </div>
                                                </div>

                                                <div class="col-lg-12">
                                                    <div class="contact-field p-relative c-subject mb-20">
                                                        <label><i class="fal fa-times-octagon"></i>
                                                            <?=lng($home["text_6"])?></label>
                                                        <input type="date" id="chackout" name="to_date">
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="contact-field p-relative c-subject mb-20">
                                                        <label><i class="fal fa-users"></i>
                                                            <?=lng($home["text_7"])?></label>
                                                        <select name="adults" id="adu">
                                                            <option value="sports-massage"><?=translate("soni")?>
                                                            </option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <?=($room["id"] != 1 ? '<option value="3">3</option>' : '')?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="contact-field p-relative c-option mb-20">
                                                        <label><i class="fal fa-child"></i>

                                                            <?=lng($home["text_8"])?></label>
                                                        <select name="childs" id="rm">
                                                            <option value=""><?=translate("soni")?></option>
                                                            <option value="1">1</option>
                                                            <option value="2">2</option>
                                                            <?=($room["id"] != 1 ? '<option value="3">3</option>' : '')?>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-lg-12">
                                                    <div class="slider-btn mt-15">
                                                        <button class="btn ss-btn" data-animation="fadeInRight"
                                                            data-delay=".8s"><span><?=lng($home["text_2"])?></span></button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- booking-area-end -->
                            </div>
                        </div>
                        <!--Service Contact-->
                        <div class="service-detail-contact wow fadeup-animation" data-wow-delay="1.1s">
                            <h3 class="h3-title"><?=translate("Agar sizga yordam kerak bo'lsa, biz bilan bog'laning")?>
                            </h3>
                            <a href="tel:<?=trim(str_replace("-", "", $home["text_40"]), "+")?>" title="Hoziroq qong'iroq qilish"  style="font-size:34px;"><?=str_replace("", "",str_replace("-", " ", $home["text_40"]))?></a>
                        </div>

                    </aside>
                </div>
                <!-- #right side end -->


                <div class="col-lg-8 col-md-12 col-sm-12 order-1">
                    <div class="service-detail" style="margin-top: -23px;">
                        <div class="course__wrapper">
                            <h2 class="text-dark text-center mb-4"><?=lng($roomImage["name"])?></h2>
                            <div class="swiper-container gallery-top" >
                                <div class="swiper-wrapper" >
                                    <? foreach ($images as $image) { 
                                        $myImage = image($image);    
                                    ?>
                                        <div class="swiper-slide">
                                            <img src="<?=$myImage["file_folder"]?>" alt="">
                                        </div>
                                    <? } ?>
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                            <div class="swiper-container gallery-thumbs">
                                <div class="swiper-wrapper">
                                    <? foreach ($images as $image) { 
                                        $myImage = image($image);    
                                    ?>
                                        <div class="swiper-slide">
                                            <img src="<?=$myImage["file_folder"]?>" alt="">
                                        </div>
                                    <? } ?>
                                </div>
                            </div>
                        </div>

                        <div style="margin-top: 55px;" class="content-box">
                            <div class="row align-items-center mb-50">
                                <div class="col-lg-6 col-md-6">
                                    <div class="price">
                                        <h2><?=lng($room["name"])?></h2>
                                        <span> <?=lng($room["price"])?> so'm</span>
                                        <!-- <span> <?=$url2[0] == 'en' || $url2[0] == 'ru' ? translate("so'm") : ''?><?=lng($room["price"])?> <?=$url2[0] == 'uz' ? translate("so'm") : ''?></span> -->
                                    </div>
                                </div>
                            </div>



                            <p><?=lng($room["description"])?></p>
                            <h3><?=translate("Xonaning xususiyati")?>.</h3>
                            <ul class="room-features d-flex align-items-center">
                                <? if($room["tv"]) {?>
                                    <li>
                                        <i class="fal fa-tv-retro"></i> <?=translate($room["tv"])?>
                                    </li>
                                <? } ?>
                                <? if($room["internet"]) {?>
                                    <li>
                                        <i class="fal fa-wifi"></i> <?=translate("Bepul Wi-Fi")?>
                                    </li>
                                <? } ?>
                                <? if($room["air"]) {?>
                                    <li>
                                        <i class="fal fa-air-conditioner"></i> <?=translate("Konditsioner")?>
                                    </li>
                                <? } ?>
                                <? if($room["heater"]) {?>
                                    <li>
                                        <i class="fal fa-dumpster-fire"></i> <?=translate("Mikroto'lqinli pech")?>
                                    </li>
                                <? } ?>
                                <? if($room["phone"]) {?>
                                    <li>
                                        <i class="fal fa-phone-rotary"></i> <?=translate("Telefon")?>
                                    </li>
                                <? } ?>
                                <? if($room["laundry"]) {?>
                                    <li>
                                        <i class="fal fa-dryer-alt"></i> <?=translate("Kir yuvish")?>
                                    </li>
                                <? } ?>
                                <? if ($room["adults"]) { ?>
                                    <li>
                                        <i class="fal fa-user"></i> <?=translate("Kattalar")?>: <?=$room["adults"]?>
                                    </li>
                                <? } ?>
                                <? if ($room["size"]) { ?>
                                    <li>
                                        <i class="fal fa-square"></i> <?=translate("Hajmi")?>:
                                        <?=$room["size"]?><?=translate("m")?>
                                    </li>
                                <? } ?>
                                <? if ($room["bed"]) { ?>
                                    <li>
                                        <i class="fal fa-bed"></i> <?=translate("Yotoq turi")?>: <?=$room["bed"]?>
                                        <?=translate("yotoq")?>
                                    </li>
                                <? } ?>

                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- service-details-area-end -->

</main>
<!-- main-area-end -->

<?
include "system/scripts.php";
?>


<script>
    $(".course__wrapper").find("img").each(function(){
        $(this).removeAttr("width").removeAttr("height");
    });

    var galleryThumbs = new Swiper('.gallery-thumbs', {
        autoHeight: true,
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
    });
    var galleryTop = new Swiper('.gallery-top', {
        autoHeight: true,
        spaceBetween: 10,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        thumbs: {
            swiper: galleryThumbs
        }
    });
</script>

<?
include "system/end.php";
?>