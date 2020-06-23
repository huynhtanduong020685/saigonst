<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <meta http-equiv="refresh" content="International School"/>
    <meta name="SKYPE_TOOLBAR" content="Saigon Star International School"/>
    <meta http-equiv="Pragma" content="no-cache"/>
    <meta http-equiv="Expires" content="-1"/>
    <meta http-equiv="Cache-Control" content="no-cache"/>
    <meta name="format-detection" content="telephone=#truonghocquocte#" />
    <meta name="keywords" content="#internatioanlschool,#tuonghocquocte,#truonghocsaigon,#saigonstarinternationalschool,#mamnonquocte,#parentzoreThanhphoHCM"/>
    <meta name="description" content="To provide a safe and supportive learning environment, and every opportunity for children to be successful both as learners and as contributors in a changing world."/>
    <meta name="robots" content="trường quốc tế ngôi sao sài gòn "/>
    <meta name="googlebot" content="trường quốc tế ngôi sao sài gòn, trường học quốc tế Thanh Phố HCM">
    <meta name="revisit-after" content="parent's Family,parent zone saigon ,#parentzoneHochiminh"/>
    <meta name="generator" content="To provide a safe and supportive learning environment, and every opportunity for children to be successful both as learners and as contributors in a changing world."/>
    <meta name="rating" content="kiêm trường học quốc tế cho con, trường học quốc tế chất lượng hàng đầu việt nam">
    <meta property="og:description" content="To provide a safe and supportive learning environment, and every opportunity for children to be successful both as learners and as contributors in a changing world.">
    <meta property="og:title" content="https://sgstar.edu.vn/">
    <meta property="og:site_name" content="Saigon  Star International School, Trường học quốc tế đơn ngữ tại TPHCM,Việt Nam">
    <meta property="og:type" content="giáo dục chất lượng cao, chuẩn quốc tế, sài gòn star, ngôi sao sài gòn, Truonghoc TPHCM,trường học quốc tế thành phố hồ chí minh "/>
    <meta property="og:locale" content="vi_VN"/>
    <meta property="article:section" content="https://sgstar.edu.vn/"/>
    <meta property="article:tag" content="#Saigonstar,#internationalSchool,#saigonstarInternationalSchool,#mooitruongquocte,#truonghocquocte#,#mamnonquocte,#truonghocquocteTPHCM#truonghocquoctethanhphohochiminh""/>
    <meta property="article:author" content="https://sgstar.edu.vn/"/>
    <meta http-equiv="content-language" content="en">
    <title><?php echo e(SeoHelper::getTitle()); ?></title>

    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>  -->
    
    <?php echo Theme::header(); ?>

    <!-- Fonts-->
    <link href="https://fonts.googleapis.com/css?family=<?php echo e(theme_option('primary_font', 'Nunito Sans')); ?>:300,600,700,800" rel="stylesheet" type="text/css">
    <!-- CSS Library-->
    <link rel="stylesheet" href="<?php echo e(asset('css/banner-main.css')); ?>" media="all">
    
    <link rel="stylesheet" type="text/css" media="all" href="<?php echo e(asset('css/teacher.css')); ?>">

    <!-- Bootstrap -->
    <link href="<?php echo e(asset('css/bootstrap.min.css')); ?>" rel="stylesheet">
  
    <!-- Font-awesome -->
    <link href="<?php echo e(asset('css/font-awesome.min.css')); ?>" rel="stylesheet">
  
    <!-- Flaticon -->
    <link href="<?php echo e(asset('/flaticon/flaticon.css')); ?>" rel="stylesheet">
    
    <link href="<?php echo e(asset('css/flaticon.css')); ?>" rel="stylesheet">
  
    <!-- lightcase -->
    <link href="<?php echo e(asset('css/lightcase.css')); ?>" rel="stylesheet">
  
    <!-- Swiper -->
    <link href="<?php echo e(asset('css/swiper.min.css')); ?>" rel="stylesheet">

    <!-- quick-view -->
    <link href="<?php echo e(asset('css/quick-view.css')); ?>" rel="stylesheet">

    <!-- nstSlider -->
    <link href="<?php echo e(asset('css/jquery.nstSlider.css')); ?>" rel="stylesheet">

    <!-- flexslider -->
    <link href="<?php echo e(asset('css/flexslider.css')); ?>" rel="stylesheet">
    
    <!--  rtl  -->
    <link href="<?php echo e(asset('css/rtl.css')); ?>" rel="stylesheet">
  
    <!-- Style -->
    <link rel="stylesheet" href="<?php echo e(asset('css/style-app.css')); ?>" media="all">
  
    <!-- Responsive -->
    <link href="<?php echo e(asset('css/responsive.css')); ?>" rel="stylesheet">
    <style>
        body {font-family: '<?php echo e(theme_option('primary_font', 'Nunito Sans')); ?>', sans-serif !important;}
    </style>
