@extends('layouts.DoctorApp')

@section('title')
    {{ 'Medical History' }}
@endsection

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-4 col-xl-4">
                <a href="{{ route('doctor.patient.prescriptions', ['patient_id' => Crypt::encrypt($patient_id)]) }}">
                    <div class="card bg-c-green order-card">
                        <div class="card-block">
                            <h6 class="m-b-20">Prescriptions</h6>
                            <h2 class="text-right">
                                <span>{{ $perscriptions_count }}</span>
                            </h2>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4 col-xl-4">
                <a href="{{ route('doctor.patient.medicalAnalyses', ['patient_id' => Crypt::encrypt($patient_id)]) }}">
                    <div class="card bg-c-yellow order-card">
                        <div class="card-block">
                            <h6 class="m-b-20">Medical Analysises</h6>
                            <h2 class="text-right">
                                <span>{{ $medicalAnalysis_count }}</span>
                            </h2>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4 col-xl-4">
                <a href="{{ route('doctor.patient.radiographAnalyses', ['patient_id' => Crypt::encrypt($patient_id)]) }}">
                    <div class="card bg-c-pink order-card">
                        <div class="card-block">
                            <h6 class="m-b-20">Radiograph Analysises</h6>
                            <h2 class="text-right">
                                <span>{{ $radiographs_count }}</span>
                            </h2>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
