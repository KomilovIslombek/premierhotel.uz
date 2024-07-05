<!--**********************************
    Nav header start
***********************************-->
<div class="nav-header">
    <a href="/admin/" class="brand-logo">
        <div class="logo-abbr">
            <img src="../theme/riorelax/img/fav-logo.ico" alt="logo icon" width="43px" height="36.5px">
        </div>
        <div class="brand-title">
            <img style="transform: translateX(-3px);" src="../theme/vora/images/premier-right.png" width="170px" alt="">
            <!-- <img src="../theme/vora/images/logo-text-dark.png" width="150px" alt=""> -->
        </div>
    </a>

    <div class="nav-control">
        <div class="hamburger">
            <span class="line"></span><span class="line"></span><span class="line"></span>
        </div>
    </div>
</div>
<!--**********************************
    Nav header end
***********************************-->

<!--**********************************
    Header start
***********************************-->
<div class="header">
    <div class="header-content">
        <nav class="navbar navbar-expand">
            <div class="collapse navbar-collapse justify-content-between">
                <div class="header-left">
                    <div class="dashboard_bar">
                        Boshqaruv paneli
                    </div>
                </div>
                <ul class="navbar-nav header-right">
                    <li class="nav-item">
                        <div class="input-group search-area d-lg-inline-flex d-none">
                            <div class="input-group-append">
                                <span class="input-group-text"><a href="javascript:void(0)"><i class="flaticon-381-search-2"></i></a></span>
                            </div>
                            <input type="text" class="form-control" placeholder="Qidirish...">
                        </div>
                    </li>
                    <li class="nav-item dropdown header-profile">
                        <a class="nav-link" href="javascript:void(0)" role="button" data-bs-toggle="dropdown">
                            <img src="https://lh3.googleusercontent.com/a-/ACNPEu81kZokIw5BT6dgWohjzE-L5p70SO4uxhgcffPz-g=s288-p-rw-no" width="20" alt=""/>
                            <div class="header-info">
                                <span class="text-black"><?=$systemUser["first_name"] . " " . $systemUser["last_name"]?></span>
                                <p class="fs-12 mb-0"><?=$systemUser["role"]?></p>
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- <a href="/profile" class="dropdown-item ai-icon">
                                <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                <span class="ms-2">Akkaunt </span>
                            </a> -->

                            <a href="/exit" class="dropdown-item ai-icon">
                                <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                <span class="ms-2">Akkauntdan chiqish </span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<!--**********************************
    Header end ti-comment-alt
***********************************-->

<!--**********************************
    Sidebar start
