<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller {

    public function showReservations() {
        $activites = DB::select("
            SELECT id_activite, type, employe_obligatoire
            FROM Activite
            ORDER BY type
        ");

        return view('reservations', compact('activites'));
    }

    public function checkAvailability(Request $request) {
        $data = $request->validate([
            'date'         => 'required|date',
            'heure_debut'  => 'required',
            'heure_fin'    => 'required',
            'id_activite'  => 'required|integer',
            'nb_personnes' => 'required|integer|min:1',
        ]);

        $debut = $data['date'] . ' ' . $data['heure_debut'] . ':00';
        $fin   = $data['date'] . ' ' . $data['heure_fin']   . ':00';

        if (strtotime($fin) <= strtotime($debut)) {
            return response()->json([
                'error' => "L'heure de fin doit être postérieure à l'heure de début."
            ], 422);
        }

        $studios = DB::select("
            SELECT s.id_studio, s.numero_studio, s.capacite, s.amenageable,
                   s.taux_horaire, s.description,
                   a.type AS activite_type,
                   st.nom AS structure_nom
            FROM Studio s
            JOIN Activite  a  ON s.id_activite  = a.id_activite
            JOIN Structure st ON s.id_structure = st.id_structure
            WHERE s.id_activite = ?
              AND s.capacite   >= ?
              AND s.id_studio NOT IN (
                  SELECT DISTINCT id_studio
                  FROM Session
                  WHERE COALESCE(status, '') NOT IN ('annulee', 'refusee')
                    AND debut < ?
                    AND fin   > ?
              )
            ORDER BY s.taux_horaire ASC, s.numero_studio ASC
        ", [
            $data['id_activite'],
            $data['nb_personnes'],
            $fin,
            $debut,
        ]);

        $duree = (strtotime($fin) - strtotime($debut)) / 3600;

        foreach ($studios as $s) {
            $s->prix_estime = round(((float) $s->taux_horaire) * $duree, 2);
            $s->materiels   = DB::select("
                SELECT m.nom, m.type
                FROM contenir c
                JOIN Materiel m ON c.id_materiel = m.id_materiel
                WHERE c.id_studio = ?
                ORDER BY m.nom
            ", [$s->id_studio]);
        }

        return response()->json([
            'studios' => $studios,
            'duree'   => $duree,
        ]);
    }

    // TODO: il faut remanier les tables DEMANDES et SESSIONS
    // elles sont quasi identiques, à qqs détails près, l'admin doit avoir
    // toutes les infos utiles à la fin pour valider ou non (dates, heure, nb techniciens, etc)
    // et ensuite, on modifie cette fonction en conséquence
    public function sendReservation(Request $request, $id) {
        $data = $request->validate([
            'date'           => 'required|date',
            'heure_debut'    => 'required',
            'heure_fin'      => 'required',
            'id_activite'    => 'required|integer',
            'id_studio'      => 'required|integer',
            'nb_personnes'   => 'required|integer|min:1',
            'nb_techniciens' => 'nullable|integer|min:0',
            'description'    => 'nullable|string|max:40',
        ]);

        $debut = $data['date'] . ' ' . $data['heure_debut'] . ':00';

        $note = '→' . substr($data['heure_fin'], 0, 5);
        if (!empty($data['description'])) {
            $note .= ' ' . $data['description'];
        }
        $note = substr($note, 0, 50);

        DB::insert("
            INSERT INTO Demande
                (nb_personnes, nb_techniciens, status, description,
                 date_demande, id_activite, id_utilisateur, id_studio)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ", [
            $data['nb_personnes'],
            $data['nb_techniciens'] ?? 0,
            0,
            $note,
            $debut,
            $data['id_activite'],
            Auth::id(),
            $data['id_studio'],
        ]);

        return redirect()->route('client.dashboard')->with(
            'success',
            'Votre demande a été envoyée. Elle sera examinée sous peu.'
        );
    }

    public function index() {
        $sessions = DB::select("
            SELECT s.*, a.type AS activite
            FROM Session s
            JOIN Demande d  ON s.id_demande    = d.id_demande
            JOIN Activite a ON s.id_activite   = a.id_activite
            WHERE d.id_utilisateur = ?
            ORDER BY s.debut DESC
        ", [Auth::id()]);

        return view('client.dashboard_client', compact('sessions'));
    }
}
