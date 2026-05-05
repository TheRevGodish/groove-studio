<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index() {
        $sessions = DB::select("
            SELECT s.*, a.type AS activite, d.status AS demande_status
            FROM Session s
            JOIN Demande d  ON s.id_demande    = d.id_demande
            JOIN Activite a ON s.id_activite   = a.id_activite
            WHERE d.id_utilisateur = ?
            ORDER BY s.debut DESC
        ", [Auth::id()]);

        return view('client.dashboard_client', compact('sessions'));
    }
}
