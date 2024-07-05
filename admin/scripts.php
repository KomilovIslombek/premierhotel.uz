<!--**********************************
    Scripts
***********************************-->
<script src="https://kit.fontawesome.com/2ba10e709c.js" crossorigin="anonymous"></script>
<!-- Required vendors -->
<script src="../theme/vora/vendor/global/global.min.js"></script>

<script src="../theme/vora/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>

<!-- Datatable -->
<script src="../theme/vora/vendor/datatables/js/jquery.dataTables.min.js"></script>
<script src="../theme/vora/js/plugins-init/datatables.init.js"></script>

<!--  font awasome -->
<!-- <script src="https://kit.fontawesome.com/2ba10e709c.js" crossorigin="anonymous"></script> -->

<script src="../theme/vora/vendor/chart.js/Chart.bundle.min.js"></script>
<!-- Owl carousel -->
<script src="../theme/vora/vendor/owl-carousel/owl.carousel.js"></script>
<!-- Chart piety plugin files -->
<script src="../theme/vora/vendor/peity/jquery.peity.min.js"></script>
<script src="../theme/vora/vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
<? if ($url[0] == "home") { ?>
    <!-- Apex Chart -->
    <script src="../theme/vora/vendor/apexchart/apexchart.js"></script>
    <!-- Dashboard 1 -->
    <script src="../theme/vora/js/dashboard/dashboard-1.js"></script>
<? } ?>

<!-- Select2 -->
<script src="../theme/vora/vendor/select2/js/select2.full.min.js"></script>
<script src="../theme/vora/js/plugins-init/select2-init.js"></script>
<!--  -->
<script src="../theme/vora/js/custom.min.js"></script>
<script src="../theme/vora/js/dlabnav-init.js"></script>

<!-- Excel -->
<script src="modules/excel/excel.js"></script>


<!-- // CK EDITOR -->
<script src="https://cdn.ckeditor.com/4.20.1/full-all/ckeditor.js"></script>

<!-- plyr -->
<script src="https://cdn.plyr.io/3.7.3/plyr.polyfilled.js"></script>

<!-- // CK EDITOR -->
<script type="text/javascript">
// Change the second argument to your options:
// https://github.com/sampotts/plyr/#options
const player = new Plyr('video', {captions: {active: true}});

// Expose player so it can be used from the console
window.player = player;


var unique_id = 1000;

function editorOn() {
    $("*[editor]").each(function(){
        unique_id++;
        console.log(unique_id);
        $(this).attr("editor", "on");
        var id = "editor"+unique_id;
        $(this).attr("id", id);

        CKEDITOR.replace(id, {
            // Pressing Enter will create a new <div> element.
            enterMode: CKEDITOR.ENTER_DIV,
            // Pressing Shift+Enter will create a new <p> element.
            shiftEnterMode: CKEDITOR.ENTER_P,
            
            extraPlugins: 'uploadimage,image2',
            image2_disableResizer : true,

            filebrowserUploadMethod: 'form',
            filebrowserUploadUrl: "admin/ck_upload_image.php",
            imageUploadUrl: "admin/ck_upload_image.php",
            uploadUrl: "admin/ck_upload_image.php"
        });

        CKEDITOR.on('dialogDefinition', function(ev) {
            var dialogName = ev.data.name;
            var dialogDefinition = ev.data.definition;
            if (dialogName == 'image2') {

                var infoTab = dialogDefinition.getContents( 'info' );

                infoTab.get('width').validate = function() {
                    return true; //more advanced validation rule should be used here
                }

                infoTab.get('height').validate = function() {
                    return true; //more advanced validation rule should be used here
                }
            }
        });
    })
} editorOn();

// CK EDITOR
</script>

<script>
    $("#filter").find("select").on("change", function(){
        updateTable();
    });

    $("#filter").find("input").on("input", function(){
        updateTable();
    });

    function updateTable() {
        var q = $( "#filter" ).serialize();
        var url = '/<?=$url[0]?>?' + q;
        $.ajax({
            url: url,
            type: "GET",
            dataType: "html",
            success: function(data) {
                window.history.pushState($(data).find("title").text(), "Title", url);
                // console.log(data);
                $("#table").html($(data).find("#table").html());
                $("#pagination-wrapper").html($(data).find("#pagination-wrapper").html());
            }
        })
    }

    $("#input-search").on("input", function(){
        updateTable();
    });

    $(document).on("click", ".page-link", function(e){
        if ($(this).hasClass("active")) return;
        e.preventDefault();

        var url = $(this).attr("href");

        $.get(url, function(data){
            window.history.pushState($(data).find("title").text(), "Title", url);
            $("#table").html($(data).find("#table").html());
            $("#pagination-wrapper").html($(data).find("#pagination-wrapper").html());
        });
    });

    // room services

    var numberOfChecked = $('input:checkbox:checked').length
    if($(".mineitem:checked").length == $(".mineitem").length) {
        console.log(numberOfChecked);
        $('#checkAll2').prop('checked', true);
    }

    $("#checkAll2").change(function(){
        $(".mineitem").prop('checked', $(this).prop('checked'));
    });
    $(".mineitem").change(function() {
        if($(this).prop('checked') == false) {
            $('#checkAll2').prop('checked', false);
        }
        if($(".mineitem:checked").length == $(".mineitem").length) {
            $('#checkAll2').prop('checked', true);
            console.log("hello");
        }
    })
</script>


<script>
    $("#flag-icon").change(function(){
        $("#lang_icon").attr("class", "flag-icon flag-icon-"+$(this).find(":selected").val());
    });

    $("*[select-form-lang]").click(function(){
        var lang = $(this).attr('select-form-lang');
        // console.log(lang);
        $("*[form-lang]").hide();
        $("*[form-lang='"+lang+"']").show();
    });
</script>