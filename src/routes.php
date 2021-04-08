<?php

use Illuminate\Support\Facades\Route;
use Sdkcodes\LaraTicket\Controllers\TicketAdminController;
use Sdkcodes\LaraTicket\Controllers\TicketController;
use Sdkcodes\LaraTicket\Controllers\TicketOptionController;

Route::namespace("Sdkcodes\LaraTicket\Controllers")->middleware('web', 'auth')->group(function () {

    Route::middleware("can:access admin area")->prefix("admin")->group(function () {
        Route::get('tickets/settings', [TicketOptionController::class, "options"]);
        Route::post('tickets/settings', [TicketOptionController::class, "store"]);
        Route::get('tickets', [TicketAdminController::class, "index"]);
        Route::get('tickets/show/{ticket}', [TicketAdminController::class, "show"]);
        Route::get('tickets/{status?}', [TicketAdminController::class, "index"]);
        Route::get('tickets/{ticket}/update', [TicketAdminController::class, "changestatus"]);
        Route::post('tickets/store', [TicketAdminController::class, "store"]);
        Route::put('tickets/{ticket}', [TicketAdminController::class, "update"]);
        Route::delete('tickets/{ticket}', [TicketAdminController::class, "delete"]);
        Route::post('tickets/comments/store/{ticket}', [TicketAdminController::class, "reply"]);
    });

    Route::get('tickets/create', [TicketController::class, "create"]);
    Route::get('tickets/{status?}', [TicketController::class, "index"]);
    Route::get('tickets', [TicketController::class, "index"])->name("user.tickets");
    Route::get('tickets/show/{ticket}', [TicketController::class, "show"]);
    Route::get('tickets/{ticket}/update', [TicketController::class, "changestatus"]);
    Route::post('tickets/store', [TicketController::class, "store"]);
    Route::put('tickets/{ticket}', [TicketController::class, "update"]);
    Route::delete('tickets/{ticket}', [TicketController::class, "delete"]);

    Route::post('tickets/comments/store/{ticket}', [TicketController::class, "reply"]);
});
