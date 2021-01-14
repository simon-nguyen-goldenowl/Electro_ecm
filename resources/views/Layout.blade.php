
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <title>Electro Shop</title>

    <!-- Google font -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,700" rel="stylesheet">

    <!-- Bootstrap -->
    <link type="text/css" rel="stylesheet" href="{{asset('assets/customer/css/bootstrap.min.css')}}"/>

    <!-- Slick -->
    <link type="text/css" rel="stylesheet" href="{{asset('assets/customer/css/slick.css')}}"/>
    <link type="text/css" rel="stylesheet" href="{{asset('assets/customer/css/slick-theme.css')}}"/>

    <!-- nouislider -->
    <link type="text/css" rel="stylesheet" href="{{asset('assets/customer/css/nouislider.min.css')}}"/>

    <!-- Font Awesome Icon -->
    <link rel="stylesheet" href="{{asset('assets/customer/css/font-awesome.min.css')}}">

    <!-- Custom stylesheet -->
    <link type="text/css" rel="stylesheet" href="{{asset('assets/customer/css/style.css')}}"/>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>
<body>
    <!-- HEADER -->
    <header>
        @include('Components.Header')
    </header>
    <!-- /HEADER -->

    <!-- NAVIGATION -->
    <nav id="navigation">
        @include('Components.Navigation')
    </nav>
    <!-- /NAVIGATION -->

    <!-- MAIN CONTENT -->
    <div class="alert alert-success message-wishlist" style="display: none">
    </div>
    @yield('content')
    <!-- /MAIN CONTENT -->

    <!-- NEWSLETTER -->
    <div id="newsletter" class="section">
        @include('Components.NewsLetter')
    </div>
    <!-- /NEWSLETTER -->

    <!-- FOOTER -->
    <footer id="footer">
        @include('Components.Footer')
    </footer>
    <!-- /FOOTER -->

    <!-- jQuery Plugins -->
    <script src="{{asset('assets/customer/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/customer/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/customer/js/slick.min.js')}}"></script>
    <script src="{{asset('assets/customer/js/nouislider.min.js')}}"></script>
    <script src="{{asset('assets/customer/js/jquery.zoom.min.js')}}"></script>
    <script src="{{asset('assets/customer/js/main.js')}}"></script>
    <script>
        const params = new URLSearchParams(window.location.search)
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        function addWishlist(id){
            $.ajax({
                type: 'post',
                url: '/wishlists/'+id,
                success:function (data){
                    alert(data);
                    location.reload();
                }
            })
        }
    </script>
    <script src="https://js.pusher.com/beams/1.0/push-notifications-cdn.js"></script>
    <script>
        const beamsClient = new PusherPushNotifications.Client({
            instanceId: 'afea1aa9-03e9-4409-8661-76fd562baf28',
        });

        beamsClient.start()
            .then(() => beamsClient.addDeviceInterest('App.User.2')) //listen to user interest
            .then(() => console.log('Successfully registered and subscribed!'))
            .catch(console.error);
    </script>
    @stack('scripts')
</body>
</html>

