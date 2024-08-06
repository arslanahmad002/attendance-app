<?php

use App\Http\Controllers\AttendanceController;
use App\Models\attendance;
use Illuminate\Support\Facades\Route;

Route::get('/',[AttendanceController::class,'index'])->name('attendance.index');
