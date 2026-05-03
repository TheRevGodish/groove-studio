@extends('layouts.app')

@section('title', 'Admin — Demandes')

@section('content')

    <div class="fade-1">
        <h1 class="page-title">DEMANDES</h1>
    </div>

    <div class="fade-2">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-ghost">RETOUR</a>
    </div>

    @if(session('success'))
        <div class="fade-2" style="margin-bottom: 12px; color: var(--green, #4caf50);">
            {{ session('success') }}
        </div>
    @endif

    <div class="fade-3">
        <p class="section-label">Demandes récentes</p>
        <div class="table-wrap">
            <table>
                <thead>
                <tr>
                    <th>#</th>
                    <th>Client</th>
                    <th>Activité</th>
                    <th>Date</th>
                    <th>Nb personnes</th>
                    <th>Techniciens</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse($demandes as $d)
                    @php
                        $statuts = [0 => ['label' => 'En attente', 'color' => '#f0a500'],
                                    1 => ['label' => 'Acceptée',   'color' => '#4caf50'],
                                    2 => ['label' => 'Refusée',    'color' => '#e53935']];
                        $s = $statuts[$d->status] ?? $statuts[0];
                    @endphp
                    <tr>
                        <td>{{ $d->id_demande }}</td>
                        <td>{{ $d->prenom }} {{ $d->nom }}</td>
                        <td>{{ $d->activite }}</td>
                        <td class="td-muted">{{ \Carbon\Carbon::parse($d->date_demande)->format('d/m/Y') }}</td>
                        <td class="td-muted">{{ $d->nb_personnes }}</td>
                        <td class="td-muted">{{ $d->nb_techniciens }}</td>
                        <td>
                            <span style="color: {{ $s['color'] }}; font-weight: 600;">{{ $s['label'] }}</span>
                        </td>
                        <td>
                            <a href="{{ route('admin.demandes.show', $d->id_demande) }}" class="btn btn-ghost" style="margin-right: 8px">Voir</a>

                            @if($d->status == 0)
                                <form method="POST" action="{{ route('admin.demandes.valider', $d->id_demande) }}" style="display:inline; margin-right: 8px">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Valider</button>
                                </form>
                                <form method="POST" action="{{ route('admin.demandes.refuser', $d->id_demande) }}" style="display:inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Refuser</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="padding: 32px 0; color: var(--gray); font-style: italic;">Aucune demande enregistrée.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
