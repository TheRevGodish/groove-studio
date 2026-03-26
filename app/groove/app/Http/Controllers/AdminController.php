<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller {
    public function index() {
        // Requêtes BDD
        $sessions = DB::table('SESSION')
            ->join('DEMANDE', 'SESSION.id_demande', '=', 'DEMANDE.numero_demande')
            ->join('UTILISATEUR', 'DEMANDE.numero_client', '=', 'UTILISATEUR.id')
            ->join('STUDIO', 'SESSION.numero_studio', '=', 'STUDIO.numero_studio')
            ->join('ACTIVITE', 'STUDIO.id_activite', '=', 'ACTIVITE.id_activite')
            ->select('SESSION.*', 'UTILISATEUR.nom', 'UTILISATEUR.prenom', 'ACTIVITE.type as activite')
            ->orderBy('SESSION.debut', 'desc')
            ->get();

        $nb_users    = DB::table('UTILISATEUR')->count();
        $nb_demandes = DB::table('DEMANDE')->count();

        // Envoi à la vue
        return view('admin.dashboard', compact('sessions', 'nb_users', 'nb_demandes'));
    }
}
