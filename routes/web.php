<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Global\CountDownController;
use App\Http\Controllers\Global\ShowVideoController;
use App\Http\Controllers\Admin\UserController as User;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController as Login;
use App\Http\Controllers\Quiz\EssayController as Essay;
use App\Http\Controllers\Admin\KelasController as Kelas;
use App\Http\Controllers\Dosen\ModulController as Modul;
use App\Http\Controllers\Admin\MatkulController as Matkul;
use App\Http\Controllers\Global\DashboardController as Dash;
use App\Http\Controllers\Global\SettingController as Setting;
use App\Http\Controllers\Admin\SemesterController as Semester;
use App\Http\Controllers\Quiz\DraggableController as Draggable;
use App\Http\Controllers\Dosen\ClassRecapController as ClassRecap;
use App\Http\Controllers\Dosen\ModulVideoController as ModulVideo;
use App\Http\Controllers\Quiz\MultipleChoiceController as MultipleChoice;
use App\Http\Controllers\Quiz\QuizManagementController as QuizManagement;
use App\Http\Controllers\Global\ChangePasswordController as ChangePassword;
use App\Http\Controllers\Mahasiswa\AssesmentRecapController as AssesmentRecap;
use Illuminate\Support\Facades\Artisan;



Route::get('/storage_link', function (){ 
    Artisan::call('storage:link'); 
});

// Route::get('/storage', function(){
//     \Artisan::call('storage:link');
//     return "Se han vinculado las imágenes";
// });

Route::get('/storage-link', function(){
	$targetFolder = storage_path('app/public');
	$linkFolder = $_SERVER['DOCUMENT_ROOT'] . '/storage';
	symlink($targetFolder,$linkFolder);
});

// auth routes
Route::get('/', [Login::class, 'showLogin'])->name('login');
Route::post('/handleLogin', [Login::class, 'handleLogin'])->name('handleLogin');
Route::post('/handleLogout', [Login::class, 'handleLogout'])->name('handleLogout');

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});

