<?php

use App\Http\Controllers\TarefaController;
use App\Mail\MensagemTesteMail;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('bem-vindo');
});

Auth::routes(['verify' => true]);

/*
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])
    ->name('home')
    ->middleware('verified');
    */
Route::get('tarefa/exportacao/{extensao}', [TarefaController::class , 'exportacao'])->name('tarefa.exportacao');

Route::get('tarefa/exportar', [TarefaController::class , 'exportar'])->name('tarefa.exportar');

    
Route::resource('tarefa', 'App\Http\Controllers\TarefaController')
    ->middleware('verified');

Route::get('/mensagem-teste', function(){
    return new MensagemTesteMail();
    // Mail::to('atendimento@jorgesantana.net.br')->send(new MensagemTesteMail());
    // return 'E-mail enviado com sucesso';
});