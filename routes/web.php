<?php

use App\Models\Group;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Route::view('chat', 'chat')
//     ->middleware(['auth', 'verified'])
//     ->name('chat');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('group/{group}', function(Group $group){
    return view('chat', ['group' => $group]);
})
->middleware(['auth', 'verified'])
    ->name('group');
    
Route::get('group/{group}/detail', function(Group $group){
    return view('detail', ['group' => $group]);
})
->middleware(['auth', 'verified'])
    ->name('detail');



require __DIR__.'/auth.php';