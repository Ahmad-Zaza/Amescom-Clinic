@extends('layouts.DoctorApp')

@section('title')
    {{ 'Doctor Dashboard' }}
@endsection

@section('content')
    <div class="row">
        <div class="col md-12">
            <form class="search-form" action="{{ route('doctor.patients-search') }}" method="GET">
                <div class="form-row">
                    <div class="col-md-9">
                        <input type="text" class="form-control" name="search" placeholder="search for a patient"
                            required />
                    </div>
                    <div class="col-sm-3">
                        <button class="btn btn-info search-button" id="Submitbutton" type="submit">Search</button>
                    </div>
                </div>
        </div>
        </form>
    </div>
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
