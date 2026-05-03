@extends('layouts.app')

@section('title', 'Admin — Demande')

@section('content')

    @php
        $statuts = [0 => ['label' => 'En attente', 'color' => '#f0a500'],
                    1 => ['label' => 'Acceptée',   'color' => '#4caf50'],
                    2 => ['label' => 'Refusée',    'color' => '#e53935']];
        $s = $statuts[$demande->status] ?? $statuts[0];
    @endphp

    <div class="fade-1">
        <h1 class="page-title">DEMANDE #{{ $demande->id_demande }}</h1>
        <p class="page-sub">Détails de la demande soumise par {{ $demande->prenom }} {{ $demande->nom }}.</p>
    </div>

    <div class="fade-2" style="display:flex; gap:12px; align-items:center; margin-bottom:16px;">
        <a href="{{ route('admin.demandes') }}" class="btn btn-ghost">RETOUR</a>

        @if($demande->status == 0)
            <form method="POST" action="{{ route('admin.demandes.valider', $demande->id_demande) }}" style="display:inline">
                @csrf
                <button type="submit" class="btn btn-accent">Valider</button>
            </form>
            <form method="POST" action="{{ route('admin.demandes.refuser', $demande->id_demande) }}" style="display:inline">
                @csrf
                <button type="submit" class="btn btn-danger">Refuser</button>
            </form>
        @else
            <span style="color: {{ $s['color'] }}; font-weight: 600;">{{ $s['label'] }}</span>
        @endif
    </div>

    <div class="fade-3">
        <div class="card">
            <p><strong>Client :</strong> {{ $demande->prenom }} {{ $demande->nom }}</p>
            <p><strong>Activité :</strong> {{ $demande->activite }}</p>
            <p><strong>Date souhaitée :</strong> {{ \Carbon\Carbon::parse($demande->date_demande)->format('d/m/Y') }}</p>
            <p><strong>Nombre de personnes :</strong> {{ $demande->nb_personnes }}</p>
            <p><strong>Nombre de techniciens :</strong> {{ $demande->nb_techniciens }}</p>
            @if(!empty($demande->description))
                <p><strong>Commentaire :</strong> {{ $demande->description }}</p>
            @endif

            @if(count($materiels) > 0)
                <hr>
                <p><strong>Matériel demandé :</strong></p>
                <ul>
                    @foreach($materiels as $m)
                        <li>{{ $m->nom }}{{ $m->type ? ' — ' . $m->type : '' }}</li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

@endsection