</head>
<body>
    <?php echo Theme::partial('header'); ?>


    <div id="app" class="main-content">
        <?php echo Theme::content(); ?>

    </div>
    <?php echo Theme::partial('footer'); ?>


    <?php echo Theme::footer(); ?>


    <!--END FOOTER-->

    <div class="action_footer">
        <a href="#" class="cd-top"><i class="fas fa-arrow-up"></i></a>
        <a href="tel:<?php echo e(theme_option('hotline')); ?>" style="color: white;font-size: 18px;"><i class="fas fa-phone"></i> <span>  &nbsp;<?php echo e(theme_option('hotline')); ?></span></a>
    </div>
    <div id="loading">
        <div class="lds-hourglass">
        </div>
    </div>
</body>

<script>
            var slideIndex = 1;
            showSlides(slideIndex);
            function plusSlides(n) {
            showSlides(slideIndex += n);
            }
            function currentSlide(n) {
            showSlides(slideIndex = n);
            }
            function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("dot");
            if (n > slides.length) {slideIndex = 1}    
            if (n < 1) {slideIndex = slides.length}
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";  
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex-1].style.display = "block";  
            dots[slideIndex-1].className += " active";
            }
    </script>
    <script>
        // SmartMenus jQuery + Bootstrap 4 - expand active sub menu on mobile toggle button click
            $('.navbar-toggler').click(function() {
            var $nav = $('.navbar-nav');
            if (!$(this).is('[aria-expanded="true"]')) {
                // use the timeout to make sure it works after the navbar is expanded by the BS JS
                setTimeout(function() {
                $nav.smartmenus('itemActivate', $nav.find('a.current').eq(-1));
                }, 1);
            } else {
                $nav.smartmenus('menuHideAll');
            }
            });
    </script>
    <script>
                filterSelection("leadership")
                function filterSelection(c) {
                var x, i;
                x = document.getElementsByClassName("column-teacher");
                
                for (i = 0; i < x.length; i++) {
                    w3RemoveClass(x[i], "show");
                    if (x[i].className.indexOf(c) > -1) w3AddClass(x[i], "show");
                }
                }

                function w3AddClass(element, name) {
                var i, arr1, arr2;
                arr1 = element.className.split(" ");
                arr2 = name.split(" ");
                for (i = 0; i < arr2.length; i++) {
                    if (arr1.indexOf(arr2[i]) == -1) {element.className += " " + arr2[i];}
                }
                }

                function w3RemoveClass(element, name) {
                var i, arr1, arr2;
                arr1 = element.className.split(" ");
                arr2 = name.split(" ");
                for (i = 0; i < arr2.length; i++) {
                    while (arr1.indexOf(arr2[i]) > -1) {
                    arr1.splice(arr1.indexOf(arr2[i]), 1);     
                    }
                }
                element.className = arr1.join(" ");
                }


                // Add active class to the current button (highlight it)
                var btnContainer = document.getElementById("myBtnContainer");
                var btns = btnContainer.getElementsByClassName("btn");
                for (var i = 0; i < btns.length; i++) {
                btns[i].addEventListener("click", function(){
                    var current = document.getElementsByClassName("active");
                    current[0].className = current[0].className.replace(" active", "");
                    this.className += " active";
                });
                }
  </script>
