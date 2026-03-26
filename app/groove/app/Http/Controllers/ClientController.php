<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    public function index() {
        $sessions = DB::table('SESSION')
            ->join('DEMANDE', 'SESSION.id_demande', '=', 'DEMANDE.numero_demande')
            ->join('STUDIO', 'SESSION.numero_studio', '=', 'STUDIO.numero_studio')
            ->join('ACTIVITE', 'STUDIO.id_activite', '=', 'ACTIVITE.id_activite')
            ->where('DEMANDE.numero_client', Auth::id())
            ->select('SESSION.*', 'ACTIVITE.type as activite')
            ->orderBy('SESSION.debut', 'desc')
            ->get();

        return view('client.dashboard_client', compact('sessions'));
    }
}
