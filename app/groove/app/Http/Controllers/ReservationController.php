<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ReservationController extends Controller
{
    public function showReservation()
    {
        $activites = DB::table('ACTIVITE')->orderBy('type')->get();

        $studios = DB::table('STUDIO')
            ->join('ACTIVITE', 'STUDIO.id_activite', '=', 'ACTIVITE.id_activite')
            ->select('STUDIO.*', 'ACTIVITE.type as activite_type')
            ->get()
            ->groupBy('id_activite');

        $sessions = DB::table('SESSION')
            ->whereIn('statut', ['en_attente', 'proposee', 'confirmee'])
            ->where('fin', '>', now())
            ->select('numero_studio', 'debut', 'fin')
            ->get()
            ->groupBy('numero_studio');

        return view('reservation', compact('activites', 'studios', 'sessions'));
    }

    public function submitReservation(Request $request)
    {
        $request->validate([
            'studio_id'   => 'required',
            'activite_id' => 'required',
            'date'        => 'required|date',
            'debut'       => 'required',
            'fin'         => 'required',
        ]);

        $debut = Carbon::parse($request->date . ' ' . $request->debut);
        $fin   = Carbon::parse($request->date . ' ' . $request->fin);

        // Check slot is still available
        $conflict = DB::table('SESSION')
            ->where('numero_studio', $request->studio_id)
            ->whereIn('statut', ['en_attente', 'proposee', 'confirmee'])
            ->where('debut', '<', $fin->toDateTimeString())
            ->where('fin',   '>', $debut->toDateTimeString())
            ->exists();

        if ($conflict) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Ce créneau vient d\'être réservé. Veuillez en choisir un autre.'], 409);
            }
            return back()->with('error', 'Ce créneau n\'est plus disponible.');
        }

        if (Auth::check()) {
            $userId = Auth::id();
        } else {
            $request->validate([
                'prenom' => 'required|string|max:100',
                'email'  => 'required|email',
            ]);

            $existing = DB::table('UTILISATEUR')->where('email', $request->email)->first();
            if ($existing) {
                $userId = $existing->id;
            } else {
                $userId = DB::table('UTILISATEUR')->insertGetId([
                    'prenom'    => $request->prenom,
                    'nom'       => $request->nom ?? $request->prenom,
                    'email'     => $request->email,
                    'telephone' => $request->telephone ?? null,
                    'password'  => Hash::make(Str::random(32)),
                    'is_admin'  => 0,
                ]);
            }
        }

        $studio = DB::table('STUDIO')->where('numero_studio', $request->studio_id)->first();
        $dureeH = $debut->diffInMinutes($fin) / 60;
        $prix   = round($studio->taux_horaire * $dureeH, 2);

        // TODO: à faire en sorte que ce nb_personnes soit renseigné
        $nb_personnes = 0;
        $demandeId = DB::table('DEMANDE')->insertGetId([
            'numero_client' => $userId,
            'id_activite'   => $request->activite_id,
            'date'          => $request->date,
            'nb_personnes'  => $nb_personnes,
        ]);

        DB::table('SESSION')->insert([
            'statut'        => 'en_attente',
            'debut'         => $debut->toDateTimeString(),
            'fin'           => $fin->toDateTimeString(),
            'prix'          => $prix,
            'nb_personnes'  => $nb_personnes,
            'numero_studio' => $request->studio_id,
            'id_demande'    => $demandeId,
        ]);

        $message = Auth::check()
            ? 'Votre demande a été envoyée. Retrouvez-la dans votre espace client.'
            : 'Votre demande a été envoyée. Vous serez contacté prochainement.';

        if ($request->expectsJson()) {
            return response()->json([
                'success'  => true,
                'message'  => $message,
                'redirect' => Auth::check() ? route('client.dashboard') : null,
            ]);
        }

        if (Auth::check()) {
            return redirect()->route('client.dashboard')->with('success', $message);
        }
        return redirect()->route('reservation')->with('success', $message);
    }
}
