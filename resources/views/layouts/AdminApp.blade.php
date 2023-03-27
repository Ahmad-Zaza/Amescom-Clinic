<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    {{-- <script src="https://code.jquery.com/jquery-3.1.1.min.js" defer></script> --}}
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/animate.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/chosen.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/color-01.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/flexslider.css') }}">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">

    <link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/jquery-migrate-3.0.0.min.js"></script>
    <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>



</head>

<body>
    <div class='app'>


        <div class="container">

            <div class="row">

                <div class="col-3">
                    <div class="row">
                        <nav id="sidebar">
                            <div class="sidebar-header">
                                <h3>{{ auth()->guard('admin')->user()->firstName }}
                                    {{ auth()->guard('admin')->user()->lastName }}</h3>
                            </div>

                            <ul class="list-unstyled components">
                                <li>
                                    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
                                </li>

                                <li>
                                    <a href="{{ route('admin.visitings') }}">Visits</a>
                                </li>
                                {{-- @endif --}}
                                <li>
                                    <a href="{{ route('admin.patients') }}">Patients</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.doctors') }}">Doctors</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.labTechs') }}">Laboratory Technicicans</a>
                                </li>
                                <li>
                                    <a href="{{ route('admin.radiographs') }}">Radiograph Technicians</a>
                                </li>
                                <li>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </li>
                                {{-- <li>
                                    <a href="{{route('')}}">المرضى الحاليون</a>
                                </li> --}}
                            </ul>

                            <div class="sidebar-header" style="background-color: #5686E1">
                                <img src="{{ asset('assets/images/med long logo.png') }}" alt="background photo"
                                    height="200" width="100">
                            </div>
                        </nav>
                    </div>

                </div>
                <div class="col-9" style="">
                    @if (Session::get('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif
                    @if (Session::get('fail'))
                        <div class="alert alert-danger">
                            {{ Session::get('fail') }}
                        </div>
                    @endif

                    @yield('content')
                </div>

            </div>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Error Alert --}}
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <script>
        //close the alert after 3 seconds.
        $(document).ready(function() {
            setTimeout(function() {
                $(".alert").alert('close');
            }, 3000);
        });
    </script>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        Pusher.logToConsole = true;
        var pusher = new Pusher('dded664257c53f001fb2', {
            cluster: 'ap2',
            encrypted: false
        });


        var channel = pusher.subscribe('new-notification');

        channel.bind('noti.new', function(data) {
            var id = "{{ Auth::user()->department_id }}";
            if (data.department_id == id) {
                /*var a = document.createElement('a'),
                    mytext = document.createTextNode(data.msg);
                a.appendChild(mytext);
                document.getElementById('menu').appendChild(a);*/
                alert(data.msg);
            }


        });
    </script>
</body>

</html>
