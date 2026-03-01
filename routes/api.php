<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('tasks', [TaskController::class, 'index']);        // عرض جميع المهام
Route::get('tasks/{id}', [TaskController::class, 'show']);    // عرض مهمة واحدة
Route::post('tasks', [TaskController::class, 'store']);       // إنشاء مهمة جديدة
Route::put('tasks/{id}', [TaskController::class, 'update']);  // تحديث مهمة
Route::delete('tasks/{id}', [TaskController::class, 'destroy']); // حذف مهمة