<script>
    var acc = document.getElementsByClassName("accordion");
    var i;
    
    for (i = 0; i < acc.length; i++) {
    acc[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var panel = this.nextElementSibling;
        if (panel.style.display === "block") {
        panel.style.display = "none";
        } else {
        panel.style.display = "block";
        }
    });
    } 
</script>
<script type="text/javascript">
jQuery(function($){  
  $("#bt_close").on("click", function() {
      $(".social_group").addClass("hidden");
      $("#bt_open").show();
  });
  $("#bt_open").on("click", function() {
      $(this).hide();
      $(".social_group").show();
      $(".social_group").removeClass("hidden");
  });

  $(".social_group").hover(            
        function() {
            $(this).toggleClass('open');        
        },
        function() {
            $(this).toggleClass('open');       
        }
    );
});  

$( document ).ready(function() {    
    $("#bs-example-navbar-collapse-1 .dropdown-menu li.active").parent().parent().addClass('active');
  $('#menutop li .i_mobile_ex').click(function(){
    console.log('ok');
  })
});
</script>
<script>
/* Check the location of each element */
$('.content').each( function(i){
  
  var bottom_of_object= $(this).offset().top + $(this).outerHeight();
  var bottom_of_window = $(window).height();
  
  if( bottom_of_object > bottom_of_window){
    $(this).addClass('hidden');
  }
});


$(window).scroll( function(){
    /* Check the location of each element hidden */
    $('.hidden').each( function(i){
      
        var bottom_of_object = $(this).offset().top + $(this).outerHeight();
        var bottom_of_window = $(window).scrollTop() + $(window).height();
      
        /* If the object is completely visible in the window, fadeIn it */
        if( bottom_of_window > bottom_of_object ){
          $(this).animate({'opacity':'1'},700);
        }
    });
});
</script>

 <!-- Bootstrap -->
 <script src="<?php echo e(asset('js/bootstrap.min.js')); ?>"></script>
  
  <!-- Isotope -->
  <script src="<?php echo e(asset('js/isotope.min.js')); ?>"></script>

  <!-- lightcase -->
  <script src="<?php echo e(asset('js/lightcase.js')); ?>"></script>

  <!-- counterup -->
  <script src="<?php echo e(asset('js/waypoints.min.js')); ?>"></script>
  <script src="<?php echo e(asset('js/jquery.counterup.min.js')); ?>"></script>

  <!-- Swiper -->
  <script src="<?php echo e(asset('js/swiper.jquery.min.js')); ?>"></script>

  <!--progress-->
  <script src="<?php echo e(asset('js/circle-progress.min.js')); ?>"></script>

  <!--velocity-->
  <script src="<?php echo e(asset('js/velocity.min.js')); ?>"></script>

  <!--quick-view-->
  <script src="<?php echo e(asset('js/quick-view.js')); ?>"></script>

  <!--nstSlider-->
  <script src="<?php echo e(asset('js/jquery.nstSlider.js')); ?>"></script>

  <!--flexslider-->
  <script src="<?php echo e(asset('js/flexslider-min.js')); ?>"></script>

  <!--easing-->
  <script src="<?php echo e(asset('js/jquery.easing.min.js')); ?>"></script>

  <!-- custom -->
  <script src="<?php echo e(asset('js/custom.js')); ?>"></script>

  
</html>
<?php /**PATH D:\WWW\saigonstar2020\platform/themes/flex-home/layouts/default.blade.php ENDPATH**/ ?>