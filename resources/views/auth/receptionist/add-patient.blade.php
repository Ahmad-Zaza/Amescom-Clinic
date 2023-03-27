@extends('layouts.ReceptionistApp')

@section('title')
    {{ 'Add Patient' }}
@endsection

@section('content')
    <form action="{{ route('receptionist.patient.store') }}" method="POST">
        @csrf
        {{-- Row one --}}
        <div class="form-row">
            <div class="col-sm-6 mb-3">
                <label for="firstName">First name *</label>
                <input type="text" class="form-control" id="_firstName" name="firstName" placeholder="First name"
                    value="{{ old('firstName') }}" required>
                @if ($errors->has('firstName'))
                    <div class="error" style="color: red;">{{ $errors->first('firstName') }}</div>
                @endif

            </div>
            <div class="col-sm-6 mb-3 ">
                <label for="fatherName">Father name *</label>
                <input type="text" class="form-control" id="_fatherName" name="fatherName" placeholder="father name"
                    value="{{ old('fatherName') }}" required>
                @if ($errors->has('fatherName'))
                    <div class="error" style="color: red;">{{ $errors->first('fatherName') }}</div>
                @endif
            </div>
        </div>
        {{-- Row two --}}
        <div class="form-row">
            <div class="col-sm-6 mb-3 ">
                <label for="lastName">Last name *</label>
                <input type="text" class="form-control" id="_lastName" name="lastName" placeholder="Last name"
                    value="{{ old('lastName') }}" required>
                @if ($errors->has('lastName'))
                    <div class="error" style="color: red;">{{ $errors->first('lastName') }}</div>
                @endif
            </div>
            <div class="col-sm-6 mb-3 ">
                <label for="phoneNumber">Phone Number *</label>
                <input type="text" class="form-control" id="_phoneNumber" name="phoneNumber" placeholder="Phone Number"
                    value="{{ old('phoneNumber') }}" required>
                @if ($errors->has('phoneNumber'))
                    <div class="error" style="color: red;">{{ $errors->first('phoneNumber') }}</div>
                @endif
            </div>
        </div>
        {{-- Row Three --}}
        <div class="form-row">

            <div class="col-sm-6 mb-3">

                <label for="bloodSympol">Blood Sympol *</label>
                <input type="text" class="form-control" id="_bloodSympol" name="bloodSympol" placeholder="Blood Sympol"
                    value="{{ old('bloodSympol') }}" required>
                @if ($errors->has('bloodSympol'))
                    <div class="error" style="color: red;">{{ $errors->first('bloodSympol') }}</div>
                @endif
            </div>
            <div class="col-sm-6 mb-3">
                <label for="nationaltyID">Nationalty ID *</label>
                <input type="text" class="form-control" id="nationaltyID" name="nationaltyID" placeholder="Nationalty ID"
                    value="{{ old('nationaltyID') }}" required>

                @if ($errors->has('nationaltyID'))
                    <div class="error" style="color: red;">{{ $errors->first('nationaltyID') }}</div>
                @endif

            </div>
        </div>
        {{-- Row Four --}}
        <div class="form-row">
            <div class="col-sm-6 mb-3 ">
                <label for="gender" style="font-size: 15px">Choose the gender *</label>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="_gender" value="Male" checked>
                    <label class="form-check-label" for="gender1">
                        Male
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" id="_gender" value="Female">
                    <label class="form-check-label" for="gender2">
                        Female
                    </label>
                </div>
            </div>
        </div>

        {{-- Row Five --}}

        {{-- End Rows --}}
        <button class="btn btn-primary" type="submit">Add +</button>
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
    </script>
@endsection
