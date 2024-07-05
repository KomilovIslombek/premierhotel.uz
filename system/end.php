<!-- footer -->
    <footer class="footer-bg footer-p">
        <div class="footer-top  pt-90 pb-40" style="background-color: #644222; background-image: url(../theme/riorelax/img/bg/footer-bg.png);">
            <div class="container">
                <div class="row justify-content-between">
                    <div class="col-xl-4 col-lg-4 col-sm-6">
                        <div class="footer-widget mb-30">
                            <div class="f-widget-title mb-30">
                                <img src="../theme/riorelax/img/logo/p-logo.png" alt="img">
                            </div>
                            <div class="f-contact">
                                <ul>
                                <li>
                                    <i class="icon fal fa-phone"></i>
                                    <span><?=str_replace("-", " ", $home["text_41"])?></span>
                                    <br>
                                    <span><?=str_replace("-", " ", $home["text_45"])?></span>
                                </li>
                                <li><i class="icon fal fa-envelope"></i>
                                    <span>
                                        <a href="mailto:<?=$home["text_42"]?>"><?=$home["text_42"]?></a>
                                    <br>
                                    <a href="mailto:<?=$home["text_43"]?>"><?=$home["text_43"]?></a>
                                    </span>
                                </li>
                                <li>
                                    <i class="icon fal fa-map-marker-check"></i>
                                    <span style="white-space: break-spaces"><?=lng($home["text_44"])?></span>
                                </li>
                                
                            </ul>
                                
                                </div>
                        </div>
                    </div>
                    <div class="text-sm-center text-md-center text-lg-center text-xl-center text-xxl-center col-xl-3 col-lg-3 col-sm-6">
                        <div class="footer-widget mb-30">
                            <div class="f-widget-title text-uppercase">
                                <h2><?=lng($home["text_37"])?></h2>
                            </div>
                            <div class="footer-link">
                                <ul class="">                                        
                                    <li><a href="<?=$url2[0]?>/#advantages" style="text-transform:uppercase;"><?=lng($home["text_19"])?></a></li>
                                    <li><a href="<?=$url2[0]?>/#about" style="text-transform:uppercase;"><?=lng($home["text_10"])?></a></li>        
                                    <li><a href="<?=$url2[0]?>/#rooms" style="text-transform:uppercase;"><?=lng($home["text_9"])?></a></li>
                                    <li><a href="<?=$url2[0]?>/#comparison" style="text-transform:uppercase;"><?=translate("Taqqoslash")?></a></li>
                                    <li><a href="<?=$url2[0]?>/#contacts" style="text-transform:uppercase;"><?=translate("Kontaktlar")?></a></li>                                               
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="text-md-start text-lg-end text-xl-end text-xxl-end col-xl-4 col-lg-4 col-sm-12">
                        <div class="footer-widget mb-30">
                            <div class="f-widget-title">
                                <h2 style="text-transform:uppercase; padding-bottom: 20px;"><?=lng($home["text_38"])?>:</h2>
                            </div>
                            <div class="footer-link">
                                <div class="subricbe p-relative " data-animation="fadeInDown" data-delay=".4s" >
                                    <p style="font-size: 21px;" class="text-white">
                                        <?=trim(str_replace("\n", "<br>", $home["text_1"]))?>
                                    </p> 
                                </div>
                            </div>
                            
                        </div>
                        <div class="footer-widget ">
                            <div class="f-widget-title">
                                <h2 style="text-transform:uppercase; padding-bottom: 20px;"><?=lng($home["text_39"])?>:</h2>
                            </div>
                            <div class="footer-link">
                                <div class="subricbe p-relative " data-animation="fadeInDown" data-delay=".4s" >
                                    <p style="font-size: 21px;" class="fs-16 text-white">
                                        <a href="tel:<?=trim(str_replace("-", "", $home["text_40"]), "+")?>"><?=str_replace("-", " ", $home["text_40"])?></a>
                                    </p> 
                                </div>
                            </div>
                        </div>
                        <div class="col-6 float-md-none float-lg-end float-xl-end float-xxl-end">
                            <a href="<?=$url2[0]?>/#booking" class="top-btn mt-10 mb-10"><?=lng($home["text_2"])?> </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyright-wrap">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6">
                        <p>
                            <? if($url2[0] == "uz") {
                                echo '© <a class="text-white" href="https://startapp.uz/" target="_blank">StartApp.uz</a> Jamoasi tomonidan ishlab chiqilgan';
                            } else if($url2[0] == "ru") {
                                echo '© Разработала команда <a class="text-white" href="https://startapp.uz/" target="_blank">StartApp.uz</a>';
                            } else {
                                echo '© Developed by the <a class="text-white" href="https://startapp.uz/" target="_blank">StartApp.uz</a> team';
                            }?>
                        </p>
                    </div>
                    <div class="col-lg-6 col-md-6 text-right text-xl-right">                       
                        <div class="footer-social">                                    
                            <? if($home["text_46"]) {?>
                                <a href="<?=$home["text_46"]?>"><i class="fab fa-twitter"></i></a>
                            <? } ?>
                            <? if($home["text_47"]) {?>
                                <a href="<?=$home["text_47"]?>"><i class="fab fa-instagram"></i></a>
                            <? } ?>
                            <? if($home["text_48"]) {?>
                                <a href="<?=$home["text_48"]?>"><i class="fab fa-facebook-f"></i></a>
                            <? } ?>
                            <? if($home["text_49"]) {?>
                                <a href="<?=$home["text_49"]?>"><i class="fab fa-youtube"></i></a>
                            <? } ?>
                            <? if($home["text_50"]) {?>
                                <a href="<?=$home["text_50"]?>"><i class="fab fa-telegram"></i></a>
                            <? } ?>

                            </div>        
                    </div>
                    
                </div>
            </div>
        </div>
    </footer>
<!-- footer-end -->

<script>
    $("#phone-mask").on("input keyup", function(e){
        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,2})(\d{0,3})(\d{0,2})(\d{0,2})/);
        // console.log(x);
        e.target.value = !x[2] ? '+' + (x[1].length == 3 ? x[1] : '998') : '+' + x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '') + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '');
    });

    $("#phone-mask").keyup();
</script>

</body>
</html>