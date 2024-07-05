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

if ($_REQUEST["type"] == $url[1]){
    // validate(["first_name", "last_name", "comment"]);
    // echo
    // print_r($_POST);
    // echo ;Biz haqimizda
    // exit;
    include "./modules/uploadImage.php";

    $uploadedBanerImage = uploadImage("image", "images/home", ["jpg","jpeg","png"]);
    $uploadedBaner2Image = uploadImage("image2", "images/home", ["jpg","jpeg","png"]);
    $uploadedBaner3Image = uploadImage("image3", "images/home", ["jpg","jpeg","png"]);

    if (!$errors["forms"] || count($errors["forms"]) == 0) {
        $home_id = $db->insert("home", [
            "creator_user_id" => $user_id,
            "image_id" => $uploadedBanerImage["image_id"],
            "image_id2" => $uploadedBaner2Image["image_id"],
            "image_id3" => $uploadedBaner3Image["image_id"],
            "text_1" => $_POST["text_1"] == '' ? null : $_POST["text_1"],
            "text_2" => $_POST["text_2"] == '' ? null : $_POST["text_2"],
            "text_3" => $_POST["text_3"] == '' ? null : $_POST["text_3"],
            "text_4" => $_POST["text_4"] == '' ? null : $_POST["text_4"],
            "text_5" => $_POST["text_5"] == '' ? null : $_POST["text_5"],
            "text_6" => $_POST["text_6"] == '' ? null : $_POST["text_6"],
            "text_7" => $_POST["text_7"] == '' ? null : $_POST["text_7"],
            "text_8" => $_POST["text_8"] == '' ? null : $_POST["text_8"],
            "text_9" => $_POST["text_9"] == '' ? null : $_POST["text_9"],
            "text_10" => $_POST["text_10"] == '' ? null : $_POST["text_10"],
            "text_11" => $_POST["text_11"] == '' ? null : $_POST["text_11"],
            "text_12" => $_POST["text_12"] == '' ? null : $_POST["text_12"],
            "text_13" => $_POST["text_13"] == '' ? null : $_POST["text_13"],
            "text_14" => $_POST["text_14"] == '' ? null : $_POST["text_14"],
            "text_15" => $_POST["text_15"] == '' ? null : $_POST["text_15"],
            "text_16" => $_POST["text_16"] == '' ? null : $_POST["text_16"],
            "text_17" => $_POST["text_17"] == '' ? null : $_POST["text_17"],
            "text_18" => $_POST["text_18"] == '' ? null : $_POST["text_18"],
            "text_19" => $_POST["text_19"] == '' ? null : $_POST["text_19"],
            "text_20" => $_POST["text_20"] == '' ? null : $_POST["text_20"],
            "text_21" => $_POST["text_21"] == '' ? null : $_POST["text_21"],
            "text_22" => $_POST["text_22"] == '' ? null : $_POST["text_22"],
            "text_23" => $_POST["text_23"] == '' ? null : $_POST["text_23"],
            "text_24" => $_POST["text_24"] == '' ? null : $_POST["text_24"],
            "text_25" => $_POST["text_25"] == '' ? null : $_POST["text_25"],
            "text_26" => $_POST["text_26"] == '' ? null : $_POST["text_26"],
            "text_27" => $_POST["text_27"] == '' ? null : $_POST["text_27"],
            "text_28" => $_POST["text_28"] == '' ? null : $_POST["text_28"],
            "text_29" => $_POST["text_29"] == '' ? null : $_POST["text_29"],
            "text_30" => $_POST["text_30"] == '' ? null : $_POST["text_30"],
        ]);

        header("Location: homeList/?page=1");
    } else {
        // header("Content-type: text/plain");
        // print_r($errors);
        // exit;
    }
}

include "head.php";

$breadcump_title_1 = "Bosh sahifa";
$breadcump_title_2 = "Bosh sahifaga matn qo'shish";
$form_title = "Bosh sahifaga matn qo'shish";
?>

<!--**********************************
    Content body start
