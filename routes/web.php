<?php

use App\Http\Controllers\Admin\DoctorController as AdminDoctorController;
use App\Http\Controllers\Admin\LaboratoryTechnicianController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\RadiographController;
use App\Http\Controllers\Admin\RadiographTechniciansController;
use App\Http\Controllers\Admin\VisitingController;
use App\Http\Controllers\Auth\AdminController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Doctor\DoctorController;
use App\Http\Controllers\Doctor\MedicalAnalysisController;
use App\Http\Controllers\Doctor\PatientController as DoctorPatientController;
use App\Http\Controllers\Doctor\PrescriptionController;
use App\Http\Controllers\Doctor\RadiographAnalysisController as DoctorRadiographAnalysisController;
use App\Http\Controllers\Doctor\VisitingController as DoctorVisitingController;
use App\Http\Controllers\RadTech\RadiographAnalysisController;
use App\Http\Controllers\Receptionist\PatientController as ReceptionistPatientController;
use App\Http\Controllers\Receptionist\ReceptionistController;
use App\Http\Controllers\Receptionist\VisitingController as ReceptionistVisitingController;
use App\Http\Controllers\Technician\LabTechController as TechnicianLabTechController;
use App\Http\Controllers\Technician\MedicalAnalysisController as TechnicianMedicalAnalysisController;
use App\Http\Controllers\Technician\PatientController as TechnicianPatientController;
use App\Http\Controllers\Technician\VisitingController as TechnicianVisitingController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;



Auth::routes();

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['guest:admin'])->group(function () {
        //routes
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::post('avatar', [AdminController::class, 'addAvatar'])->name('avatar.store');
        Route::get('/doctors', [AdminDoctorController::class, 'getDoctorsPage'])->name('doctors');
        Route::get('/aboratoryTechnicians', [LaboratoryTechnicianController::class, 'getLabTechPage'])->name('labTechs');
        Route::get('patients', [PatientController::class, 'getPatientsPage'])->name('patients');
        Route::get('/radiograph-Technicians', [RadiographTechniciansController::class, 'getRadiographTechPage'])->name('radiographs');
        Route::get('/visiting-Shcedule', [VisitingController::class, 'getVisitingPage'])->name('visitings');
        Route::get('/doctor/create', [AdminDoctorController::class, 'showAddForm'])->name('create.doctor');
        //search route
        Route::get('/search-doctor/action', [AdminDoctorController::class, 'action'])->name('search-doctor.action');
        Route::get('/laboratory-technician/create', [LaboratoryTechnicianController::class, 'showAddForm'])->name('create.labTech');
        Route::get('/radiograph-technician/create', [RadiographTechniciansController::class, 'showAddForm'])->name('create.radTech');
        Route::get('/edit-doctor/{doctor_id}', [AdminDoctorController::class, 'getEditForm'])->name('edit-doctor');
        Route::get('/edit-laboratoryTech/{labTech_id}', [LaboratoryTechnicianController::class, 'getEditForm'])->name('edit-laboratoryTech');
        Route::get('/edit-radiographTech/{radTech_id}', [RadiographTechniciansController::class, 'getEditForm'])->name('edit-radiographTech');
        Route::post('/laboratory-technician/store', [LaboratoryTechnicianController::class, 'store'])->name('create.labTech.store');
        Route::post('/radiograph-technician/store', [RadiographTechniciansController::class, 'store'])->name('create.radTech.store');
        Route::post('/doctor/store', [AdminDoctorController::class, 'store'])->name('create.doctor.store');
        Route::put('/doctor/update', [AdminDoctorController::class, 'update'])->name('edit.doctor.update');
        Route::put('/laboratory-technician/update', [LaboratoryTechnicianController::class, 'update'])->name('edit.labTech.update');
        Route::put('/radiograph-technician/update', [RadiographTechniciansController::class, 'update'])->name('edit.radTech.update');
        // Route::get('avatar', [AdminController::class, 'getAvatars'])->name('avatar.index');
    });
});
// Doctor Routes
Route::prefix('doctor')->name('doctor.')->group(function () {
    Route::middleware(['guest:medical_person'])->group(function () {
        //routes
        Route::get('/', [DoctorController::class, 'index'])->name('dashboard');
        Route::get('/current-visitings/{doctor_id}/{department_id}', [DoctorVisitingController::class, 'getCurrentVisitings'])->name('current-visitings');
        Route::get('/current-patients/{department_id}', [DoctorPatientController::class, 'getCurrentPatients'])->name('current-patients');
        Route::post('/receipt-patient', [DoctorPatientController::class, 'receiptPatient'])->name('receipt-patient');
        Route::post('/transfer-patient', [DoctorPatientController::class, 'transferPatient'])->name('transfer-patient');
        Route::get('/create-prescription/{visiting_id}', [PrescriptionController::class, 'showPrescriptionForm'])->name('create-prescription');
        Route::post('/create-prescription', [PrescriptionController::class, 'store'])->name('prescriptoin.store');
        Route::get('/medical-hostory/{patient_id}', [DoctorPatientController::class, 'getMedicalHistory'])->name('patient.medical-history');
        Route::get('/prescriptions/{patient_id}', [PrescriptionController::class, 'getAllPatientPrescriptions'])->name('patient.prescriptions');
        Route::get('/medical-analyses/{patient_id}', [MedicalAnalysisController::class, 'getAllPatientMedicalAnalyses'])->name('patient.medicalAnalyses');
        Route::get('/radiograph-analyses/{patient_id}', [DoctorRadiographAnalysisController::class, 'getAllPatientRadiographAnalyses'])->name('patient.radiographAnalyses');
        Route::get('/prescription/{prescription_id}', [PrescriptionController::class, 'getSinglePrescription'])->name('patient.prescription');
        Route::get('/medical-analysis/{medicalAnalysis_id}', [MedicalAnalysisController::class, 'getSingleMedicalAnalysis'])->name('patient.medicalAnalysis');
        Route::get('/radiograph-analysis/{radiographAnalysis_id}', [DoctorRadiographAnalysisController::class, 'getSingleRadiographAnalysis'])->name('patient.radiographAnalysis');
        Route::get('/edit-prescription/{prescription_id}', [PrescriptionController::class, 'getEditForm'])->name('edit-prescription');
        Route::put('/prescription/update', [PrescriptionController::class, 'update'])->name('edit.prescription.update');
        Route::get('/my-prescriptions', [PrescriptionController::class, 'getMyPrescriptions'])->name('my-prescriptions');
        Route::post('/delete-photo', [PrescriptionController::class, 'deletePhoto'])->name('delete.photo');
        Route::get('/close-visit/{visit_id}', [TechnicianVisitingController::class, 'closeState'])->name('close-medicalAnalysis');
        Route::get('/patients-search', [DoctorPatientController::class, 'search'])->name('patients-search');
    });
});

