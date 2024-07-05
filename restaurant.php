<?
$is_config = true;
if (empty($load_defined)) include 'load.php';

// if (isAuth() === false) {
//     header("Location: /login");
//     exit;
// }

$home = $db->assoc("SELECT * FROM home");

include "system/head.php";
$restaurant_images = $db->in_array("SELECT * FROM restaurant");

?>

<!-- main-area -->
<main style="margin-top: 120px;">
    <!-- pricing-area -->
        <section id="pricing" class="pricing-area pt-30 pb-60 fix p-relative">
            <div class="animations-01"><img src="../theme/riorelax/img/bg/an-img-01.png" alt="an-img-01"></div>
            <div class="animations-02"><img src="../theme/riorelax/img/bg/an-img-02.png" alt="contact-bg-an-01"></div>
            <div class="container"> 
                <div class="row section-title mb-30">
                    <h2 class="bedroom_title text-center text-uppercase"><?=translate("Restoran")?></h2>
                </div>
                <div class="row justify-content-center align-items-center flex-wrap">
                    <? foreach ($restaurant_images as $restaurant_image) {
                            $restaurant = image($restaurant_image["image_id"]);
                    ?>
                        <img style="width: 400px; height: 400px; object-fit:cover; margin-top: 20px;" src="<?=$restaurant["file_folder"]?>" alt="">
                    <? } ?>
                </div>
            </div>
        </section>
    <!-- pricing-area-end -->

</main>
<!-- main-area-end -->

<?
include "system/scripts.php";
?>

<?
include "system/end.php";
?>