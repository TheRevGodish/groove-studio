@extends('layouts.app')

@section('title', 'Mon espace')

@section('content')

    <div class="fade-1">
        <h1 class="page-title">MON ESPACE</h1>
        <p class="page-sub">Retrouvez ici l'historique de vos sessions et demandes.</p>
    </div>

    <div class="stats-grid fade-2">
        <div class="stat-card">
            <div class="stat-label">Sessions totales</div>
            <div class="stat-value">{{ count($sessions) }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Sessions confirmées</div>
            <div class="stat-value">{{ collect($sessions)->where('status', 'confirmee')->count() }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Total dépensé</div>
            <div class="stat-value">{{ number_format(collect($sessions)->sum('prix'), 0, ',', ' ') }}€</div>
        </div>
    </div>

    <div class="fade-2" style="display:flex; gap:12px; align-items:center;">
        <a href="{{ route('reservations') }}" class="btn btn-primary">NOUVELLE DEMANDE</a>
        <a href="{{ route('client.dashboard') }}" class="btn btn-ghost">GESTION DES DEMANDES</a>
    </div>

    <div class="fade-3">
        <p class="section-label">Mes sessions</p>
        <div class="table-wrap">
            <table>
                <thead>
                <tr>
                    <th>Activité</th>
                    <th>Studio</th>
                    <th>Date</th>
                    <th>Durée</th>
                    <th>Prix</th>
                    <th>Statut</th>
                </tr>
                </thead>
                <tbody>
                @forelse($sessions as $s)
                    @php
                        $debut = \Carbon\Carbon::parse($s->debut);
                        $fin   = \Carbon\Carbon::parse($s->fin);
                        $duree = $debut->diffInHours($fin).'h'.($debut->diffInMinutes($fin) % 60 > 0 ? ($debut->diffInMinutes($fin) % 60) : '');
                    @endphp
                    <tr>
                        <td>{{ $s->activite }}</td>
                        <td class="td-muted">Studio {{ $s->id_studio }}</td>
                        <td class="td-muted">
                            {{ $debut->format('d/m/Y') }}<br>
                            <span style="font-size:12px;">{{ $debut->format('H\hi') }} → {{ $fin->format('H\hi') }}</span>
                        </td>
                        <td class="td-muted">{{ $duree }}</td>
                        <td class="td-bold">{{ $s->prix !== null ? number_format($s->prix, 0, ',', ' ').' €' : '—' }}</td>
                        <td><span class="badge badge-{{ $s->status }}">{{ ucfirst($s->status) }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="padding: 32px 0; color: var(--gray); font-style: italic;">Vous n'avez pas encore de session enregistrée.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <?php
    #<div class="fade-4" style="margin-top: 40px;">
     #   <a href="{{ route('client.demande') }}" class="btn btn-primary">NOUVELLE DEMANDE →</a>
    #</div>
    ?>

@endsection
