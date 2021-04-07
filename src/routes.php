<?php

use Illuminate\Support\Facades\Route;
use Sdkcodes\LaraTicket\Controllers\TicketAdminController;

Route::namespace("Sdkcodes\LaraTicket\Controllers")->middleware('web', 'auth')->group(function () {

    Route::middleware("can:access admin area")->prefix("admin")->group(function(){
        Route::get('tickets/settings', "TicketOptionController@options");
        Route::post('tickets/settings', "TicketOptionController@store");
        Route::put('tickets/settings', "TicketOptionController@update");
        Route::get('tickets/{status?}', [TicketAdminController::class, "index"]);
        Route::get('tickets', [TicketAdminController::class, "index"]);
    });

    Route::get('tickets/create', "TicketController@create");
    Route::get('tickets/{status?}', "TicketController@index");
    Route::get('tickets', "TicketController@index")->name("user.tickets");
    Route::get('tickets/show/{ticket}', "TicketController@show");
    Route::get('tickets/{ticket}/update', "TicketController@changestatus");
    Route::post('tickets/store', "TicketController@store");
    Route::put('tickets/{ticket}', "TicketController@update");
    Route::delete('tickets/{ticket}', "TicketController@delete");

    Route::post('tickets/comments/store/{ticket}', "TicketController@reply");


});
