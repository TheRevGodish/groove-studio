<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller {
    public function index() {
        $sessions = DB::table('SESSION')
            ->join('DEMANDE', 'SESSION.id_demande', '=', 'DEMANDE.numero_demande')
            ->join('UTILISATEUR', 'DEMANDE.numero_client', '=', 'UTILISATEUR.id')
            ->join('STUDIO', 'SESSION.numero_studio', '=', 'STUDIO.numero_studio')
            ->join('ACTIVITE', 'STUDIO.id_activite', '=', 'ACTIVITE.id_activite')
            ->select('SESSION.*', 'UTILISATEUR.nom', 'UTILISATEUR.prenom', 'ACTIVITE.type as activite')
            ->orderBy('SESSION.debut', 'desc')
            ->get();
        $nb_sessions = DB::table("SESSION")->count();
        $nb_attentes = DB::table("SESSION")->where('statut', 'en_attente')->count();
        $nb_users    = DB::table('UTILISATEUR')->count();
        $nb_clients  = DB::table('UTILISATEUR')->where('is_admin', false)->count();
        $nb_demandes = DB::table('DEMANDE')->count();
        $revenus     = DB::table('SESSION')->where('statut', 'confirmee')->sum('prix');

        // Envoi à la vue
        return view('admin.dashboard_admin', compact(
            'sessions', 'nb_sessions', 'nb_attentes', 'nb_demandes', 'nb_clients', 'revenus', 'nb_users'));
    }
}
