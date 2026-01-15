<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\WorkshopReportController;
use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::get('/session-test', function () {
    session(['teste' => 'funcionou']);
    return 'Sessão gravada. <a href="/session-check">Checar</a>';
});

Route::get('/session-check', function () {
    return session('teste', 'FALHA: Sessão perdida');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::patch('/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.updateAvatar');
    });
    
    Route::prefix('reports')->group(function () {
        Route::get('/', [WorkshopReportController::class, 'index'])->name('reports.index');
        Route::get('/new', [WorkshopReportController::class, 'create'])->name('reports.create');
        Route::post('/store', [WorkshopReportController::class, 'store'])->name('reports.store');
        Route::get('/{report}', [WorkshopReportController::class, 'show'])->name('reports.show');
        Route::delete('/{report}', [WorkshopReportController::class, 'delete'])->name('reports.delete');
        Route::get('/{report}/edit', [WorkshopReportController::class, 'edit'])->name('reports.edit');
        Route::put('/{report}', [WorkshopReportController::class, 'update'])->name('reports.update');
    });
    
    Route::prefix('classes')->group(function () {
        Route::get('/', [SchoolClassController::class, 'index'])->name('classes.index');
        Route::get('/new', [SchoolClassController::class, 'create'])->name('classes.create');
        
        Route::middleware('role:admin,manager')->group(function () {
            Route::post('/store', [SchoolClassController::class, 'store'])->name('classes.store');
            Route::get('/trashed', [SchoolClassController::class, 'trashed'])->name('classes.trashed');
            Route::patch('/{class}/restore', [SchoolClassController::class, 'restore'])->name('classes.restore')->withTrashed();
            Route::get('/{class}/edit', [SchoolClassController::class, 'edit'])->name('classes.edit');
            Route::put('/{class}', [SchoolClassController::class, 'update'])->name('classes.update');
            Route::delete('/{class}', [SchoolClassController::class, 'destroy'])->name('classes.destroy');
            Route::delete('/{class}/delete', [SchoolClassController::class, 'delete'])->name('classes.delete')->withTrashed();
            
        });
        Route::get('/{class}', [SchoolClassController::class, 'show'])->name('classes.show');
    });
    
    Route::middleware('role:admin,manager')->group(function () {
        Route::prefix('instructors')->group(function () {
            Route::get('/', [InstructorController::class, 'index'])->name('instructors.index');
            Route::get('/new', [InstructorController::class, 'create'])->name('instructors.create');
            Route::post('/store', [InstructorController::class, 'store'])->name('instructors.store');
            Route::get('/trashed', [InstructorController::class, 'trashed'])->name('instructors.trashed');
            
            Route::get('/{instructor}', [InstructorController::class, 'show'])->name('instructors.show');
            Route::get('/{instructor}/edit', [InstructorController::class, 'edit'])->name('instructors.edit');
            Route::put('/{instructor}', [InstructorController::class, 'update'])->name('instructors.update');
            Route::delete('/{instructor}', [InstructorController::class, 'destroy'])->name('instructors.destroy');
            Route::patch('/{instructor}/restore', [InstructorController::class, 'restore'])->name('instructors.restore')->withTrashed();
            Route::delete('/{instructor}/delete', [InstructorController::class, 'delete'])->name('instructors.delete')->withTrashed();
        });
    });
});


Route::get('/seeders', function () {
    try {
        Artisan::call('migrate:fresh');
        Artisan::call('db:seed');
        return "<h1>Seeders executados!</h1> <p>Agora volte para a home e dê um Refresh.</p>";

    } catch (\Exception $e) {
        return "Erro no seed: " . $e->getMessage();
    }
});

Route::get('/limpar-cache-geral', function () {
    try {
        Artisan::call('view:clear');   // O mais importante
        Artisan::call('config:clear'); // Limpa config
        Artisan::call('cache:clear');  // Limpa cache de aplicação
        return "<h1>Caches Limpos!</h1> <p>Agora volte para a home e dê um Refresh.</p>";
    } catch (\Exception $e) {
        return "Erro ao limpar: " . $e->getMessage();
    }
});

Route::get('/debug-deploy', function () {
    // 1. Caminho da pasta de build
    $path = public_path('build/assets');
    
    // 2. Verificar se a pasta existe
    if (!File::exists($path)) {
        return "ERRO CRÍTICO: A pasta $path NÃO EXISTE. O 'npm run build' falhou no Dockerfile.";
    }

    // 3. Listar arquivos
    $files = File::files($path);
    $fileList = [];
    foreach ($files as $file) {
        $fileList[] = $file->getFilename();
    }

    // 4. Ler o manifesto
    $manifestPath = public_path('build/manifest.json');
    $manifest = File::exists($manifestPath) ? json_decode(File::get($manifestPath), true) : 'MANIFESTO NÃO ENCONTRADO';

    return [
        'pasta_publica' => public_path(),
        'arquivos_no_disco' => $fileList,
        'conteudo_manifesto' => $manifest,
        'url_gerada_pelo_laravel' => asset('build/assets/teste.css'),
    ];
});
require __DIR__.'/auth.php';
