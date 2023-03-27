@extends('layouts.AdminApp')

@section('title')
    {{ 'Edit Radiograph Technician' }}
@endsection


@section('content')
    <style>
        .edit-btn {
            background-color: #FFC107;
            color: #FFFFFF;
        }

    </style>
    <form action="{{ route('admin.edit.radTech.update') }}" method="post">
        @csrf
        {{ method_field('PUT') }}
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
        <input id="radTech_id" name="radTech_id" type="hidden" value="{{ $radTech->id }}">
        <div class="form-row">
            <div class="col-sm-6 mb-3">
                <label for="validationCustom01">First name</label>
                <input type="text" class="form-control" id="validationCustom01" name="firstName" placeholder="First name"
                    value="{{ $radTech->firstName }}" required>
                @error('firstName')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-sm-6 mb-3 ">
                <label for="validationCustom02">Father name</label>
                <input type="text" class="form-control" id="validationCustom02" name="fatherName" placeholder="father name"
                    value="{{ $radTech->fatherName }}" required>
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
                    value="{{ $radTech->lastName }}" required>
                @error('lastName')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-sm-6 mb-3 ">
                <label for="validationCustom04">Phone Number</label>
                <input type="text" class="form-control" id="validationCustom04" name="phoneNumber"
                    placeholder="Phone Number" value="{{ $radTech->phoneNumber }}" required>
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
                    value="{{ $radTech->userName }}" required>
                @error('userName')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="col-sm-6 mb-3">
                <label for="validationCustom06">Radiograph Technician Information</label>
                <div class="input-group">
                    <textarea class="form-control" aria-label="With textarea" id="validationCustom06" name="aboutYou"
                        placeholder="Information">
                                {{ $radTech->aboutYou }}
                            </textarea>
                    @error('aboutYou')
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
                <label for="department_id" value="{{ $radTech->department->name }}">Choose Department</label>
                <select class="form-control" id="department_id" name="department"
                    value="{{ $radTech->department->name }}">
                    <option value="{{ $radTech->department->id }}">{{ $radTech->department->name }}</option>
                    @foreach ($departments as $department)
                        @if ($department->name != $radTech->department->name)
                            <option data-subtext="{{ $department->name }}" value="{{ $department->id }}">
                                {{ $department->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Row Five --}}
        <div class="form-group row">
            <div class="col-sm-6 mb-3">
                <label for="password" class="col-form-label text-md-right">Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    name="password" value="{{ $radTech->password }}" required autocomplete="current-password">

                @error('password')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror

            </div>
            <div class="col-sm-6 mb-3">
                <label for="password" class=" col-form-label text-md-right">Confirm Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                    value="{{ $radTech->password }}" name="password_confirmation" required
                    autocomplete="current-password">
            </div>
        </div>
        <div class="form-row">
            <div class="col-sm-6 mb-3 ">
                <label for="isContracted" style="font-size: 15px">change contracting state *</label>
                @if ($radTech->isContracted === 1)
                    <div class="form-check">

                        <input class="form-check-input" type="radio" name="isContracted" id="_contracted" value=1 checked>
                        <label class="form-check-label" for="contracted1">
                            Contracted
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="isContracted" id="_contracted" value=0>
                        <label class="form-check-label" for="contracted2">
                            Not contracted
                        </label>
                    </div>
            </div>
        @else
            <div class="form-check">

                <input class="form-check-input" type="radio" name="isContracted" id="_contracted" value=1>
                <label class="form-check-label" for="contracted1">
                    Contracted
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="isContracted" id="_contracted" value=0 checked>
                <label class="form-check-label" for="contracted2">
                    Not contracted
                </label>
            </div>
        </div>
        @endif
        {{-- End Rows --}}
        <div class="row">
            <div class="col md-12">
                <button class="btn edit-btn" id="Submitbutton" type="submit">Update</button>
            </div>
        </div>
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
