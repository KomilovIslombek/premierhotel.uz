<?
$is_config = true;
if (empty($load_defined)) include 'load.php';

// if (isAuth() === false) {
//     header("Location: /login");
//     exit;
// }


$home = $db->assoc("SELECT * FROM home");
$home_image_1 = image($home["image_id"]);
$home_image_2 = image($home["image_id2"]);
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


include "system/head.php";

?>
      
   <!-- main-area -->
    <main>
        <!-- slider-area -->
        <section id="home" class="slider-area fix p-relative">
            
            <div class="slider-active" style="background: #101010;">

                <? foreach ($mainBanners as $mainBanner) {
                    $image = image($mainBanner["image_id"]);
                ?>
                    <div class="single-slider slider-bg d-flex align-items-center" style="background-image: url(<?=$image['file_folder']?>); background-size: cover; ">
                        <div class="container">
                            <div class="row justify-content-center align-items-center">
                                
                                <div class="col-lg-7 col-md-7">
                                    <div class="slider-content s-slider-content mt-80 text-center">
                                            <h2 data-animation="fadeInUp" data-delay=".4s"><?=lng($mainBanner["title"])?></h2>
                                            <p data-animation="fadeInUp" data-delay=".6s"><?=$mainBanner["sub_title"] ? lng($mainBanner["sub_title"]) : ''?></p>
                                            <div class="slider-btn mt-30 mb-105">    
                                                <!-- <a href="" class="btn ss-btn active mr-15" data-animation="fadeInLeft" data-delay=".4s"><?=lng($home["text_3"])?> </a> -->
                                                <? if($mainBanner["youtube_link"]) { ?> 
                                                    <a href="https://www.youtube.com/watch?v=<?=$mainBanner["youtube_link"]?>" class="video-i popup-video" data-animation="fadeInUp" data-delay=".8s" style="animation-delay: 0.8s;" tabindex="0"><i class="fas fa-play"></i><?=lng($home["text_4"])?> </a>
                                                <? } ?>
                                        </div>        
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                <? } ?>
            </div>
                
            
        </section>
        <!-- slider-area-end -->
        <!-- booking-area -->
        <div id="mini-booking" class="booking-area p-relative">
            <div class="container">
                <form action="/rooms" method="GET" class="contact-form" >
                    <div class="row align-items-center">
                        <div class="col-lg-12"> 
                            <ul>
                                <li> 
                                    <div class="contact-field p-relative c-name">  
                                        <label><i class="fal fa-badge-check"></i><?=lng($home["text_5"])?></label>
                                        <input required type="date" id="chackin" name="from_date">
                                    </div>      
                                </li>
                                <li> 
                                    <div class="contact-field p-relative c-name">  
                                        <label><i class="fal fa-times-octagon"></i> <?=lng($home["text_6"])?></label>
                                        <input required type="date" id="chackout" name="to_date">
                                    </div>      
                                </li>
                                    <li> 
                                    <div class="contact-field p-relative c-name">  
                                        <label><i class="fal fa-users"></i> <?=lng($home["text_7"])?></label>
                                        <select name="adults" id="adu">
                                            <option value=""><?=translate("soni")?></option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                    </div>      
                                </li>
                                    <li> 
                                    <div class="contact-field p-relative c-name">  
                                            <label><i class="fal fa-baby"></i> <?=lng($home["text_8"])?></label>
                                        <select name="childs" id="cld">
                                            <option value=""><?=translate("soni")?></option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                    </div>      
                                </li>
                                
                                <li>
                                    <div class="slider-btn">    
                                        <label><i class="fal fa-calendar-alt"></i></label>
                                    <button class="btn ss-btn" data-animation="fadeInRight" data-delay=".8s"><?=lng($home["text_2"])?></button>
                                </div>     
                                </li>
                            </ul>
                        </div>
                    
                    </div>
                </form>
            </div>
        </div>
        <!-- booking-area-end -->
        <!-- about-area -->
        <section id="about" class="about-area about-p pt-120 pb-50 p-relative fix">
            <div class="animations-02"><img src="../theme/riorelax/img/bg/an-img-02.png" alt="contact-bg-an-02"></div>
            <div class="container">
                <div class="row justify-content-center align-items-center">
                        <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="s-about-img p-relative  wow fadeInLeft animated" data-animation="fadeInLeft" data-delay=".4s">
                            <img src="<?=$home_image_1["file_folder"]?>" alt="img">   
                            <div class="about-icon">
                                <img src="<?=$home_image_2["file_folder"]?>" alt="img">   
                            </div>
                        </div>
                        
                    </div>
                    
                <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="about-content s-about-content  wow fadeInRight animated pl-30" data-animation="fadeInRight" data-delay=".4s">
                            <div class="about-title second-title pb-25">  
                                <h5><?=lng($home["text_10"])?></h5>
                                <h2><?=lng($home["text_11"])?></h2>                                   
                            </div>
                                <p><?=lng($home["text_12"])?></p>
                                <p><?=lng($home["text_13"])?></p>
                                <div class="about-content3 mt-30">
                                <div class="row justify-content-center align-items-center">
                                    <div class="col-md-12">
                                        <? if (lng($home["text_14"]) || lng($home["text_15"]) || lng($home["text_16"])) { ?>
                                            <ul class="green mb-30">                                              
                                                <? if ($home["text_14"]) { ?>
                                                    <li> <?=lng($home["text_14"])?></li>
                                                <? } ?>
                                                <? if ($home["text_15"]) { ?>
                                                    <li> <?=lng($home["text_15"])?></li>     
                                                <? } ?>
                                                <? if ($home["text_16"]) { ?>
                                                    <li> <?=lng($home["text_16"])?></li>
                                                <? } ?>
                                            </ul>
                                        <? } ?>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="slider-btn">                                          
                                            <a href="<?=$url2[0]?>/#booking" class="btn ss-btn smoth-scroll"><?=lng($home["text_2"])?></a>				
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- about-area-end -->

        <!-- room-area-->
        <section id="rooms" class="services-area pt-113 pb-130">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-xl-12">    
                        <div class="section-title center-align mb-50 text-center">
                            <? if ($home["text_21"]) { ?>
                                <h5><?=lng($home["text_21"])?></h5>
                            <? } ?>
                            <? if ($home["text_22"]) { ?>
                                <h2><?=lng($home["text_22"])?></h2>
                            <? } ?>
                            <? if ($home["text_23"]) { ?>
                                <p><?=lng($home["text_23"])?></p>
                            <? } ?>
                        </div>
                    </div>
                </div>
                <div class="row class-active">
                    <? foreach ($rooms as $room) {
                        $all_image = json_decode($room["images_id"]);
                        $image = image($all_image[0]);
                    ?>
                        <div class="col-xl-4 col-md-6">
                            <div class="single-services mb-30" style="min-height: 627px;">
                                <div class="services-thumb">
                                    <!-- <a class="gallery-link popup-image" href="<?=$image["file_folder"]?>"> -->
                                    <a href="<?=$url2[0]?>/room/<?=$room["id"]?>">
                                        <img style="width: 100%; height: 331px; object-fit:cover;" src="<?=$image["file_folder"]?>" alt="img">
                                    </a>
                                </div>
                                <div class="services-content"> 
                                    <div class="day-book">
                                        <ul>
                                            <li><?=lng($room["price"])?> so'm</li>
                                            <!-- <li><?=$url2[0] != 'uz' ? translate("so'm") : ''?><?=lng($room["price"])?> <?=$url2[0] == 'uz' ? translate("so'm") : ''?></li> -->
                                            <li><a href="<?=$url2[0]?>/room/<?=$room["id"]?>"><?=lng($home["text_2"])?></a></li>
                                        </ul>
                                    </div>
                                    <h4><a href="<?=$url2[0]?>/room/<?=$room["id"]?>"><?=lng($room["name"])?></a></h4>    
                                    <p><?=(mb_strlen(lng($room["description"])) > 133 ? mb_substr(lng($room["description"]), 0, 133)."..." : lng($room["description"]))?></p>
                                    <!-- <p><?=(mb_strlen(lng($room["description"])) > 60 ? mb_substr(lng($room["description"]), 0, 60)."..." : lng($room["description"]))?></p> -->
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
        <!-- service-details2-area -->
        <section id="advantages" class="pt-120 pb-90 p-relative" style="background-color: #f7f5f1;">
            <div class="animations-01"><img src="../theme/riorelax/img/bg/an-img-01.png" alt="an-img-01"></div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-12">
                        <div class="section-title center-align mb-50 text-center">
                            <h5><?=lng($home["text_18"]) ? lng($home["text_18"]) : ''?></h5>
                            <h2 class="text-uppercase">
                                <?=lng($home["text_19"])?>
                            </h2>
                            <p><?=lng($home["text_20"]) ? lng($home["text_20"]) : ''?></p>
                        </div>
                        
                    </div>
                    <? foreach ($advantages as $advantage) {
                        $count += 1;
                        $advantage_image = image($advantage["image_id"]);
                    ?>
                        <div class="col-lg-4 col-md-6">
                            <div class="services-08-item mb-30">
                                <div class="services-icon2">
                                    <img src="<?=$advantage_image["file_folder"]?>" alt="img">
                                </div>
                                <div class="services-08-thumb">
                                    <img src="<?=$advantage_image["file_folder"]?>" alt="img">
                                </div>
                                <div class="services-08-content">
                                    <h3><a href="<?=($count == 1 && $advantage["btn_link"] ? $url2[0].'/'.$advantage["btn_link"] : 'javascript:void(0)')?>"> <?=lng($advantage["name"])?></a></h3>
                                    <p><?=lng($advantage["description"])?></p>
                                    <!-- <a href="<?=($count == 1 && $advantage["btn_link"] ? $url2[0].'/'.$advantage["btn_link"] : 'javascript:void(0)')?>"><?=lng($advantage["btn_name"])?> <i class="fal fa-long-arrow-right"></i></a> -->
                                </div>
                            </div>
                        </div>
                    <? } ?>
                </div>
                <hr>
                <h1><?=lng($home["text_54"])?> </h1>
                <div class="row mt-4">
                    <div class="col-lg-4 col-md-6">
                        <? foreach ($featuredParts[0] as $featured0) {
                            $image = image($featured0["image_id"]);
                        ?>
                            <div class="d-flex my-2">
                                <div class="d-flex me-1">
                                    <img width="20px" height="20px" style="width: 20px; height: 20px; object-fit:contain;" class="me-2" src="<?=$image["file_folder"]?>" alt="icon">
                                    <h5><?=lng($featured0["name"])?></h5>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <? foreach ($featuredParts[1] as $featured1) {
                            $image = image($featured1["image_id"]);
                        ?>
                            <div class="d-flex my-2">
                                <div class="d-flex me-1">
                                    <img width="20px" height="20px" style="width: 20px; height: 20px; object-fit:contain;" class="me-2" src="<?=$image["file_folder"]?>" alt="icon">
                                    <h5><?=lng($featured1["name"])?></h5>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <? foreach ($featuredParts[2] as $featured2) {
                            $image = image($featured2["image_id"]);
                        ?>
                            <div class="d-flex my-2">
                                <div class="d-flex me-1">
                                    <img width="20px" height="20px" style="width: 20px; height: 20px; object-fit:contain;" class="me-2" src="<?=$image["file_folder"]?>" alt="icon">
                                    <h5><?=lng($featured2["name"])?></h5>
                                </div>
                            </div>
                        <? } ?>
                    </div>
                </div>
                <hr>
                <h1><?=lng($home["text_53"])?> </h1>
                <div class="row mt-5">
                    <div class="col-lg-4 col-md-6">
                        <? foreach ($info as $info1) {
                            if(mb_strlen(lng($info1["description"])) <= 10) {
                                $image = image($info1["image_id"]);
                        ?>
                                <div class="d-flex my-2">
                                    <div class="d-flex me-1">
                                        <img width="20px" height="20px" style="width: 20px; height: 20px; object-fit:contain;" class="me-2" src="<?=$image["file_folder"]?>" alt="icon">
                                        <h5><?=lng($info1["name"])?> <?=lng($info1["description"]) ? ':' : '' ?></h5>
                                    </div>
                                    <span><?=lng($info1["description"])?></span>
                                </div>
                        <?}
                        }
                        ?>
                    </div>
                    <div class="col-lg-4 col-md-6 ">
                        <? foreach ($info as $info2) {
                            if(mb_strlen(lng($info2["description"])) > 60) {
                                $image2 = image($info2["image_id"]);
                        ?>
                                <!-- <div class="d-flex my-2"> -->
                                    <div class="d-flex me-1">
                                        <img width="20px" height="20px" style="width: 20px; height: 20px; object-fit:contain;" class="me-2" src="<?=$image2["file_folder"]?>" alt="icon">
                                        <h5><?=lng($info2["name"])?></h5>
                                    </div>
                                <!-- </div> -->
                                <p class="ms-4"><?=lng($info2["description"])?></p>
                        <?}
                        }
                        ?>
                    </div>
                    <div class="col-lg-4 col-md-6 ">
                        <? foreach ($info as $info3) {
                            if(mb_strlen(lng($info3["description"])) > 8 && mb_strlen(lng($info3["description"])) < 60) {
                                $image2 = image($info3["image_id"]);
                        ?>
                                <!-- <div class="d-flex my-2"> -->
                                    <div class="d-flex me-1">
                                        <img width="20px" height="20px" style="width: 20px; height: 20px; object-fit:contain;" class="me-2" src="<?=$image2["file_folder"]?>" alt="icon">
                                        <h5><?=lng($info3["name"])?></h5>
                                    </div>
                                <!-- </div> -->
                                <p class="ms-4"><?=lng($info3["description"])?></p>
                        <?}
                        }
                        ?>
                    </div>
                </div>
            </div>
            </div>
        </section>
        <!-- service-details2-area-end -->
        <!-- pr  -->
        <div id="comparison"></div>
        <section class="pt-40 pb-110">
            <div class="container">
                <div class="row section-title  mb-50">
                    <h2 class="bedroom_title  text-uppercase"><?=lng($home["text_24"])?></h2>
                </div>
                <div class="col my-4 my-md-1 table-responsive">
                    <table class="table table-hover table-responsive overflow-scroll">
                    <thead>
                        <tr style="background-color: #644222; color:white;">
                            <th scope="col">№</th>
                            <th scope="col"><?=lng($home["text_25"])?></th>
                            <? foreach ($rooms as $room) { ?>
                                <th scope="col" class="table_apart"><?=lng($room["name"])?></th>
                            <? } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach($services as $service) { ?>
                            <tr>
                                <td><?=$service["id"]?></td>
                                <td><?=lng($service["name"])?></td>
                                <? foreach ($rooms as $room) { ?>
                                    <? if ($room["services"] && in_array($service["id"], json_decode($room["services"]))) { ?>
                                        <td>+</td>
                                    <? } else { ?>
                                        <td>-</td>
                                    <? } ?>
                                <? } ?>
                            </tr>
                        <? } ?>
                        </tr>
                    </tbody>
                    </table>
                </div>
                <div class="row mt-5 justify-content-evenly">
                    <div class="col-xl-4 col-md-12"> 
                        <div class="back_img mx-xs-auto mx-sm-auto mx-md-auto ">
                            <i style="color: #be9874; font-size: 40px; " class="fal fa-user"></i>
                        </div>       
                        <h3 class="stat_footer_title text-uppercase my-4 text-sm-center text-md-center text-xs-center">
                            <?=lng($home["text_31"])?>
                        </h3>
                        <div class="stat_footer_nums d-flex justify-content-between flex-wrap ">
                            <div class="stat_footer_num">
                                <h2 style="color:#be9874;" class="stat_footer_num_t text-uppercase text-md-center text-sm-center">
                                    <?=$home["text_33"]?>
                                </h2>
                                <h3 class="stat_footer_num_sb text-uppercase">
                                    <?=lng($home["text_9"])?>
                                </h3>
                            </div>
                            <div class="stat_footer_num">
                                <h2 style="color:#be9874;" class="stat_footer_num_t text-uppercase text-md-center text-sm-center">
                                    <?=lng($home["text_34"])?>
                                </h2>
                                <h3 class="stat_footer_num_sb text-uppercase">
                                    <?=translate("Mehmonlar")?>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-12 ms-xl-5 mt-md-5 mt-lg-0 mt-xl-0"> 
                        <div class="back_img mx-md-auto mx-sm-auto mx-xs-auto">
                            <img class="img" style="width: 50px; height: 50px; object-fit:contain;" src="./theme/riorelax/img/icon/sve-icon3Color.png">
                        </div>       
                        <h3 class="stat_footer_title text-sm-center text-md-center text-uppercase my-4 text-xs-center">
                            <?=lng($home["text_32"])?>
                        </h3>
                        <div class="stat_footer_nums d-flex justify-content-between flex-wrap">
                            <div class="stat_footer_num">
                                <h2 style="color:#be9874;" class="stat_footer_num_t text-uppercase text-md-center text-sm-center">
                                <?=$home["text_35"]?> <?=mb_strlen($home["text_35"]) > 2 ? lng("m") : lng("km")?>
                                </h2>
                                <h3 class="stat_footer_num_sb text-uppercase">
                                <?=translate("Vokzaldan")?>
                                </h3>
                            </div>
                            <div class="stat_footer_num text-right">
                                <h2 style="color:#be9874;" class="stat_footer_num_t text-uppercase text-md-center text-sm-center">
                                <?=$home["text_36"]?> <?=mb_strlen($home["text_36"]) > 2 ? lng("m") : lng("km")?>
                                </h2>
                                <h3 class="stat_footer_num_sb text-uppercase">
                                <?=translate("Masjidan")?>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- feature-area -->
        <section id="contacts" class="feature-area2 p-relative fix section" style="background: #f7f5f1;">
                <div class="animations-02"><img src="../theme/riorelax/img/bg/an-img-02.png" alt="contact-bg-an-05"></div>
            <div class="container">
                <div class="row justify-content-center align-items-center">
                        <div class="col-lg-6 col-md-12 col-sm-12 pr-30">
                        <div class="feature-img">                               
                            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d480.1668208569863!2d72.35444555474245!3d40.76289433315039!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e1!3m2!1suz!2s!4v1679908127865!5m2!1suz!2s" width="600" height="635" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                            <!-- <img src="../theme/riorelax/img/features/feature.png" alt="img" class="img">               -->
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 col-sm-12">
                        <div class="feature-content s-about-content">
                            <div class="feature-title pb-20">                               
                                <!-- <h5>Luxury Hotel & Resort</h5> -->
                            <h2 style="text-transform: upparcase;"> 
                                <?=lng($home["text_26"])?>
                            </h2>                             
                            </div>
                            <p><?=lng($home["text_27"])?></p>
                            <div class="row">
                                <div class="col-6 l_change">
                                    <div class="contact-field p-relative c-name mb-20">                                    
                                        <input name="first_name" id="firstn" required type="text" class="form-control" placeholder="<?=translate("Ismingiz")?> :" required="">
                                    </div>   
                                </div>
                                <div class="col-6 r_change">
                                    <div class="contact-field p-relative c-name mb-20">                                    
                                        <input name="phone" class="form-control" id="phone-mask" placeholder="Telefon raqamingiz :"  required="">
                                    </div>                                                                               
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="contact-field p-relative c-message mb-30">                                  
                                    <textarea name="message" id="message" cols="30" rows="10" required="" placeholder="<?=translate("Izoh")?> :"></textarea>
                                </div>
                            </div>
                            <div class="slider-btn mt-9">      
                                <button id="submit" class="btn btn-success smoth-scroll w-100 mover-img"><?=lng($home["text_28"])?></button>
                            </div>
                            
                        </div>
                    </div>
                    
                    
                </div>
            </div>
        </section>
        <!-- feature-area-end -->
        
        <!-- booking-area -->
        <section id="booking" class="booking pt-120 pb-120 p-relative fix">
            <div class="animations-01"><img src="../theme/riorelax/img/bg/an-img-01.png" alt="an-img-01"></div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6">
                            <div class="contact-bg02">
                            <div class="section-title center-align">
                                <h5><?=lng($home["text_29"])?></h5>
                                <h2>
                                    <?=lng($home["text_30"])?>
                                </h2>
                            </div>                                
                            <form action="/rooms" method="GET" class="contact-form mt-30">
                                <div class="row">
                                <div class="col-lg-6 col-md-6">
                                    <div class="contact-field p-relative c-name mb-20">                                    
                                        <label><i class="fal fa-badge-check"></i> <?=lng($home["text_5"])?></label>
                                            <input required type="date" id="chackin2" name="from_date">
                                    </div>                               
                                </div>

                                <div class="col-lg-6 col-md-6">                               
                                    <div class="contact-field p-relative c-subject mb-20">                                   
                                        <label><i class="fal fa-times-octagon"></i> <?=lng($home["text_6"])?></label>
                                                    <input required type="date" id="chackout2" name="to_date">
                                    </div>
                                </div>		
                                <div class="col-lg-6 col-md-6">                               
                                    <div class="contact-field p-relative c-subject mb-20">                                   
                                            <label><i class="fal fa-users"></i> <?=lng($home["text_7"])?></label>
                                            <select required name="adults" id="adu2">
                                                <option value=""><?=translate("soni")?></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                    </div>
                                </div>	
                                <div class="col-lg-6 col-md-6">                               
                                    <div class="contact-field p-relative c-option mb-20">                                   
                                        <label><i class="fal fa-baby"></i> <?=lng($home["text_8"])?></label>
                                            <select name="childs" id="rm2">
                                                <option value=""> <?=translate("soni")?></option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                            </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="slider-btn mt-15">                                          
                                        <button class="btn ss-btn" data-animation="fadeInRight" data-delay=".8s"><span><?=lng($home["text_2"])?></span></button>				
                                    </div>                             
                                </div>
                                </div>
                        </form>                            
                        </div>  
                                            
                    </div>
                    <div class="col-lg-6 col-md-6">
                            <div class="booking-img">
                                <img src="<?=$image3["file_folder"]?>" alt="img">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- booking-area-end -->	
        <!-- pricing-area -->
        <section id="pricing" class="pricing-area pt-30 pb-60 fix p-relative">
            <div class="animations-01"><img src="../theme/riorelax/img/bg/an-img-01.png" alt="an-img-01"></div>
            <div class="animations-02"><img src="../theme/riorelax/img/bg/an-img-02.png" alt="contact-bg-an-01"></div>
            <div class="container"> 
                <div class="row section-title mb-30">
                    <h2 class="bedroom_title text-center text-uppercase"><?=translate("Galereya")?></h2>
                </div>
                <div class="row justify-content-center align-items-center flex-wrap">
                    <? foreach ($gallery_images as $gallery_image) {
                            $gallery = image($gallery_image["image_id"]);
                    ?>
                        <img style="width: 400px; height: 400px; object-fit:cover; margin-top: 20px;" src="<?=$gallery["file_folder"]?>" alt="">
                    <? } ?>
                </div>
            </div>
        </section>
        <!-- pricing-area-end -->
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