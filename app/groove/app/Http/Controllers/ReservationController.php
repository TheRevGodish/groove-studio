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
                  FROM Demande
                  WHERE status <> 2
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

    public function sendDemande(Request $request) {
        $data = $request->validate([
            'date'           => 'required|date',
            'heure_debut'    => 'required',
            'heure_fin'      => 'required',
            'id_activite'    => 'required|integer',
            'id_studio'      => 'required|integer',
            'nb_personnes'   => 'required|integer|min:1',
            'nb_techniciens' => 'nullable|integer|min:0',
            'description'    => 'nullable|string|max:50',
        ]);

        $debut = $data['date'] . ' ' . $data['heure_debut'] . ':00';
        $fin   = $data['date'] . ' ' . $data['heure_fin']   . ':00';

        if (strtotime($fin) <= strtotime($debut)) {
            return back()
                ->withInput()
                ->withErrors(['heure_fin' => "L'heure de fin doit être postérieure à l'heure de début."]);
        }

        $conflict = DB::select("
            SELECT 1
            FROM Demande
            WHERE id_studio = ?
              AND status   <> 2
              AND debut < ?
              AND fin   > ?
            LIMIT 1
        ", [$data['id_studio'], $fin, $debut]);

        if (!empty($conflict)) {
            return back()
                ->withInput()
                ->withErrors(['id_studio' => "Ce studio vient d'être réservé sur ce créneau. Merci de relancer la recherche."]);
        }

        DB::insert("
            INSERT INTO Demande
                (nb_personnes, nb_techniciens, status, description,
                 date_demande, debut, fin,
                 id_activite, id_utilisateur, id_studio)
            VALUES (?, ?, ?, ?, NOW(), ?, ?, ?, ?, ?)
        ", [
            $data['nb_personnes'],
            $data['nb_techniciens'] ?? 0,
            0,
            $data['description'] ?? null,
            $debut,
            $fin,
            $data['id_activite'],
            Auth::id(),
            $data['id_studio'],
        ]);

        return redirect()->route('client.dashboard')->with(
            'success',
            'Votre demande a été envoyée. Elle sera examinée sous peu.'
        );
    }
}