***********************************-->
<div class="content-body">
    <div class="container-fluid">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)"><?=$breadcump_title_1?></a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)"><?=$breadcump_title_2?></a></li>
            </ol>
        </div>

        <!-- row -->
        <div class="row">
            <div class="col-lg-8 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title" style="text-transform:none;"><?=$form_title?></h4>
                    </div>
                    <div class="card-body">
                        <div class="basic-form">
                            <form action="/admin/<?=$url[1]?>" method="POST" enctype="multipart/form-data">
                                <input type="hidden" name="type" value="<?=$url[1]?>">
                                <div class="form-row">

                                    <?=getError("text_1")?>
                                    <div class="form-group col-6">
                                        <label>Call markaz raqami</span></label>
                                        <input name="text_1" class="form-control" placeholder="Video sarlavhasi" id="phone-mask"/>
                                    </div>

                                    <?=getError("text_2")?>
                                    <div class="form-group col-6">
                                        <label>Navbar knopkasi matni</span></label>
                                        <input name="text_2" class="form-control" placeholder="Navbar knopkasi matni" />
                                    </div>

                                    <?=getError("text_3")?>
                                    <div class="form-group col-6">
                                        <label>Banner knopka matni</label>
                                        <input name="text_3" class="form-control" placeholder="Banner 1 knopka matni" />
                                    </div>

                                    <?=getError("text_4")?>
                                    <div class="form-group col-6">
                                        <label>Banner video knopka matni</span></label>
                                        <input name="text_4" class="form-control" placeholder="Banner video knopka matni" />
                                    </div>

                                    <div class="bg-primary text-white border-bottom col-12 ms-2 mb-3">Etap 2 Bannerda ustida turgan buyurtma berish</div>
                                    
                                    <?=getError("text_5")?>
                                    <div class="form-group col-6">
                                        <label>Buyurtma berish 1 chi matni</span></label>
                                        <input name="text_5" class="form-control" placeholder="Buyurtma berish 1 chi matni" />
                                    </div>

                                    <?=getError("text_6")?>
                                    <div class="form-group col-6">
                                        <label>2 chi matni</span></label>
                                        <input name="text_6" class="form-control" placeholder="2 chi matni" />
                                    </div>
                                    
                                    <?=getError("text_7")?>
                                    <div class="form-group col-6">
                                        <label>3 chi matni</span></label>
                                        <input name="text_7" class="form-control" placeholder="3 chi matni" />
                                    </div>

                                    <?=getError("text_8")?>
                                    <div class="form-group col-6">
                                        <label>4 chi matni</span></label>
                                        <input name="text_8" class="form-control" placeholder="4 chi matni" />
                                    </div>

                                    <?=getError("text_9")?>
                                    <div class="form-group col-12">
                                        <label>5 chi matni</span></label>
                                        <input name="text_9" class="form-control" placeholder="5 chi matni" />
                                    </div>

                                    <div class="bg-primary text-white border-bottom col-12 ms-2 mb-3">Etap 3 Biz haqimizda</div>
                                    
                                    <?=getError("image")?>
                                    <div class="form-group col-6">
                                        <label for="formFile" class="form-label">Biz haqimizda 1 chi rasmi (jpg, jpeg, png)</label>
                                        <input class="form-control" type="file" name="image" id="formFile" accept="image/*">
                                    </div>
                                    
                                    <?=getError("image2")?>
                                    <div class="form-group col-6">
                                        <label for="formFile" class="form-label">Biz haqimizda 2 chi rasmi (jpg, jpeg, png)</label>
                                        <input class="form-control" type="file" name="image2" id="formFile" accept="image/*">
                                    </div>

                                    <?=getError("text_10")?>
                                    <div class="form-group col-6">
                                        <label>kichik sarlavha</span></label>
                                        <input name="text_10" class="form-control" placeholder="kichik sarlavha" />
                                    </div>
                                    
                                    <?=getError("text_11")?>
                                    <div class="form-group col-6">
                                        <label>Asosiy sarlavha</span></label>
                                        <input name="text_11" class="form-control" placeholder="Asosiy sarlavha" />
                                    </div>

                                    <?=getError("text_12")?>
                                    <div class="form-group col-12">
                                        <label>Biz haqimizda izoh 1</span></label>
                                        <textarea name="text_12" class="form-control border-primary"></textarea>
                                    </div>
                                    
                                    <?=getError("text_13")?>
                                    <div class="form-group col-12">
                                        <label>Biz haqimizda izoh 2</span></label>
                                        <textarea name="text_13" class="form-control border-primary"></textarea>
                                    </div>

                                    <?=getError("text_14")?>
                                    <div class="form-group col-12">
                                        <label>Biz haqimizda qulaylik 1</span></label>
                                        <input name="text_14" class="form-control" placeholder="qulaylik 1"/>
                                    </div>
                                    
                                    <?=getError("text_15")?>
                                    <div class="form-group col-12">
                                        <label>Biz haqimizda qulaylik 2</span></label>
                                        <input name="text_15" class="form-control" placeholder="qulaylik 1"/>
                                    </div>

                                    <?=getError("text_16")?>
                                    <div class="form-group col-12">
                                        <label>Biz haqimizda qulaylik 3</span></label>
                                        <input name="text_16" class="form-control" placeholder="qulaylik 1"/>
                                    </div>

                                    <?=getError("text_17")?>
                                    <div class="form-group col-12">
                                        <label>knopka matni</span></label>
                                        <input name="text_17" class="form-control" placeholder="knopka matni"/>
                                    </div>

                                    <div class="bg-primary text-white border-bottom col-12 ms-2 mb-3">Etap 4 Afzalliklarimiz</div>

                                    <?=getError("text_18")?>
                                    <div class="form-group col-6">
                                        <label>Kichik sarlavha</span></label>
                                        <input name="text_18" class="form-control" placeholder="Kichik sarlavha" />
                                    </div>
                                    
                                    <?=getError("text_19")?>
                                    <div class="form-group col-6">
                                        <label>Asosiy sarlavha</label>
                                        <input name="text_19" class="form-control" placeholder="Asosiy sarlavha" />
                                    </div>
                                    
                                    <?=getError("text_20")?>
                                    <div class="form-group col-12">
                                        <label>Izoh</label>
                                        <textarea name="text_20" class="form-control" placeholder="Izoh"></textarea>
                                    </div>

                                    <div class="bg-primary text-white border-bottom col-12 ms-2 mb-3">Etap 5 XONA TURLARIMIZ</div>

                                    <?=getError("text_21")?>
                                    <div class="form-group col-6">
                                        <label>Kichik sarlavha</span></label>
                                        <input name="text_21" class="form-control" placeholder="Kichik sarlavha" />
                                    </div>
                                    
                                    <?=getError("text_22")?>
                                    <div class="form-group col-6">
                                        <label>Asosiy sarlavha</label>
                                        <input name="text_22" class="form-control" placeholder="Asosiy sarlavha" />
                                    </div>
                                    
                                    <?=getError("text_23")?>
                                    <div class="form-group col-12">
                                        <label>Izoh</label>
                                        <textarea name="text_23" class="form-control" placeholder="Izoh"></textarea>
                                    </div>

                                    <div class="bg-primary text-white border-bottom col-12 ms-2 mb-3">Etap 6 MEHMONXONA XIZMATLARINI TAQQOSLASH</div>

                                    <?=getError("text_24")?>
                                    <div class="form-group col-6">
                                        <label>Asosiy sarlavha</label>
                                        <input name="text_24" class="form-control" placeholder="Asosiy sarlavha" />
                                    </div>

                                    <?=getError("text_25")?>
                                    <div class="form-group col-6">
                                        <label>Tablitsadagi '№' - shu belgidan keyin turagigon matn</span></label>
                                        <input name="text_25" class="form-control" placeholder="Kichik sarlavha" />
                                    </div>

                                    <div class="bg-primary text-white border-bottom col-12 ms-2 mb-3">Etap 7 BIZ BILAN BOG'LANING.</div>

                                    <?=getError("text_26")?>
                                    <div class="form-group col-6">
                                        <label>Asosiy sarlavha</label>
                                        <input name="text_26" class="form-control" placeholder="Asosiy sarlavha" />
                                    </div>

                                    <?=getError("text_27")?>
                                    <div class="form-group col-6">
                                        <label>Kichik sarlavha</span></label>
                                        <textarea name="text_27" class="form-control" placeholder="Kichik sarlavha" ></textarea>
                                    </div>

                                    <?=getError("text_28")?>
                                    <div class="form-group col-6">
                                        <label>Knopka matni</span></label>
                                        <input name="text_28" class="form-control" placeholder="Knopka matni" />
                                    </div>

                                    <div class="bg-primary text-white border-bottom col-12 ms-2 mb-3">Etap 8 XONA BRON QILISH.</div>

                                    <?=getError("text_29")?>
                                    <div class="form-group col-6">
                                        <label>Kichik sarlavha</span></label>
                                        <textarea name="text_29" class="form-control" placeholder="Kichik sarlavha" ><?=$home["text_29"]?></textarea>
                                    </div>

                                    <?=getError("text_30")?>
                                    <div class="form-group col-6">
                                        <label>Asosiy sarlavha</label>
                                        <input name="text_30" class="form-control" placeholder="Asosiy sarlavha" />
                                    </div>

                                    <?=getError("image3")?>
                                    <div class="form-group col-6">
                                        <label for="formFile" class="form-label">Xona bron qilish rasmini yuklash (jpg, jpeg, png)</label>
                                        <input class="form-control" type="file" name="image3" id="formFile" accept="image/*">
                                    </div>

                                    <!-- <div class="form-group col-6">
                                        <label><i style="color: #1d9bf0;" class="fa-brands fa-twitter"></i> 1. link twitter</span></label>
                                        <input name="text_17" class="form-control" placeholder="link twitter" />
                                    </div>
                                    
                                    <div class="form-group col-6">
                                        <label><i style="color: #f7715f;" class="fa-brands fa-instagram"></i> 2. link instagram</span></label>
                                        <input name="text_18" class="form-control" placeholder="link instagram" />
                                    </div>
                                    
                                    <div class="form-group col-6">
                                        <label><i style="color: #4867aa;" class="fa-brands fa-facebook"></i> 3. link facebook</span></label>
                                        <input name="text_19" class="form-control" placeholder="Uchinchi link facebook" />
                                    </div>
                                    
                                    <div class="form-group col-6">
                                        <label><i style="color: #f7715f;" class="fa-brands fa-youtube"></i> 4. link youtube</span></label>
                                        <input name="text_20" class="form-control" placeholder="Uchinchi link youtube" />
                                    </div> -->

                                </div>

                                <div class="toolbar toolbar-bottom" role="toolbar" style="text-align: right;">
                                    <button type="submit" class="btn btn-primary">Qo'shish</button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- end row -->
    </div>
</div>
<!--**********************************
    Content body end
***********************************-->

<?
include "scripts.php";
?>

<script>
    $("#phone-mask").on("input keyup", function(e){
        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,2})(\d{0,3})(\d{0,2})(\d{0,2})/);
        // console.log(x);
        e.target.value = !x[2] ? '+' + (x[1].length == 3 ? x[1] : '998') : '+' + x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '') + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '');
    });

    $("#phone-mask").keyup();
   
    $("#phone-mask2").on("input keyup", function(e){
        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,2})(\d{0,3})(\d{0,2})(\d{0,2})/);
        // console.log(x);
        e.target.value = !x[2] ? '+' + (x[1].length == 3 ? x[1] : '998') : '+' + x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '') + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '');
    });

    $("#phone-mask2").keyup();
</script>
<!-- Script uchun   -->

<?
include "end.php";
?>