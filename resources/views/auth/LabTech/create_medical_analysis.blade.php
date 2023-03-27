@extends('layouts.TechniciansApp')

@section('title')
    {{ 'Create Medical Analysis' }}
@endsection

@section('content')
    @php
    if (Auth::guard('medical_person')->user()->type === 'analysis') {
        $url = 'laboratory-technician.medcialAnalysis.store';
    } elseif (Auth::guard('medical_person')->user()->type === 'radiograph') {
        $url = 'radiograph-technician.radiographAnalysis.store';
    }
    @endphp
    <form action="{{ route($url) }}" method="POST" enctype="multipart/form-data">
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
        <input id="visiting_id" name="visiting_id" type="hidden" value="{{ $visiting_id }}">
        {{-- <input id="medical_person_id" name="medical_person_id" type="hidden" value="{{$visit->id}}">
            <input id="patient_id" name="patient_id" type="hidden" value="{{$visit->id}}"> --}}
        {{-- Row Three --}}
        <div class="form-row">
            <div class="col-sm-12 mb-3">
                <label for="content">Medical Information</label>
                <div class="input-group" value="{{ old('content') }}">
                    <textarea class="form-control" aria-label="With textarea" id="medical-content" name="content"
                        placeholder="Information about the Patient state"></textarea>
                    @error('content')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-row">
            <div class="col-sm-12 mb-3">
                <label for="formFileMultiple" class="form-label">Multiple files input example</label>
                <input class="form-control" type="file" name="photos[]" id="_photos" multiple />
            </div>
        </div>

        <div class="form-row">
            <div class="col-sm-12 mb-3">
                <button class="btn btn-primary" id="Submitbutton" type="submit" style="width: 80px">Add +</button>
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
