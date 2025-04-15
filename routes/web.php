<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CreateSpkController;
use App\Http\Controllers\ListSpkController;
use App\Http\Controllers\SampleController;
use App\Http\Controllers\SpkAssignController;
use App\Http\Controllers\MasterDataPacController;
use App\Http\Controllers\SpecialtyController;
use App\Http\Controllers\AuthenticatedSessionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PasswordController;

Route::get('/', function () {
    return redirect()->route('login'); // Mengarahkan pengguna ke halaman login
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::put('password', [PasswordController::class, 'update'])->name('password.update');

    Route::middleware('role:manager_qc,spv_qc,staff_edc')->group(function () {
        // Dashboard Page
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    });

    // Route::middleware('role:manager_qc,spv_qc,staff_edc')->group(function () {
    //     // Halaman Create SPK
    //     Route::get('/create-spk', [CreateSpkController::class, 'create'])->middleware(['auth'])->name('create_spk');
    //     // Route untuk form 1
    //     Route::post('/store-form1', [CreateSpkController::class, 'storeForm1'])->name('store.form1');
    //     // Route untuk form 2
    //     Route::post('/store-form2', [CreateSpkController::class, 'storeForm2'])->name('store.form2');
    //     // Route untuk form 3
    //     Route::post('/store-form3', [CreateSpkController::class, 'storeForm3'])->name('store.form3');
    //     // Route untuk form 4
    //     Route::post('/store-form4', [CreateSpkController::class, 'storeForm4'])->name('store.form4');
    //     // Route untuk menyimpan data Form 5
    //     Route::post('/store-form5', [CreateSpkController::class, 'storeForm5'])->name('store.form5');
    //     // auto ceklis form 1
    //     Route::get('/get-product-parameters', [CreateSpkController::class, 'getProductParameters'])->name('get.product.parameters');
    //     // Route untuk mendapatkan data code material di Form 1
    //     Route::get('/get-materials', [CreateSpkController::class, 'getMaterials'])->name('get.materials');
    //     // Route untuk mendapatkan data code material di Form 5
    //     Route::get('/get-materials-form5', [CreateSpkController::class, 'getMaterialsForm5'])->name('get.materials.form5');
    //     // Route untuk mendapatkan data code material di Form 2
    //     Route::get('/get-materials-form2', [CreateSpkController::class, 'getMaterialsForm2'])->name('get.materials.form2');
    //     // Route untuk mendapatkan data code material di Form 3
    //     Route::get('/get-materials-form3', [CreateSpkController::class, 'getMaterialsForm3'])->name('get.materials.form3');
    //     // data master product_name form 1
    //     Route::get('/api/products', [CreateSpkController::class, 'getProducts'])->name('products.get');
    //     // data master product_name form 5
    //     Route::get('/api/products5', [CreateSpkController::class, 'getProducts5'])->name('products.get5');
    //     Route::get('/api/specialty-products', [CreateSpkController::class, 'getSpecialtyProducts'])->name('specialty.products.get');
    //     // end create spk
    // });
    Route::middleware(function ($request, $next) {
        // Cek jika role pengguna adalah 'staff_qc'
        if (auth()->user()->role === 'staff_admin') {
            // Redirect staff_qc ke halaman lain, misalnya dashboard
            return redirect()->route('dashboard.index');
        }

        // Jika role bukan 'staff_qc', lanjutkan request ke route yang dituju
        return $next($request);
    })->group(function () {
        // Halaman Create SPK
        Route::get('/create-spk', [CreateSpkController::class, 'create'])->name('create_spk');
        
        // Route untuk form 1
        Route::post('/store-form1', [CreateSpkController::class, 'storeForm1'])->name('store.form1');
        
        // Route untuk form 2
        Route::post('/store-form2', [CreateSpkController::class, 'storeForm2'])->name('store.form2');
        
        // Route untuk form 3
        Route::post('/store-form3', [CreateSpkController::class, 'storeForm3'])->name('store.form3');
        
        // Route untuk form 4
        Route::post('/store-form4', [CreateSpkController::class, 'storeForm4'])->name('store.form4');
        
        // Route untuk menyimpan data Form 5
        Route::post('/store-form5', [CreateSpkController::class, 'storeForm5'])->name('store.form5');
        
        // auto ceklis form 1
        Route::get('/get-product-parameters', [CreateSpkController::class, 'getProductParameters'])->name('get.product.parameters');
        
        // Route untuk mendapatkan data code material di Form 1
        Route::get('/get-materials', [CreateSpkController::class, 'getMaterials'])->name('get.materials');
        
        // Route untuk mendapatkan data code material di Form 5
        Route::get('/get-materials-form5', [CreateSpkController::class, 'getMaterialsForm5'])->name('get.materials.form5');
        
        // Route untuk mendapatkan data code material di Form 2
        Route::get('/get-materials-form2', [CreateSpkController::class, 'getMaterialsForm2'])->name('get.materials.form2');
        
        // Route untuk mendapatkan data code material di Form 3
        Route::get('/get-materials-form3', [CreateSpkController::class, 'getMaterialsForm3'])->name('get.materials.form3');
        
        // Data master product_name form 1
        Route::get('/api/products', [CreateSpkController::class, 'getProducts'])->name('products.get');
        
        // Data master product_name form 5
        Route::get('/api/products5', [CreateSpkController::class, 'getProducts5'])->name('products.get5');
        
        // Route untuk specialty products
        Route::get('/api/specialty-products', [CreateSpkController::class, 'getSpecialtyProducts'])->name('specialty.products.get');
    });

    Route::middleware('role:manager_qc,spv_qc,staff_edc,director,staff_qc')->group(function () {
        // Route untuk Status Sample
        Route::get('/status-sample', [SampleController::class, 'statusSample'])->name('status_sample');
        // Route untuk mendapatkan detail berdasarkan ID di status sample
        Route::get('/status/detail/{id}', [SampleController::class, 'showDetail'])->name('status.show');
        // Route to update the status to "ready"
        Route::put('/status/update/{id}', [SampleController::class, 'updateStatusReady'])->name('status.update');
        // Route to update the status to "assigned"
        Route::put('/status/assign1/{id}', [SampleController::class, 'updateStatusAssigned'])->name('status.assign');
        // Route untuk mengubah status ready menjadi assigned
        Route::put('/status/assign/{id}', [SampleController::class, 'updateStatusReadyToAssigned'])->name('status.ready.assign');


        // Route untuk halaman SPK Assign
        Route::get('/spk/assign', [SpkAssignController::class, 'index'])->name('spk_assign');
        // datatabel ajax
        Route::get('/get-spk-data', [SpkAssignController::class, 'getSpkData'])->name('spk.data');

        // Route untuk mendapatkan detail berdasarkan ID di status sample
        Route::get('/assign/detail/{id}', [SpkAssignController::class, 'showDetail'])->name('assign.show');
        // filter form parameter modal 
        Route::get('/assign/spk/detail/{id}', [SpkAssignController::class, 'getSpkDetail'])->name('assign.spk.detail');
        Route::post('/get-parameters', [SpkAssignController::class, 'getParameters']);
        // Route untuk mendapatkan specialtyData
        Route::post('/get-specialty-data', [SpkAssignController::class, 'getSpecialtyData']);
        
        Route::post('/save-parameter-data', [SpkAssignController::class, 'saveParameterData'])->name('save.parameter.data');
        Route::post('/save-parameter-data2', [SpkAssignController::class, 'saveParameterData2'])->name('save.parameter.data2');
        Route::post('/save-parameter-data1', [SpkAssignController::class, 'saveParameterData1'])->name('save.parameter.data1');
        Route::post('/save-parameter-data-modal5', [SpkAssignController::class, 'saveParameterDataModal5'])->name('save.parameter.data.modal5');
    });

    // Master Data PAC (Untuk manager_qa, spv_qa, dan staff_edc)
    Route::middleware('role:manager_pdqa,spv_pdqa,staff_pdqa,staff_edc,director')->group(function () {
        // Master Data PAC
        Route::get('/master-data-pac', [MasterDataPacController::class, 'index'])->name('master_data_pac');
        Route::get('/get-pac-data', [MasterDataPacController::class, 'getPacData'])->name('get.pac.data');
        Route::post('/master-data-pac', [MasterDataPacController::class, 'store'])->name('master-data-pac.store');
        // edit data PAC
        Route::get('/get-pac/{id}', [MasterDataPacController::class, 'edit'])->name('pac.edit');
        Route::put('/update-pac/{id}', [MasterDataPacController::class, 'update'])->name('pac.update');
        // delete data PAC
        Route::delete('/delete-pac/{id}', [MasterDataPacController::class, 'destroy'])->name('delete.pac');

        // Master Data Specialty
        Route::get('/master-data/specialty', [SpecialtyController::class, 'index'])->name('master_data_specialty');
        Route::get('/specialties', [SpecialtyController::class, 'getSpecialties'])->name('specialties.get');
        Route::post('/specialties', [SpecialtyController::class, 'store'])->name('specialties.store');
        Route::delete('/delete-specialty/{id}', [SpecialtyController::class, 'destroy'])->name('delete-specialty');
        // Mengambil data specialty berdasarkan ID
        Route::get('/get-specialty/{id}', [SpecialtyController::class, 'getSpecialty'])->name('get.specialty');

        // Mengupdate data specialty berdasarkan ID
        Route::put('/update-specialty/{id}', [SpecialtyController::class, 'updateSpecialty'])->name('update.specialty');
        Route::post('/check-product-name', [SpecialtyController::class, 'checkProductName'])->name('check.product.name');
    });

    // Route untuk menampilkan list SPK bisa diakses semua user role
    Route::get('/list-spk', [ListSpkController::class, 'index'])->name('list_spk');
    // Route untuk mendapatkan detail berdasarkan ID
    Route::get('/spk/detail/{id}', [ListSpkController::class, 'show'])->name('spk.show');

    // Route untuk memperbarui data SPK
    Route::put('/spk/update/{id}', [ListSpkController::class, 'update'])->name('spk.update');

    Route::delete('/spk/{id}', [ListSpkController::class, 'destroy'])->name('spk.delete');
    // generate pdf result test
    Route::get('/spk/{spkId}/generate-pdf', [ListSpkController::class, 'generatePdf'])->name('spk.generatePdf');
    // BTN CLOSE SPK
    Route::put('/spk/close/{id}', [ListSpkController::class, 'closeSpk'])->name('spk.close');
    // btn reassign
    Route::post('/reassign-spk', [ListSpkController::class, 'reassignSpk'])->name('spk.reassign');

});

require __DIR__.'/auth.php';



