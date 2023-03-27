@extends('layouts.DoctorApp')

@section('title')
    {{ 'Create Prescription' }}
@endsection

@section('content')
    <form action="{{ route('doctor.prescriptoin.store') }}" method="POST" enctype="multipart/form-data">
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
                <label for="content">Prescription Information</label>
                <div class="input-group" value="{{ old('content') }}">
                    <textarea class="form-control" aria-label="With textarea" id="prescriptoin-content" name="content"
                        placeholder="Information about the prescription"></textarea>
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
                <input class="form-control" type="file" name="photos[]" id="prescriptoin_photos" multiple />
            </div>
        </div>

        <div class="form-row">
            <div class="col-sm-12 mb-3">
                <button class="btn btn-primary" id="Submitbutton" type="submit" style="width: 80px">Add +</button>
            </div>
        </div>

    </form>


    <script>
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
