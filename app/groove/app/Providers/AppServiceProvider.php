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
// TEMPORAIRE hasher les 2 password déjà présent en bdd juste pour test
        // TODO: créer un controller pour les créations de compte et hasher le password renseigné à ce moment là
        try {
            $users = DB::select("SELECT id_utilisateur, password FROM Utilisateur");
            foreach ($users as $user) {
                if (Hash::needsRehash($user->password)) {
                    DB::statement(
                        "UPDATE Utilisateur SET password = ? WHERE id_utilisateur = ?",
                        [Hash::make($user->password), $user->id_utilisateur]
                    );
                    logger('Passwords hashed on boot');
                }
            }
        } catch (\Throwable $e) {
            //ignore
        }
    }
}
