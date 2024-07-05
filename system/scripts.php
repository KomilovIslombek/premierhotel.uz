<!-- JS here -->
<script src="../theme/riorelax/js/vendor/modernizr-3.5.0.min.js"></script>
<script src="../theme/riorelax/js/vendor/jquery-3.6.0.min.js"></script>
<script src="../theme/riorelax/js/popper.min.js"></script>
<script src="../theme/riorelax/js/bootstrap.min.js"></script>
<script src="../theme/riorelax/js/slick.min.js"></script>
<script src="../theme/riorelax/js/ajax-form.js"></script>
<script src="../theme/riorelax/js/paroller.js"></script>
<script src="../theme/riorelax/js/wow.min.js"></script>
<script src="../theme/riorelax/js/js_isotope.pkgd.min.js"></script>
<script src="../theme/riorelax/js/imagesloaded.min.js"></script>
<script src="../theme/riorelax/js/parallax.min.js"></script>
<script src="../theme/riorelax/js/jquery.waypoints.min.js"></script>
<script src="../theme/riorelax/js/jquery.counterup.min.js"></script>
<script src="../theme/riorelax/js/jquery.scrollUp.min.js"></script>
<script src="../theme/riorelax/js/jquery.meanmenu.min.js"></script>
<script src="../theme/riorelax/js/parallax-scroll.js"></script>
<script src="../theme/riorelax/js/jquery.magnific-popup.min.js"></script>
<script src="../theme/riorelax/js/element-in-view.js"></script>
<script src="../theme/riorelax/js/main.js"></script>

<? if($url[0] == "room") { ?>
    <script src="../theme/riorelax/js/swiper-bundle.min.js"></script>
<? } ?>

<script>
    const getCookieValue = (name) => (
        document.cookie.match('(^|;)\\s*' + name + '\\s*=\\s*([^;]+)')?.pop() || ''
    )
    
    function setCookie(cname, cvalue, exdays) {
        const d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        let expires = "expires="+ d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    $(".phone-mask").on("input keyup", function(e){
        var x = e.target.value.replace(/\D/g, '').match(/(\d{0,3})(\d{0,2})(\d{0,3})(\d{0,2})(\d{0,2})/);
        // console.log(x);
        e.target.value = !x[2] ? '+' + (x[1].length == 3 ? x[1] : '998') : '+' + x[1] + '-' + x[2] + (x[3] ? '-' + x[3] : '') + (x[4] ? '-' + x[4] : '') + (x[5] ? '-' + x[5] : '');
    });

    $(".lang_change").on("click", function () {
        var flagName = $(this).attr('data-flag');
        console.log(flagName);
        window.history.pushState('title', 'Title', '/'+flagName+'/');
        setCookie("lang", flagName, 3);
        $(".modal_container").addClass("d-none");
        $(".bg-blur").addClass("d-none");

        // console.log($(this).attr('data-flag'));
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
        location.reload();
    })
</script>