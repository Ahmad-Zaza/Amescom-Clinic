<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset=UTF-8>
    <meta name=viewport content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin=anonymous>
    <title>تسجيل الدخول</title>
</head>

<body>
    <div class="sidenav">
        <div class="login-main-text">
            <h2>AmesCom Clinic<br> Login Page</h2>
            <p>Login from here to access.</p>
        </div>
    </div>
    <div class="main">
        <div class="col-md-6 col-sm-12">

            <div class="login-form">
                <form id="sign_in" method="POST" action="{{ route('login.submit') }}" autocomplete="off">

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

                    @csrf
                    <div class="form-group">
                        <label>User Name</label>
                        <input class="form-control" type="text" name="userName" placeholder="Enter the user name"
                            value="{{ old('userName') }}" required autocomplete="off">
                        <span class="text-danger">@error('userName')
                                {{ $message }}
                            @enderror</span>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" type="password" name="password" value="{{ old('password') }}"
                            placeholder="Enter the password" required autocomplete="off">
                        <span class="text-danger">@error('password')
                                {{ $message }}
                            @enderror</span>
                    </div>
                    <div class="form-group">
                        <label>Login As : </label>
                        <select class="form-control" id="role" name="role">
                            <option data-subtext="Admin" value="1">Admin</option>
                            <option data-subtext="Receptionist" value="2">Receptionist</option>
                            <option data-subtext="Doctor" value="3">Doctor</option>
                            <option data-subtext="Laboratory Technician" value="4">Laboratory Technician</option>
                            <option data-subtext="Radiograph Technician" value="5">Radiograph Technician</option>
                        </select>
                    </div>
                    <button type="submit" id="Submitbutton" class="btn btn-black">Login</button>

                </form>
            </div>
        </div>
    </div>
    <style>
        .sidenav {
            height: 100%;
            background-color: #5686E1;
            overflow-x: hidden;
            padding-top: 20px;
        }


        .main {
            padding: 0px 10px;
        }

        @media screen and (max-height: 450px) {
            .sidenav {
                padding-top: 15px;
            }
        }

        @media screen and (max-width: 450px) {
            .login-form {
                margin-top: 10%;
            }

            .register-form {
                margin-top: 10%;
            }
        }

        @media screen and (min-width: 768px) {
            .main {
                margin-left: 40%;
            }

            .sidenav {
                width: 40%;
                position: fixed;
                z-index: 1;
                top: 0;
                left: 0;
            }

            .login-form {
                margin-top: 80%;
            }

            .register-form {
                margin-top: 20%;
            }
        }


        .login-main-text {
            margin-top: 20%;
            padding: 60px;
            color: #fff;
        }

        .login-main-text h2 {
            font-weight: 300;
        }

        .btn-black {
            background-color: #5686E1 !important;
            color: #fff;
        }

    </style>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function() {
            'use strict';
            window.addEventListener('load', function() {
                // Fetch all the forms we want to apply custom Bootstrap validation styles to
                var forms = document.getElementsByClassName('needs-validation');
                // Loop over them and prevent submission
                var validation = Array.prototype.filter.call(forms, function(form) {
                    form.addEventListener('submit', function(event) {
                        if (form.checkValidity() === false) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                        form.classList.add('was-validated');
                    }, false);
                });
            }, false);
        })();

        $(document).ready(function() {
            $("#Submitbutton").on('dblclick', function(event) {
                event.preventDefault();
                var el = $(this);
                el.prop('disabled', true);
                setTimeout(function() {
                    el.prop('disabled', false);
                }, 3000);
            });

            $("form").submit(function() {
                $(this).submit(function() {
                    return false;
                });
                return true;
            });

        });
    </script>
</body>

</html>
