<?php

use Illuminate\Support\Facades\Route;
use siddiquinoor\NagadLaravel\Controllers\NagadPaymentController;

Route::get("/nagad/callback", [NagadPaymentController::class, "callback"]);
Route::get("/nagad-payment/{transaction_id}/success", [NagadPaymentController::class, "success"]);
Route::get("/nagad-payment/{transaction_id}/fail", [NagadPaymentController::class, "fail"]);
