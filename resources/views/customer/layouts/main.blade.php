<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900&display=swap" rel="stylesheet">

    <title>Roway</title>


    <!-- Additional CSS Files -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css"
          rel="stylesheet"
          integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT"
          crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="/customer/css/font-awesome.css">

    <link rel="stylesheet" href="/customer/css/templatemo-hexashop.css">

    <link rel="stylesheet" href="/customer/css/owl-carousel.css">

    <link rel="stylesheet" href="/customer/css/lightbox.css">
</head>

<body>

<!-- ***** Preloader Start ***** -->
<div id="preloader">
    <div class="jumper">
        <div></div>
        <div></div>
        <div></div>
    </div>
</div>
<!-- ***** Preloader End ***** -->


@include('customer.layouts.header')

@yield('content')

@include('customer.layouts.footer')
<!-- jQuery -->
<script src="/customer/js/jquery-3.7.1.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js"
        integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D"
        crossorigin="anonymous"></script>

<!-- Plugins -->
<script src="/customer/js/owl-carousel.js"></script>
<script src="/customer/js/accordions.js"></script>
<script src="/customer/js/datepicker.js"></script>
<script src="/customer/js/scrollreveal.min.js"></script>
<script src="/customer/js/waypoints.min.js"></script>
<script src="/customer/js/jquery.counterup.min.js"></script>
<script src="/customer/js/imgfix.min.js"></script>
<script src="/customer/js/slick.js"></script>
<script src="/customer/js/lightbox.js"></script>
<script src="/customer/js/isotope.js"></script>

<!-- Global Init -->
<script src="/customer/js/custom.js"></script>
<script>
    $(function() {
        var selectedClass = "";
        $("p").click(function(){
            selectedClass = $(this).attr("data-rel");
            $("#portfolio").fadeTo(50, 0.1);
            $("#portfolio div").not("."+selectedClass).fadeOut();
            setTimeout(function() {
                $("."+selectedClass).fadeIn();
                $("#portfolio").fadeTo(50, 1);
            }, 500);

        });
    });
</script>
</body>
</html>
