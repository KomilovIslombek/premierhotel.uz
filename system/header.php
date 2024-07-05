<!-- header -->
<header class="header-area header-three">  
    <div class="header-top second-header d-none d-md-block">
        <div class="container">
            <div class="row align-items-center">      
                <div class="col-lg-10 col-md-10 d-none d-lg-block">
                        <div class="header-cta">
                        <ul>                                   
                            <!-- <li>
                                <i class="far fa-clock"></i>
                                <span>Mon - Fri: 9:00 - 19:00/ Closed on Weekends</span>
                            </li> -->
                            <li>
                                <i class="far fa-mobile"></i>
                                <strong><?=str_replace("-", " ", str_replace("998-",'', $home["text_1"]))?></strong>
                            </li>
                        </ul>
                    </div>
                </div>
            
                <div class="col-lg-2 col-md-2 d-none d-lg-block text-right">
                    <div class="navbar-langs">
                        <div class="header-social mt-0 d-flex  align-items-center">
                            <?
                            foreach ($langs_list as $key => $lang) {
                                $lang_link = str_replace(
                                    $url2[0]."/",
                                    str_replace("gb", "en", $lang["flag_icon"])."/",
                                    urldecode($_SERVER["REQUEST_URI"])
                                );
                                
                                echo '<a class="d-flex ml-0 lang_change" data-flag='.str_replace("gb", "en", $lang["flag_icon"]).' style="margin-left: 0px !important; margin-right: 4px;" href="'.$lang_link.'"><span class=" flag-icon flag-icon-'.$lang["flag_icon"].'"></span> '. str_replace("gb", "en", $lang["flag_icon"]).'</a>';
                
                                if (count($langs_list) != $key + 1) echo '<span class="slash" style="margin-right: 6px;">/</span>';
                            }
                            ?>
                        </div>
                    </div>
                </div>

                
            </div>
        </div>
    </div>		
    <div id="header-sticky" class="menu-area">
        <div class="container">
            <div class="second-menu">
                <div class="row align-items-center">
                    <div class="col-xl-2 col-lg-2">
                        <div class="logo">
                            <a href="/"><img src="../theme/riorelax/img/logo/p-logo.png" alt="logo"></a>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8">
                        
                        <div class="main-menu text-center">
                            <nav id="mobile-menu">
                                    <ul>
                                    <!-- <li><a href="<?=$url2[0]?>/#about" style="text-transform:uppercase;"><?=lng($home["text_10"])?></a></li>         -->
                                    <li class="has-sub">
                                        <a href="<?=$url2[0]?>/#rooms" style="text-transform:uppercase;"><?=lng($home["text_9"])?></a>
                                    </li>    
                                    <li class="has-sub">
                                        <a href="<?=$url2[0]?>/#advantages" style="text-transform:uppercase;"><?=lng($home["text_19"])?></a>
                                    </li> 
                                    <li class="has-sub">
                                        <a href="<?=$url2[0]?>/#comparison" style="text-transform:uppercase;"><?=translate("Taqqoslash")?></a>
                                    </li>  
                                    <li><a href="<?=$url2[0]?>/#contacts" style="text-transform:uppercase;"><?=translate("Kontaktlar")?></a></li>
                                    <li><a href="<?=$url2[0]?>/restaurant" style="text-transform:uppercase;"><?=translate("Restoran")?></a></li>
                                </ul>
                            </nav>
                        </div>
                    </div>   
                        <div class="col-xl-2 col-lg-2 d-none d-lg-block">
                            <a href="<?=$url2[0]?>/#booking" class="top-btn mt-10 mb-10"><?=lng($home["text_2"])?> </a>
                        </div>
                    
                        <div class="col-12">
                            <div class="mobile-menu"></div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- header-end -->