@extends('layouts.DoctorApp')

@section('title')
    {{ 'Edit Prescription' }}
@endsection

@section('content')
    <style>
        .edit-btn {
            background-color: #FFC107;
            color: #FFFFFF;
        }

    </style>



    <form action="{{ route('doctor.edit.prescription.update') }}" id="update-form" method="POST"
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
        <input id="prescription_id" name="prescription_id" type="hidden" value="{{ $prescription->id }}">
        {{-- Row Three --}}
        <div class="form-row">
            <div class="col-sm-12 mb-3">
                <label for="content">Prescription Information</label>
                <div class="input-group" value="{{ old('content') }}">
                    <textarea class="form-control" aria-label="With textarea" id="prescriptoin-content" name="content"
                        placeholder="Information about the prescription">
                                                                                {{ $prescription->content }}
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
                <label for="formFileMultiple" class="form-label">Upload Prescription photos</label>
                <input class="form-control" type="file" name="photos[]" id="prescriptoin_photos" multiple />
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
        <div class="row" style="margin-bottom: 20px">
            <div class="col-md-6 ">
                <img src="{{ $photo->getUrl() }}" id="profile-img-tag" height="400" width="400">
            </div>
            {{-- <p> i get the first url </p> --}}
            <div class="col-md-6 ">
                <form action="{{ route('doctor.delete.photo') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" class="form-control" name="prescription_id" value="{{ $prescription->id }}"
                        id="prescription_id">
                    <input type="hidden" class="form-control" name="photo" value="{{ $photo->getUrl() }}"
                        id="prescription_photo" />
                    <button type="submit" id="Submitbutton" class="btn btn-danger"> Delete </button>

                </form>
            </div>
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