Route::prefix('laboratory-technician')->name('laboratory-technician.')->group(function () {
    Route::middleware(['guest:medical_person'])->group(function () {
        // routes
        Route::get('/', [TechnicianLabTechController::class, 'index'])->name('dashboard');
        Route::get('/current-visitings/{department_id}', [TechnicianVisitingController::class, 'getCurrentVisitings'])->name('current-visitings');
        Route::get('/current-patients/{department_id}', [TechnicianPatientController::class, 'getCurrentPatients'])->name('current-patients');
        Route::post('/receipt-patient', [TechnicianPatientController::class, 'receiptPatient'])->name('receipt-patient');
        Route::get('/create-medcial-analysis/{visiting_id}', [TechnicianMedicalAnalysisController::class, 'showMedicalAnalysisForm'])->name('create-medcialAnalysis');
        Route::post('/create-medcial-analysis', [TechnicianMedicalAnalysisController::class, 'store'])->name('medcialAnalysis.store');
        Route::get('/my-medical-analyses', [TechnicianLabTechController::class, 'getMyMedicalAnalyses'])->name('my-medicalAnalyses');
        Route::get('/edit-medical-analysis/{medAnalysis_id}', [TechnicianMedicalAnalysisController::class, 'getEditForm'])->name('edit-medicalAnalysis');
        Route::put('/medical-analysis/update', [TechnicianMedicalAnalysisController::class, 'update'])->name('edit.medicalAnalysis.update');
        Route::PUT('/delete-photo/{photo_id}', [TechnicianMedicalAnalysisController::class, 'deletePhoto'])->name('delete.photo');
        Route::get('/medical-analysis/{medicalAnalysis_id}', [TechnicianMedicalAnalysisController::class, 'getSingleMedicalAnalysis'])->name('patient.medicalAnalysis');
        Route::get('/close-visit/{visit_id}', [TechnicianVisitingController::class, 'closeState'])->name('close-medicalAnalysis');
        Route::get('/search-medical-analysis', [TechnicianPatientController::class, 'search'])->name('patient.medicalAnalyses-search');
        Route::get('/patient-medical-analyses/{patient_id}', [TechnicianLabTechController::class, 'getPatientMedicalAnalyses'])->name('patient-medicalAnalyses');
    });
});

