@extends('layouts.TechniciansApp')

@section('title')
    {{ 'Edit Medical Analysis' }}
@endsection

@section('content')
    <style>
        .edit-btn {
            background-color: #FFC107;
            color: #FFFFFF;
        }

    </style>



    <form action="{{ route('laboratory-technician.edit.medicalAnalysis.update') }}" id="update-form" method="POST"
        enctype="multipart/form-data">
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
        <input id="medicalAnalysis_id" name="medicalAnalysis_id" type="hidden" value="{{ $medicalAnalysis->id }}">
        {{-- Row Three --}}
        <div class="form-row">
            <div class="col-sm-12 mb-3">
                <label for="content">Medical Analysis Information</label>
                <div class="input-group" value="{{ old('content') }}">
                    <textarea class="form-control" aria-label="With textarea" id="medical-content" name="content"
                        placeholder="Information about the medical analysis">
                                    {{ $medicalAnalysis->content }}
                                                                                                                                                                                                                                                                        </textarea>
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
                <label for="formFileMultiple" class="form-label">Upload medical analysis photos</label>
                <input class="form-control" type="file" name="photos[]" id="medicalAnalysis_photos" multiple />
            </div>
        </div>

        <div class="form-row">
            <div class="col-sm-12 mb-3">
                <button class="btn edit-btn" form="update-form" id="Submitbutton" type="submit"
                    style="width: 80px; margin-top:20px;">Edit</button>
            </div>
        </div>

    </form>


    @foreach ($photos as $photo)
        <div class="row" style="margin-bottom: 20px;">
            @php
                $photo_id = $photo->uuid;
            @endphp
            <div class="col-md-6">
                <img src="{{ $photo->getUrl() }}" id="profile-img-tag" height="400" width="400">
            </div>
            <form action="{{ route('laboratory-technician.delete.photo', ['photo_id' => $photo_id]) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                {{ method_field('PUT') }}
                <input type="hidden" class="form-control" name="medicalAnalysis_id" value="{{ $medicalAnalysis->id }}"
                    id="medicalAnalysis_id">
                <div class="col-md-6 ">
                    <button type="submit" class="btn btn-danger"> Delete </button>
                </div>
            </form>

        </div>
    @endforeach



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
