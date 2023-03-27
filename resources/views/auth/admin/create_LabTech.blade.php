@extends('layouts.AdminApp')

@section('title')
    {{ 'Laboratories Technicians' }}
@endsection


@section('content')
    <form action="{{ route('admin.create.labTech.store') }}" method="POST">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        {{-- Row one --}}
        <div class="form-row">
            <div class="col-sm-6 mb-3">
                <label for="validationCustom01">First name</label>
                <input type="text" class="form-control" id="validationCustom01" name="firstName" placeholder="First name"
                    value="{{ old('firstName') }}" required>
                @error('firstName')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-sm-6 mb-3 ">
                <label for="validationCustom02">Father name</label>
                <input type="text" class="form-control" id="validationCustom02" name="fatherName" placeholder="father name"
                    value="{{ old('fatherName') }}" required>
                @error('fatherName')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        {{-- Row two --}}
        <div class="form-row">
            <div class="col-sm-6 mb-3 ">
                <label for="validationCustom03">Last name</label>
                <input type="text" class="form-control" id="validationCustom03" name="lastName" placeholder="Last name"
                    value="{{ old('lastName') }}" required>
                @error('lastName')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-sm-6 mb-3 ">
                <label for="validationCustom04">Phone Number</label>
                <input type="text" class="form-control" id="validationCustom04" name="phoneNumber"
                    placeholder="Phone Number" value="{{ old('phoneNumber') }}" required>
                @error('phoneNumber')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        {{-- Row Three --}}
        <div class="form-row">

            <div class="col-sm-6 mb-3">
                <label for="validationCustom05">User Name</label>
                <input type="text" class="form-control" id="validationCustom05" name="userName" placeholder="User Name"
                    value="{{ old('userName') }}" required>
                @error('userName')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-sm-6 mb-3">
                <label for="validationCustom06">Doctor Information</label>
                <div class="input-group" value="{{ old('about_you') }}">
                    <textarea class="form-control" aria-label="With textarea" id="validationCustom06" name="about_you"
                        placeholder="Information"></textarea>
                    @error('about_you')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        {{-- Row Four --}}

        <div class="form-group row">
            <div class="col-sm-6 mb-3">
                <label for="department_id">Choose Department</label>
                <select class="form-control" id="department_id" name="department">
                    @foreach ($departments as $department)
                        {{-- <option>{{$department->name}}</option> --}}
                        <option data-subtext="{{ $department->name }}" value="{{ $department->id }}">
                            {{ $department->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Row Five --}}
        <div class="form-group row">
            <div class="col-sm-6 mb-3">
                <label for="password" class="col-form-label text-md-right">Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

            </div>
            <div class="col-sm-6 mb-3">
                <label for="password" class=" col-form-label text-md-right">Confirm Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password_confirmation" required autocomplete="current-password">
            </div>
        </div>
        {{-- End Rows --}}
        <button class="btn btn-primary" type="submit" id="Submitbutton">Add +</button>
    </form>

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

@endsection
