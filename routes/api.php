<?php

use App\Http\Controllers\Api\V1\AssetAssignmentController;
use App\Http\Controllers\Api\V1\Auth\LoginController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\ClientController;
use App\Http\Controllers\Api\V1\DailyProjectReportController;
use App\Http\Controllers\Api\V1\JobTypeController;
use App\Http\Controllers\Api\V1\MaintenanceLogController;
use App\Http\Controllers\Api\V1\MaterialController;
use App\Http\Controllers\Api\V1\PermissionController;
use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\ProjectExpenseController;
use App\Http\Controllers\Api\V1\ProjectWorkItemController;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\V1\StockMovementController;
use App\Http\Controllers\Api\V1\SupplierController;
use App\Http\Controllers\Api\V1\ToolController;
use App\Http\Controllers\Api\V1\UserController;
use App\Http\Controllers\Api\V1\VehicleAssignmentController;
use App\Http\Controllers\Api\V1\VehicleController;
use App\Http\Controllers\Api\V1\WarehouseController;
use App\Http\Controllers\Api\V1\WorkActivityLogController;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Endpoint Otentikasi (Publik)
 */
Route::post('/v1/login', [LoginController::class, 'login']);
Route::post('/v1/register', [RegisterController::class, 'register']);

/**
 * Endpoint wajib terotentikasi
 */
Route::middleware('auth:sanctum')->group(function () {
    // --- Otentikasi ---
    Route::post('/v1/logout', [LoginController::class, 'logout']);
    Route::get('/v1/user', function (Request $request) {
        return $request->user()->load('roles');
    });

    // -- Modul Projects ---
    Route::apiResource('/v1/projects', ProjectController::class);
    Route::apiResource('/v1/job-types', JobTypeController::class);
    Route::apiResource('projects.work-items', ProjectWorkItemController::class)
        ->scoped()
        ->shallow();
    Route::apiResource('projects.daily-reports', DailyProjectReportController::class)
        ->scoped()
        ->shallow();
    Route::apiResource('daily-reports.activity-logs', WorkActivityLogController::class)
        ->scoped()
        ->shallow();
    Route::apiResource('projects.expenses', ProjectExpenseController::class)
        ->scoped()
        ->shallow();

    // --- Modul Inventory & Materials ---
    Route::apiResource('/v1/tools', ToolController::class);
    Route::apiResource('/v1/materials', MaterialController::class);
    Route::apiResource('/v1/suppliers', SupplierController::class);
    Route::apiResource('/v1/warehouses', WarehouseController::class);
    // Log pergerakan stok
    Route::apiResource('/v1/stock-movements', StockMovementController::class)->only(['index', 'show', 'store']);
    Route::apiResource('/v1/asset-assignments', AssetAssignmentController::class);

    // --- Modul Kendaraan & Alat Berat ---
    Route::apiResource('/v1/vehicles', VehicleController::class);
    Route::apiResource('/v1/maintenance-logs', MaintenanceLogController::class);
    Route::apiResource('/v1/vehicle-assignments', VehicleAssignmentController::class);

    // --- Modul User & Manajemen Hak Akses ---
    Route::apiResource('/v1/clients', ClientController::class);
    Route::apiResource('/v1/users', UserController::class);
    Route::apiResource('/v1/roles', RoleController::class);
    Route::get('/v1/permissions', [PermissionController::class, 'index']);

    // --- Utility Endpoints (Dropdown) ---
    // Route::prefix('/v1/lists')->controller(ListController::class)->group(function () {
    //     Route::get('/clients', 'clients');
    //     Route::get('/warehouses', 'warehouses');
    //     Route::get('/project-managers', 'projectManagers');
    //     Route::get('/projects', 'projects');
    //     Route::get('/materials', 'materials');
    //     Route::get('/tools', 'tools');
    //     Route::get('/users', 'users');
    // });
});
