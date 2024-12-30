<?php

use App\Models\User;
use App\Models\Message;
use App\Events\ExampleEvent;
use App\Events\Chat\ExampleTwoEvent;
use App\Events\OrderDelivered;
use App\Events\OrderDispatched;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Models\Order;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/broadcast', function () {
    sleep(3);

    broadcast(new OrderDispatched(Order::find(1)));

    sleep(5);

    broadcast(new OrderDelivered(Order::find(1)));
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/orders/{order}', function (Order $order) {
    return view('order', [
        'order' => $order
    ]);
});
