<?php
use App\Http\Controllers\{ApiController, AuthApiController, DashboardController,BarcodeController, HomeController, KelasController, MahasiswaController};
use Illuminate\Support\Facades\{Auth, Route};
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
     return view('auth.login');
	
});

// Auth::routes();
 Route::post('/loginApi', [AuthApiController::class, 'login'])->name('login.authApi');
 Route::get('/logoutApi', [AuthApiController::class, 'logout'])->name('logout.authApi');

Route::get('/loginsso', [AuthApiController::class, 'loginsso'])->name('login.authsso');
Route::get('/logoutsso', [AuthApiController::class, 'logoutsso'])->name('logout.authsso');


Route::middleware(['auth.api'])->group(function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home');
   Route::get('/homedosen', [HomeController::class, 'homedosen'])->name('homedosen');
    Route::get('/getSmt/{id}', [KelasController::class, 'getSmt'])->name('get.smt');

    Route::middleware(['check.level:dosen'])->group(function () {     

        Route::post('/getPertemuan', [KelasController::class, 'getPertemuan'])->name('get.pertemuan');
        Route::get('/getKelas/{id}/{fak}/{nip}', [KelasController::class, 'getKelas'])->name('get.kelas');

        Route::get('/kelas', [KelasController::class, 'index'])->name('kelas.index');
        Route::get('/kelas/detail/{id}/{fak}/{nip}', [KelasController::class, 'show'])->name('kelas.show');

        // Route::middleware(['auth.api'])->group(function () {   
            Route::get('/kelas/report/pesertakelas/{id}/{fak}/{nip}', [KelasController::class, 'showReportPesertaKelas'])->name('kelas.show.report.pesertakelas');
        // });
        
        Route::get('/kelas/pertemuan/add/{fak}/{kls}/{nip}', [KelasController::class, 'createPertemuan'])->name('kelas.pertemuan.create');
        Route::post('/kelas/pertemuan/add', [KelasController::class, 'createPertemuanStore'])->name('kelas.pertemuan.store');	
        
        Route::get('/kelas/pertemuan/ubah/{kls}/{preskls}', [KelasController::class, 'ubahPertemuan'])->name('kelas.pertemuan.ubah');
        Route::post('/kelas/pertemuan/ubah', [KelasController::class, 'ubahPertemuanStore'])->name('kelas.pertemuan.ubah.store');
        
        Route::get('/kelas/pertemuan/detail/{presklsid}/{fakid}', [KelasController::class, 'showPertemuan'])->name('kelas.pertemuan.show');
        
        Route::get('/kelas/pertemuan/edit/{presklsid}/{fakid}/{mhsPresId}', [KelasController::class, 'editPertemuan'])->name('kelas.pertemuan.edit');
        Route::post('/kelas/pertemuan/edit', [KelasController::class, 'editPertemuanStore'])->name('kelas.pertemuan.update');
        Route::get('/kelas/report/materi/{id}', [KelasController::class, 'showReportMateri'])->name('kelas.show.report.materi');
		Route::get('kelas/barcode/create/{klsId}/{klsFakId}/{nip}', [BarcodeController::class, 'create'])->name('kelas.barcode.create');
        
    });

    Route::middleware(['check.level:mahasiswa'])->prefix('mahasiswa')->group(function () {     

        Route::get('absensi/report', [MahasiswaController::class, 'absensiReport'])->name('mhs.absensi.report.list');
        Route::post('absensi/report', [MahasiswaController::class, 'absensiReport'])->name('mhs.absensi.report.load');
		Route::get('absensi/ambilabsensi', [MahasiswaController::class, 'ambilabsensi'])->name('mhs.absensi.ambilperkuliahan');
		Route::post('absensi/scan-qr', [MahasiswaController::class, 'receiveQr'])->name('mhs.qr.receive');

    });

	//END POINT REST API INTERNAL
	Route::prefix('restapi')->group(function () {
		Route::get('/test', [ApiController::class, 'index'])->name('api.test');
	});

});