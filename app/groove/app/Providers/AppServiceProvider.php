<?php

namespace App\Providers;

use App\Http\Controllers\PasswordController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void {
        //  force utf8 to avoid encoding issues
        try {
            DB::statement("SET NAMES 'utf8mb4' COLLATE 'utf8mb4_unicode_ci'");
        } catch (\Throwable $e) {
            //ignore
        }
        // TEMPORAIRE hasher les 2 password déjà présent en bdd juste pour test
        // TODO: créer un controller pour les créations de compte et hasher le password renseigné à ce moment là
        $users = DB::table('UTILISATEUR')->get();
        foreach ($users as $user) {
            // évite de re-hasher un hash
            if (Hash::needsRehash($user->password)) {
                DB::table('UTILISATEUR')
                    ->where('id', $user->id)
                    ->update([
                        'password' => Hash::make($user->password)
                    ]);
                logger('Passwords hashed on boot');
            }
        }
    }
}