Route::middleware('auth')->group(function () {
    // dashboard routes
    Route::get('/dashboard', [Dash::class, 'showDashboard'])->name('dashboard');

    // users routes
    Route::middleware('role:admin')->prefix('/users')->group(function () {
        Route::get('/dosen', [User::class, 'showDosen'])->name('dosen');
        Route::get('/mahasiswa', [User::class, 'showMahasiswa'])->name('mahasiswa');
        Route::post('/create_user', [User::class, 'create_user']);
        Route::post('/hapus_user/{user_id}', [User::class, 'hapus_user']);
        Route::post('/update_user/{user_id}', [User::class, 'update_user']);
        Route::get('/template', [User::class, 'createTemplate'])->name('template');
        Route::post('/import', [User::class, 'import'])->name('import');
    });


    // learning routes
    Route::prefix('/learning')->group(function () {
        // modul routes
        Route::get('/modul', [Modul::class, 'showModul'])->name('modul');
        Route::get('/detail_modul/{modul_id}', [Modul::class, 'detail_modul']);
        Route::middleware('role:dosen')->group(function () {
            Route::post('/create_modul', [Modul::class, 'create_modul']);
            Route::post('/hapus_modul/{modul_id}', [Modul::class, 'hapus_modul']);
            Route::post('/update_modul/{modul_id}', [Modul::class, 'update_modul']);
        });
        // public function showModulVideo($id)

        Route::get('/modul-video-{id}', [ModulVideo::class, 'showModulVideo'])->name('modul_video');
        Route::get('/detail_modul_video/{modul_video_id}', [ModulVideo::class, 'detail_modul_video']);
        Route::middleware('role:dosen')->group(function () {
            Route::post('/create_modul_video/{id}', [ModulVideo::class, 'create_modul_video'])->name('modul_video.store');
            Route::delete('/delete_modul_video/{modul_video_id}', [ModulVideo::class, 'delete_modul_video'])->name('delete_modul_video');
            Route::put('/UpdateModulVideo/{modul_video_id}', [ModulVideo::class, 'UpdateModulVideo'])->name('UpdateModulVideo');
        });

        Route::get('/modul_video/show/{id}', [ShowVideoController::class, 'showModulVideo'])->name('modul_video.show');

        Route::middleware('role:admin')->group(function () {
            // matkul routes
            Route::get('/matkul', [Matkul::class, 'showMatkul'])->name('matkul');
            Route::post('/create_matkul', [Matkul::class, 'create_matkul']);
            Route::post('/hapus_matkul/{matkul_id}', [Matkul::class, 'hapus_matkul']);
            Route::post('/update_matkul/{matkul_id}', [Matkul::class, 'update_matkul']);

            // kelas routes
            Route::get('/kelas', [Kelas::class, 'showKelas'])->name('kelas');
            Route::post('/create_kelas', [Kelas::class, 'create_kelas']);
            Route::post('/hapus_kelas/{kelas_id}', [Kelas::class, 'hapus_kelas']);
            Route::post('/update_kelas/{kelas_id}', [Kelas::class, 'update_kelas']);

            // semester routes
            Route::get('/semester', [Semester::class, 'showSemester'])->name('semester');
            Route::post('/create_semester', [Semester::class, 'create_semester']);
            Route::post('/hapus_semester/{semester_id}', [Semester::class, 'hapus_semester']);
            Route::post('/update_semester/{semester_id}', [Semester::class, 'update_semester']);
        });
    });

    // quiz management
    Route::middleware('role:dosen')->group(function () {
        Route::get('/quiz', [QuizManagement::class, 'showQuiz'])->name('quiz');
        Route::post('/create_quiz', [QuizManagement::class, 'create_quiz']);
        Route::post('/hapus_quiz/{quiz_id}', [QuizManagement::class, 'hapus_quiz']);
        Route::post('/update_quiz/{quiz_id}', [QuizManagement::class, 'update_quiz']);
    });

    // essay, mc and draggable route
    Route::middleware('role:mahasiswa')->group(function () {
        Route::get('/multiple_choice', [MultipleChoice::class, 'index'])->name('multiple_choice');
        Route::get('/essay', [Essay::class, 'index'])->name('essay');
        Route::get('/draggable', [Draggable::class, 'index'])->name('draggable');
        Route::get('/confirm/{quiz_id}', [QuizManagement::class, 'confirm'])->name('confirm');
    });

    Route::middleware('role:mahasiswa,dosen,admin')->group(function () {
        Route::get('/results/{quiz_id}/{user_id}', [QuizManagement::class, 'result_quiz']);
    });

    Route::get('/countdown/{quiz_id}', [CountDownController::class, 'getTime']);
    Route::post('/countdown/{quiz_id}', [CountdownController::class, 'updateTime']);


    // multiple choice
    Route::prefix('/multiple_choice')->group(function () {
        Route::middleware('role:dosen')->group(function () {
            Route::get('/master/{quiz_id}', [MultipleChoice::class, 'master']);
            Route::get('/create_question/{quiz_id}', [MultipleChoice::class, 'showCreateQuestion']);
            Route::post('/create_mc', [MultipleChoice::class, 'create_mc']);
            Route::get('/detail/{quiz_id}/{question_id}', [MultipleChoice::class, 'detail_mc']);
            Route::post('/hapus_mc/{question_id}', [MultipleChoice::class, 'hapus_mc']);
            Route::post('/update_mc/{question_id}', [MultipleChoice::class, 'update_mc']);
            Route::get('/review/{quiz_id}', [MultipleChoice::class, 'review_mc']);
        });

        Route::middleware('role:mahasiswa')->group(function () {
            Route::get('/attempt/{quiz_id}/{user_id}', [MultipleChoice::class, 'attempt_quiz']);
            Route::post('/save_answer/{quiz_id}', [MultipleChoice::class, 'save_answer']);
        });
    });

    // essay
    Route::prefix('/essay')->group(function () {
        Route::middleware('role:dosen')->group(function () {
            Route::get('/master/{quiz_id}', [Essay::class, 'master']);
            Route::get('/create_essay/{quiz_id}', [Essay::class, 'showCreateEssay']);
            Route::post('/create_essay', [Essay::class, 'create_essay']);
            Route::get('/detail/{quiz_id}/{essay_id}', [Essay::class, 'detail_essay']);
            Route::post('/hapus_essay/{essay_id}', [Essay::class, 'hapus_essay']);
            Route::post('/update_essay/{essay_id}', [Essay::class, 'update_essay']);
            Route::get('/review/{quiz_id}', [Essay::class, 'review_essay']);
            Route::get('/detail_review/{quiz_id}/{user_id}', [Essay::class, 'detail_review']);
            Route::post('/pratinjau/{quiz_id}', [Essay::class, 'pratinjau']);
        });

        Route::middleware('role:mahasiswa')->group(function () {
            Route::get('/attempt/{quiz_id}/{user_id}', [Essay::class, 'attempt_quiz']);
            Route::post('/save_answer/{quiz_id}', [Essay::class, 'save_answer']);
        });
    });

    // draggable
    Route::prefix('/draggable')->group(function () {
        Route::middleware('role:dosen')->group(function () {
            Route::get('/master/{quiz_id}', [Draggable::class, 'master']);
            Route::get('/create_draggable/{quiz_id}', [Draggable::class, 'showCreateDraggable']);
            Route::post('/create_draggable', [Draggable::class, 'create_draggable']);
            Route::get('/detail/{quiz_id}/{draggable_id}', [Draggable::class, 'detail_draggable']);
            Route::post('/hapus_draggable/{draggable_id}', [Draggable::class, 'hapus_draggable']);
            Route::post('/update_draggable/{draggable_id}', [Draggable::class, 'update_draggable']);
            Route::get('/manage_options/{quiz_id}', [Draggable::class, 'manage_options']);
            Route::post('/create_option', [Draggable::class, 'create_option']);
            Route::post('/hapus_option/{draggable_opt_id}', [Draggable::class, 'hapus_option']);
            Route::post('/update_option/{draggable_opt_id}', [Draggable::class, 'update_option']);
            Route::get('/review/{quiz_id}', [Draggable::class, 'review_draggable']);
        });

        Route::middleware('role:mahasiswa')->group(function () {
            Route::get('/attempt/{quiz_id}/{user_id}', [Draggable::class, 'attempt_quiz']);
            Route::post('/save_answer/{quiz_id}', [Draggable::class, 'save_answer']);
        });
    });

    Route::get('/assesment_recap', [AssesmentRecap::class, 'showAssesmentRecap'])->name('assesment_recap');
    Route::get('/class_recap', [ClassRecap::class, 'showClassRecap'])->name('class_recap');
    //Route::get('/assesment-recap/export', [AssesmentRecap::class, 'exportToCsv']);
    Route::match(['get', 'post'], '/assesment-recap/export', [AssesmentRecap::class, 'exportToCsv']);


    // edit profil
    Route::prefix('/setting')->group(function () {
        // update profil routes
        Route::get('/edit_profil', [Setting::class, 'showEditProfil'])->name('edit_profil');
        Route::post('/handle_update_profil', [Setting::class, 'handle_update_profil']);
    });

    // change password
    Route::get('/change_password', [ChangePassword::class, 'showChangePassword'])->name('change_password');
    Route::post('/update_password', [ChangePassword::class, 'update_password']);

    // forgot and Reset Password
    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->middleware('auth')->name('password.request');
});
