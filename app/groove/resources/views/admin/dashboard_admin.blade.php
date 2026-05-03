@extends('layouts.app')

@section('title', 'Admin — Dashboard')

@section('content')

    <div class="fade-1">
        <h1 class="page-title">DASHBOARD</h1>
        <p class="page-sub">Vue d'ensemble de l'activité Groove Studio.</p>
    </div>

    <div class="stats-grid fade-2">
        <div class="stat-card">
            <div class="stat-label">Sessions totales</div>
            <div class="stat-value">{{ $nb_sessions }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Demandes en attente</div>
            <div class="stat-value">{{ $nb_attentes }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Clients</div>
            <div class="stat-value">{{ $nb_clients }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Revenus confirmés</div>
            <div class="stat-value">{{ number_format($revenus, 0, ',', ' ') }}€</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Utilisateurs</div>
            <div class="stat-value">{{ $nb_users }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">Demande totales</div>
            <div class="stat-value">{{ $nb_demandes }}</div>
        </div>
    </div>

    <div class="fade-3">
        <p class="section-label">Sessions récentes</p>
        
        <div class="table-wrap">
            <table>
                <thead>
                <tr>
                    <th>Client</th>
                    <th>Activité</th>
                    <th>Studio</th>
                    <th>Date</th>
                    <th>Prix</th>
                    <th>Statut</th>
                </tr>
                </thead>
                <tbody>
                @forelse($sessions as $s)
                    <tr>
                        <td>{{ $s->prenom }} {{ $s->nom }}</td>
                        <td>{{ $s->activite }}</td>
                        <td class="td-muted">Studio {{ $s->id_studio }}</td>
                        <td class="td-muted">{{ \Carbon\Carbon::parse($s->debut)->format('d/m/Y H\hi') }}</td>
                        <td class="td-bold">{{ $s->prix !== null ? number_format($s->prix, 0, ',', ' ').' €' : '—' }}</td>
                        <td><span class="badge badge-{{ $s->status }}">{{ ucfirst($s->status) }}</span></td>
                    </tr>
                    
                @empty
                    <tr>
                        <td colspan="6" style="padding: 32px 0; color: var(--gray); font-style: italic;">Aucune session enregistrée.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="fade-4" style="margin-top: 40px;">
        <a href="{{ route('admin.demandes') }}" class="btn btn-primary">VOIR LES DEMANDES →</a>
    </div>
@endsection
