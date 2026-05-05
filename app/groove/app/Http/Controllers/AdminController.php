<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller {

    public function index() {
        $sessions = DB::select("
            SELECT s.*, u.nom, u.prenom, a.type AS activite, d.status AS demande_status
            FROM Session s
            JOIN Demande d    ON s.id_demande    = d.id_demande
            JOIN Utilisateur u ON d.id_utilisateur = u.id_utilisateur
            JOIN Activite a   ON s.id_activite   = a.id_activite
            ORDER BY s.debut DESC
        ");

        $nb_sessions = DB::select("SELECT COUNT(*) AS cnt FROM Session")[0]->cnt;
        $nb_attentes = DB::select("SELECT COUNT(*) AS cnt FROM Demande WHERE status = 0")[0]->cnt;
        $nb_users    = DB::select("SELECT COUNT(*) AS cnt FROM Utilisateur")[0]->cnt;
        $nb_clients  = DB::select("SELECT COUNT(*) AS cnt FROM Utilisateur WHERE is_admin = FALSE")[0]->cnt;
        $nb_demandes = DB::select("SELECT COUNT(*) AS cnt FROM Demande")[0]->cnt;
        $revenus     = DB::select("SELECT COALESCE(SUM(prix), 0) AS total FROM Session")[0]->total;

        return view('admin.dashboard_admin', compact(
            'sessions', 'nb_sessions', 'nb_attentes', 'nb_demandes', 'nb_clients', 'revenus', 'nb_users'
        ));
    }

    public function demandes() {
        $demandes = DB::select("
            SELECT d.*, u.nom, u.prenom, a.type AS activite
            FROM Demande d
            JOIN Utilisateur u ON d.id_utilisateur = u.id_utilisateur
            JOIN Activite a    ON d.id_activite    = a.id_activite
            WHERE d.status = 0
            ORDER BY d.date_demande DESC
        ");

        return view('admin.demandes', compact('demandes'));
    }

    public function show($id) {
        $rows = DB::select("
            SELECT d.*, u.nom, u.prenom, a.type AS activite
            FROM Demande d
            JOIN Utilisateur u ON d.id_utilisateur = u.id_utilisateur
            JOIN Activite a    ON d.id_activite    = a.id_activite
            WHERE d.id_demande = ?
        ", [$id]);

        $demande = $rows[0] ?? null;
        if (!$demande) abort(404);

        $materiels = DB::select("
            SELECT m.*
            FROM emprunter e
            JOIN Materiel m ON e.id_materiel = m.id_materiel
            WHERE e.id_demande = ?
        ", [$id]);

        return view('admin.demande_show', compact('demande', 'materiels'));
    }

    public function valider($id) {
        DB::statement("UPDATE Demande SET status = 1 WHERE id_demande = ?", [$id]);
        return redirect()->route('admin.demandes')->with('success', 'Demande validée.');
    }

    public function refuser($id) {
        DB::statement("UPDATE Demande SET status = 2 WHERE id_demande = ?", [$id]);
        return redirect()->route('admin.demandes')->with('success', 'Demande refusée.');
    }
}