Route::prefix('radiograph-technician')->name('radiograph-technician.')->group(function () {
    Route::middleware(['guest:medical_person'])->group(function () {
        // routes
        Route::get('/', [TechnicianLabTechController::class, 'index'])->name('dashboard');
        Route::get('/current-visitings/{department_id}', [TechnicianVisitingController::class, 'getCurrentVisitings'])->name('current-visitings');
        Route::get('/current-patients/{department_id}', [TechnicianPatientController::class, 'getCurrentPatients'])->name('current-patients');
        Route::post('/receipt-patient', [TechnicianPatientController::class, 'receiptPatient'])->name('receipt-patient');
        Route::get('/create-radiograph-analysis/{visiting_id}', [TechnicianMedicalAnalysisController::class, 'showMedicalAnalysisForm'])->name('create-radiographAnalysis');
        Route::post('/create-radiograph-analysis', [RadiographAnalysisController::class, 'store'])->name('radiographAnalysis.store');
        Route::get('/my-radiograph-analyses', [RadiographAnalysisController::class, 'getMyRadiographAnalyses'])->name('my-radiographAnalyses');
        Route::get('/edit-radiograph-analysis/{radAnalysis_id}', [RadiographAnalysisController::class, 'getEditForm'])->name('edit-radiographAnalysis');
        Route::put('/radiograph-analysis/update', [RadiographAnalysisController::class, 'update'])->name('edit.radiographAnalysis.update');
        Route::PUT('/delete-photo/{photo_id}', [RadiographAnalysisController::class, 'deletePhoto'])->name('delete.photo');
        Route::get('/radiograph-analysis/{radiographAnalysis_id}', [RadiographAnalysisController::class, 'getSingleradiographAnalysis'])->name('patient.radiographAnalysis');
        Route::get('/close-visit/{visit_id}', [TechnicianVisitingController::class, 'closeState'])->name('close-medicalAnalysis');
        Route::get('/search-radiograph-analyses', [TechnicianPatientController::class, 'searchRad'])->name('patient.radiographAnalysis-search');
        Route::get('/patient-radiograph-analyses/{patient_id}', [TechnicianLabTechController::class, 'getPatientRadiographAnalyses'])->name('patient-radiographAnalyses');
    });
});


Route::prefix('receptionist')->name('receptionist.')->group(function () {
    Route::middleware(['guest:reception'])->group(function () {
        //routes
        Route::get('/', [ReceptionistController::class, 'index'])->name('dashboard');
        Route::get('/patients', [ReceptionistPatientController::class, 'getPatientsPage'])->name('patients');
        Route::get('/visiting-Shcedule', [ReceptionistVisitingController::class, 'getVisitingPage'])->name('visitings');
        Route::post('/transfer-patient/{patient_id}', [ReceptionistPatientController::class, 'transferPatient'])->name('transfer-patient');
        Route::get('/search/patient', [ReceptionistPatientController::class, 'getSearchPage'])->name('patient.search');
        Route::get('/add-patient', [ReceptionistPatientController::class, 'getAddForm'])->name('add.patient');
        Route::post('/add-patient', [ReceptionistPatientController::class, 'store'])->name('patient.store');
        Route::get('/edit-patient/{patient_id}', [ReceptionistPatientController::class, 'getEditForm'])->name('edit.patient');
        Route::put('/edit-patient/{patient_id}', [ReceptionistPatientController::class, 'update'])->name('patient.update');
    });
});