***********************************-->
<div class="dlabnav">
    <div class="dlabnav-scroll">
        <ul class="metismenu" id="menu">
            <?php
            addMenu("flaticon-381-home", "Bosh sahifa", [
                // [
                //     "name" => "Bosh sahifadagilar ro'yxati",
                //     "page" => "homeList",
                //     "href" => "/admin/homeList/?page=1"
                // ],
                [
                    "name" => "Bosh sahifani tahrirlash",
                    "page" => "editHome",
                    "href" => "/admin/editHome/?id=".$homeId["id"]
                ]
            ]);
            
            addMenu("flaticon-381-newspaper", "Asosiy bannerlar", [
                [
                    "name" => "Bannerlar ro'yxati",
                    "page" => "mainBannersList",
                    "href" => "/admin/mainBannersList/?page=1"
                ],
                [
                    "name" => "yangi banner qo'shish",
                    "page" => "addMainBanners",
                    "href" => "/admin/addMainBanners"
                ]
            ]);

            addMenu("flaticon-381-list", "Xonalar", [
                [
                    "name" => "Xonalar ro'yxati",
                    "page" => "roomsList",
                    "href" => "/admin/roomsList/?page=1"
                ],
                [
                    "name" => "yangi xona qo'shish",
                    "page" => "addRoom",
                    "href" => "/admin/addRoom"
                ],
            ]);

            addMenu("flaticon-381-notepad-2", "Afzalikllarimiz", [
                [
                    "name" => "Afzalikllar ro'yxati",
                    "page" => "advantagesList",
                    "href" => "/admin/advantagesList/?page=1"
                ],
                [
                    "name" => "yangi afzalik qo'shish",
                    "page" => "addAdvantage",
                    "href" => "/admin/addAdvantage"
                ],
            ]);
            
            addMenu("flaticon-381-list-1", "Xizmatlar", [
                [
                    "name" => "Xizmatlar ro'yxati",
                    "page" => "servicesList",
                    "href" => "/admin/servicesList/?page=1"
                ],
                [
                    "name" => "yangi xizmat qo'shish",
                    "page" => "addService",
                    "href" => "/admin/addService"
                ]
            ]);

            addMenu("flaticon-381-picture", "Galereya", [
                [
                    "name" => "Rasmlar ro'yxati",
                    "page" => "galleryList",
                    "href" => "admin/galleryList/?page=1"
                ],
                [
                    "name" => "yangi rasm qo'shish",
                    "page" => "addGallery",
                    "href" => "admin/addGallery"
                ],
            ]);

            addMenu("flaticon-381-notepad", "Arizalar", [
                [
                    "name" => "Arizalar ro'yxati",
                    "page" => "requestsList",
                    "href" => "admin/requestsList/?page=1"
                ],
                // [
                //     "name" => "Qayta qo'ng'iroqlar ro'yxati",
                //     "page" => "againCallsList",
                //     "href" => "admin/againCallsList/?page=1"
                // ],
            ]);
           
            addMenu("flaticon-381-notepad", "Bronlar ro'yxati", [
                [
                    "name" => "Bronlar ro'yxati",
                    "page" => "roomBookings",
                    "href" => "admin/roomBookings/?page=1"
                ],
            ]);

            // $admin_permissions = $db->assoc("SELECT * FROM `users_roles` WHERE `user_id` = ?", [ $systemUser["id"] ]);
            // echo "<pre>";
            //     print_r(json_decode($admin_permissions["permissions"]));
            // echo "</pre>";

            // exit;

            
            addMenu("flaticon-381-layer-1", "To'lov kartalar", [
                [
                    "name" => "Rasmlar ro'yxati",
                    "page" => "picturesList",
                    "href" => "/admin/picturesList/?page=1"
                ],
                [
                    "name" => "yangi rasm qo'shish",
                    "page" => "addPicture",
                    "href" => "/admin/addPicture"
                ]
            ]);

            
            addMenu("flaticon-381-folder", "Restoran", [
                [
                    "name" => "Rasmlar ro'yxati",
                    "page" => "restaurantList",
                    "href" => "admin/restaurantList/?page=1"
                ],
                [
                    "name" => "yangi rasm qo'shish",
                    "page" => "addRestaurant",
                    "href" => "admin/addRestaurant"
                ],
            ]);
            
            addMenu("flaticon-381-file-2", "Ma'lumotlar", [
                [
                    "name" => "Ma'lumotlar ro'yxati",
                    "page" => "infoList",
                    "href" => "admin/infoList/?page=1"
                ],
                [
                    "name" => "yangi ma'lumot qo'shish",
                    "page" => "addInfo",
                    "href" => "admin/addInfo"
                ],
            ]);
            
            addMenu("flaticon-381-file", "Xususiyatlar", [
                [
                    "name" => "Xususiyatlar ro'yxati",
                    "page" => "featuredList",
                    "href" => "admin/featuredList/?page=1"
                ],
                [
                    "name" => "yangi xususiyat qo'shish",
                    "page" => "addFeatured",
                    "href" => "admin/addFeatured"
                ],
            ]);
            
            // addMenu("flaticon-381-photo", "Slider rasmlari", [
            //     [
            //         "name" => "Slider rasmlar ro'yxati",
            //         "page" => "slideImagesList",
            //         "href" => "admin/slideImagesList/?page=1"
            //     ],
            //     [
            //         "name" => "Slider ga rasm qo'shish",
            //         "page" => "addSlideImage",
            //         "href" => "admin/addSlideImage"
            //     ]
            // ]);

            // addMenu("flaticon-381-user-2", "Mijozlarimiz firkrlari", [
            //     [
            //         "name" => "izohlar ro'yxati",
            //         "page" => "commentsList",
            //         "href" => "admin/commentsList/?page=1"
            //     ],
            //     [
            //         "name" => "yangi izoh qo'shish",
            //         "page" => "addComment",
            //         "href" => "admin/addComment"
            //     ]
            // ]);

            addMenu("flaticon-381-earth-globe", "Tillar", [
                [
                    "name" => "Tillar ro'yxati",
                    "page" => "langsList",
                    "href" => "admin/langsList/?page=1"
                ],
                [
                    "name" => "yangi til qo'shish",
                    "page" => "addLang",
                    "href" => "/admin/addLang"
                ],
            ]);
            
            addMenu("flaticon-381-user-2", "Xodimlar", [
                [
                    "name" => "Xodimlar ro'yxati",
                    "page" => "employeesList",
                    "href" => "/admin/employeesList/?page=1"
                ],
                [
                    "name" => "yangi xodim qo'shish",
                    "page" => "addEmployee",
                    "href" => "/admin/addEmployee"
                ],
            ]);
            ?>
        </ul>
    </div>
</div>
<!--**********************************
    Sidebar end
***********************************-->