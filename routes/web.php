<?php


use App\Http\Controllers\ProfileController;
use App\Mail\SubcribeEmail;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Exceptions\ResourceNotFoundException;

Route::get('/', function () {




    try {
        DB::beginTransaction();


        DB::table('users')->insert(['name' => 'Andres', 'password' => '12345', 'email' => 'test@test.com']);
        // DB::table('users')->insert(['name' => 'Andres', 'password' => '12345', 'email' =>'tesst@test.com']);
        DB::table('orders')->insert(['user_id' => 1, 'total_amount' => 100]);

        DB::commit();
    } catch (\Exception $e) {
        DB::rollback();
        return $e->getMessage();
    }



    return view('test');
});


Route::get('/user/{id}', function ($id) {
    $user = User::find($id);
    if($user == null){
        throw new ResourceNotFoundException('Usuario no encontrado!!');
    }
    return $user;
});
Route::middleware('throttle:3,1')->get('/users', function () {
    dd(User::all());
});

Route::get('/users-delete', function () {
    dd(User::where('id', '>=', 1)->delete());
});

Route::get('/email', function () {
    Mail::to('pepe@gmail.com')
        // ->cc(['pepe1@gmail.com','pepe2@gmail.com','pepe3@gmail.com'])
        ->bcc(['hidden1@gmail.com', 'hidden2@gmail.com', 'hidden3@gmail.com'])
        ->send(new SubcribeEmail('pepe@gmail.com', 'Nuevo sub!', 'Hola y gracias y dame tu dinero!!!'));
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
