@extends('layouts.app')

@section('title', 'Réserver un studio')

@section('styles')
    /* ── RESERVATION PAGE ── */
    .reserv-intro {
        max-width: 720px;
    }

    .step-block {
        margin-bottom: 56px;
    }

    .step-head {
        display: flex;
        align-items: baseline;
        gap: 14px;
        margin-bottom: 20px;
    }

    .step-num {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 14px;
        letter-spacing: 0.18em;
        color: var(--accent);
    }

    .step-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 28px;
        letter-spacing: 0.04em;
        line-height: 1;
    }

    .step-body {
        background: #fff;
        border: 0.5px solid var(--border);
        padding: 32px 36px;
    }

    .step-body.locked {
        opacity: 0.45;
        pointer-events: none;
    }

    .step-body.locked::after {
        content: '';
    }

    /* ── FORM GRID ── */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 24px 28px;
    }

    .form-grid .full { grid-column: 1 / -1; }

    .field-r {
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .field-r label {
        font-size: 10px;
        font-weight: 500;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--gray);
    }

    .field-r input,
    .field-r select,
    .field-r textarea {
        width: 100%;
        padding: 13px 14px;
        font-family: 'DM Sans', sans-serif;
        font-size: 15px;
        color: var(--black);
        background: transparent;
        border: 1px solid var(--border);
        border-radius: 0;
        outline: none;
        transition: border-color 0.2s;
    }

    .field-r input:focus,
    .field-r select:focus,
    .field-r textarea:focus { border-color: var(--black); }

    .field-r textarea {
        resize: vertical;
        min-height: 90px;
        font-family: 'DM Sans', sans-serif;
    }

    .field-r select {
        appearance: none;
        background-image: linear-gradient(45deg, transparent 50%, var(--black) 50%),
                          linear-gradient(135deg, var(--black) 50%, transparent 50%);
        background-position: calc(100% - 18px) center, calc(100% - 13px) center;
        background-size: 5px 5px, 5px 5px;
        background-repeat: no-repeat;
        padding-right: 36px;
        cursor: pointer;
    }

    .time-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .helper {
        font-size: 11px;
        color: var(--gray);
        font-weight: 300;
        margin-top: 4px;
    }

    .form-actions {
        margin-top: 28px;
        display: flex;
        align-items: center;
        gap: 16px;
    }

    .btn .arrow {
        transition: transform 0.2s;
    }
    .btn:hover .arrow { transform: translateX(4px); }

    /* ── STUDIO RESULTS ── */
    .studios-status {
        font-size: 12px;
        color: var(--gray);
        margin-bottom: 20px;
        font-weight: 300;
        letter-spacing: 0.04em;
    }

    .studios-status strong {
        color: var(--black);
        font-weight: 500;
    }

    .studios-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 16px;
    }

    .studio-card {
        position: relative;
        background: #fff;
        border: 1px solid var(--border);
        padding: 24px 24px 20px;
        cursor: pointer;
        transition: border-color 0.2s, transform 0.15s, box-shadow 0.2s;
        animation: fadeUp 0.35s ease both;
    }

    .studio-card:hover {
        border-color: var(--black);
        transform: translateY(-2px);
    }

    .studio-card.selected {
        border-color: var(--accent);
        border-width: 2px;
        padding: 23px 23px 19px;
        box-shadow: 0 0 0 4px rgba(200,169,110,0.18);
    }

    .studio-card.selected::before {
        content: '✓';
        position: absolute;
        top: 14px;
        right: 14px;
        width: 22px;
        height: 22px;
        background: var(--accent);
        color: var(--black);
        font-size: 12px;
        font-weight: 600;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .studio-head {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        margin-bottom: 10px;
    }

    .studio-num {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 32px;
        letter-spacing: 0.04em;
        line-height: 1;
    }

    .studio-num small {
        font-size: 11px;
        letter-spacing: 0.14em;
        color: var(--gray);
        margin-right: 6px;
        font-family: 'DM Sans', sans-serif;
        font-weight: 500;
        text-transform: uppercase;
    }

    .studio-rate {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 22px;
        letter-spacing: 0.02em;
        color: var(--accent);
    }

    .studio-rate small {
        font-size: 10px;
        color: var(--gray);
        font-family: 'DM Sans', sans-serif;
        font-weight: 400;
        letter-spacing: 0.06em;
    }

    .studio-meta {
        display: flex;
        gap: 14px;
        flex-wrap: wrap;
        margin-bottom: 14px;
    }

    .studio-meta .chip {
        font-size: 11px;
        letter-spacing: 0.06em;
        color: var(--gray);
        background: var(--cream);
        padding: 3px 8px;
        text-transform: uppercase;
        font-weight: 500;
    }

    .studio-desc {
        font-size: 13px;
        color: var(--gray);
        font-weight: 300;
        line-height: 1.6;
        margin-bottom: 14px;
        min-height: 38px;
    }

    .studio-equip {
        font-size: 11px;
        color: var(--gray);
        line-height: 1.7;
        border-top: 1px dashed var(--border);
        padding-top: 12px;
    }

    .studio-equip-label {
        font-size: 9px;
        font-weight: 600;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: var(--black);
        margin-bottom: 6px;
        display: block;
    }

    .studio-equip-list {
        display: flex;
        flex-wrap: wrap;
        gap: 4px 8px;
    }

    .studio-equip-list span::after {
        content: '·';
        margin-left: 8px;
        color: var(--border);
    }

    .studio-equip-list span:last-child::after { content: ''; }

    .studio-total {
        margin-top: 14px;
        padding-top: 12px;
        border-top: 1px solid var(--black);
        display: flex;
        justify-content: space-between;
        align-items: baseline;
    }

    .studio-total-label {
        font-size: 10px;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: var(--gray);
    }

    .studio-total-value {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 26px;
        letter-spacing: 0.02em;
    }

    /* ── EMPTY / LOADING ── */
    .results-empty,
    .results-loading,
    .results-error {
        padding: 56px 24px;
        text-align: center;
        border: 1px dashed var(--border);
    }

    .results-loading-dots {
        display: inline-flex;
        gap: 6px;
        margin-bottom: 14px;
    }

    .results-loading-dots span {
        width: 6px;
        height: 6px;
        background: var(--accent);
        border-radius: 50%;
        animation: bounce 0.9s infinite ease-in-out;
    }

    .results-loading-dots span:nth-child(2) { animation-delay: 0.15s; }
    .results-loading-dots span:nth-child(3) { animation-delay: 0.30s; }

    @keyframes bounce {
        0%, 80%, 100% { transform: scale(0.4); opacity: 0.4; }
        40%           { transform: scale(1);   opacity: 1; }
    }

    .results-empty-title,
    .results-loading-title,
    .results-error-title {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 22px;
        letter-spacing: 0.04em;
        margin-bottom: 6px;
    }

    .results-empty-sub,
    .results-loading-sub,
    .results-error-sub {
        font-size: 13px;
        color: var(--gray);
        font-weight: 300;
    }

    .results-error { border-color: var(--danger); background: #FDE8E8; }
    .results-error-title { color: #8B2020; }
    .results-error-sub   { color: #8B2020; }

    /* ── RECAP ── */
    .recap {
        background: var(--black);
        color: #fff;
        padding: 24px 28px;
        margin-bottom: 24px;
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 24px;
    }

    .recap-item-label {
        font-size: 9px;
        letter-spacing: 0.14em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.4);
        margin-bottom: 6px;
    }

    .recap-item-value {
        font-family: 'Bebas Neue', sans-serif;
        font-size: 22px;
        letter-spacing: 0.03em;
        line-height: 1.1;
        color: var(--accent);
    }

    .hidden { display: none !important; }

    @media (max-width: 640px) {
        .form-grid { grid-template-columns: 1fr; }
        .step-body { padding: 24px; }
    }
@endsection

@section('content')

    <div class="fade-1">
        <h1 class="page-title">RÉSERVER UN STUDIO</h1>
        <p class="page-sub reserv-intro">
            Renseignez votre besoin ci-dessous : nous vous proposons en temps réel les studios disponibles
            qui correspondent à votre activité, votre créneau et le nombre de personnes.
        </p>
    </div>

    @if($errors->any())
        <div class="alert alert-error fade-1">{{ $errors->first() }}</div>
    @endif

    <form id="reservation-form" method="POST" action="{{ route('reservations.sendReservation') }}">
        @csrf

        {{-- ── STEP 1 ─────────────────────────────────── --}}
        <section class="step-block fade-2">
            <div class="step-head">
                <span class="step-num">ÉTAPE 01</span>
                <h2 class="step-title">VOTRE BESOIN</h2>
            </div>

            <div class="step-body">
                <div class="form-grid">
                    <div class="field-r">
                        <label for="date">Date souhaitée</label>
                        <input type="date" id="date" name="date"
                               min="{{ date('Y-m-d') }}"
                               value="{{ old('date') }}" required>
                    </div>

                    <div class="field-r">
                        <label>Créneau horaire</label>
                        <div class="time-row">
                            <input type="time" id="heure_debut" name="heure_debut"
                                   value="{{ old('heure_debut', '14:00') }}" required>
                            <input type="time" id="heure_fin" name="heure_fin"
                                   value="{{ old('heure_fin', '16:00') }}" required>
                        </div>
                        <p class="helper">Studios ouverts de 9h00 à minuit.</p>
                    </div>

                    <div class="field-r">
                        <label for="id_activite">Activité</label>
                        <select id="id_activite" name="id_activite" required>
                            <option value="" disabled {{ old('id_activite') ? '' : 'selected' }}>
                                Choisir une activité…
                            </option>
                            @foreach($activites as $a)
                                <option value="{{ $a->id_activite }}"
                                        data-tech="{{ $a->employe_obligatoire ? '1' : '0' }}"
                                        {{ (string)old('id_activite') === (string)$a->id_activite ? 'selected' : '' }}>
                                    {{ ucfirst($a->type) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="field-r">
                        <label for="nb_personnes">Nombre de personnes</label>
                        <input type="number" id="nb_personnes" name="nb_personnes"
                               min="1" max="50"
                               value="{{ old('nb_personnes', 1) }}" required>
                    </div>

                    <div class="field-r full" id="tech-field" style="display:none;">
                        <label for="nb_techniciens">Nombre de techniciens souhaités</label>
                        <input type="number" id="nb_techniciens" name="nb_techniciens"
                               min="0" max="10"
                               value="{{ old('nb_techniciens', 0) }}">
                        <p class="helper">Cette activité requiert généralement la présence d'un technicien.</p>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" id="btn-search" class="btn btn-primary">
                        RECHERCHER LES STUDIOS <span class="arrow">→</span>
                    </button>
                    <a href="{{ route('client.dashboard') }}" class="btn btn-ghost">ANNULER</a>
                </div>
            </div>
        </section>

        {{-- ── STEP 2 ─────────────────────────────────── --}}
        <section class="step-block fade-3 hidden" id="step-2">
            <div class="step-head">
                <span class="step-num">ÉTAPE 02</span>
                <h2 class="step-title">STUDIOS DISPONIBLES</h2>
            </div>

            <div id="results-status" class="studios-status hidden"></div>

            <div id="results-loading" class="results-loading hidden">
                <div class="results-loading-dots"><span></span><span></span><span></span></div>
                <div class="results-loading-title">RECHERCHE EN COURS</div>
                <div class="results-loading-sub">Interrogation de la base de données…</div>
            </div>

            <div id="results-error" class="results-error hidden">
                <div class="results-error-title">UNE ERREUR EST SURVENUE</div>
                <div class="results-error-sub" id="results-error-msg">Veuillez réessayer dans un instant.</div>
            </div>

            <div id="results-empty" class="results-empty hidden">
                <div class="results-empty-title">AUCUN STUDIO DISPONIBLE</div>
                <div class="results-empty-sub">
                    Essayez un autre créneau ou une autre activité — nos studios sont très demandés.
                </div>
            </div>

            <div id="results-grid" class="studios-grid"></div>

            <input type="hidden" name="id_studio" id="id_studio" value="">
        </section>

        {{-- ── STEP 3 ─────────────────────────────────── --}}
        <section class="step-block fade-4 hidden" id="step-3">
            <div class="step-head">
                <span class="step-num">ÉTAPE 03</span>
                <h2 class="step-title">CONFIRMER LA DEMANDE</h2>
            </div>

            <div class="step-body">
                <div class="recap">
                    <div>
                        <div class="recap-item-label">Studio</div>
                        <div class="recap-item-value" id="recap-studio">—</div>
                    </div>
                    <div>
                        <div class="recap-item-label">Date</div>
                        <div class="recap-item-value" id="recap-date">—</div>
                    </div>
                    <div>
                        <div class="recap-item-label">Horaires</div>
                        <div class="recap-item-value" id="recap-time">—</div>
                    </div>
                    <div>
                        <div class="recap-item-label">Personnes</div>
                        <div class="recap-item-value" id="recap-people">—</div>
                    </div>
                    <div>
                        <div class="recap-item-label">Total estimé</div>
                        <div class="recap-item-value" id="recap-total">—</div>
                    </div>
                </div>

                <div class="form-grid">
                    <div class="field-r full">
                        <label for="description">Commentaire (optionnel)</label>
                        <textarea id="description" name="description" maxlength="40"
                                  placeholder="Précisions, besoins particuliers…">{{ old('description') }}</textarea>
                        <p class="helper">40 caractères maximum.</p>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-accent">
                        ENVOYER LA DEMANDE <span class="arrow">→</span>
                    </button>
                    <p class="helper" style="margin: 0;">
                        Votre demande sera examinée par notre équipe.
                    </p>
                </div>
            </div>
        </section>

    </form>

@endsection

@section('scripts')
<script>
(function () {
    const csrfToken = document.querySelector('input[name="_token"]').value;
    const searchUrl = "{{ route('reservations.checkAvailability') }}";

    const elDate     = document.getElementById('date');
    const elDebut    = document.getElementById('heure_debut');
    const elFin      = document.getElementById('heure_fin');
    const elActivite = document.getElementById('id_activite');
    const elPersonnes = document.getElementById('nb_personnes');
    const elTechField = document.getElementById('tech-field');

    const btnSearch = document.getElementById('btn-search');

    const step2 = document.getElementById('step-2');
    const step3 = document.getElementById('step-3');

    const elStatus  = document.getElementById('results-status');
    const elLoading = document.getElementById('results-loading');
    const elError   = document.getElementById('results-error');
    const elErrorMsg = document.getElementById('results-error-msg');
    const elEmpty   = document.getElementById('results-empty');
    const elGrid    = document.getElementById('results-grid');

    const elIdStudio = document.getElementById('id_studio');

    const recapStudio = document.getElementById('recap-studio');
    const recapDate   = document.getElementById('recap-date');
    const recapTime   = document.getElementById('recap-time');
    const recapPeople = document.getElementById('recap-people');
    const recapTotal  = document.getElementById('recap-total');

    /* show/hide nb_techniciens depending on activity */
    function syncTechField() {
        const opt = elActivite.options[elActivite.selectedIndex];
        if (opt && opt.dataset.tech === '1') {
            elTechField.style.display = '';
        } else {
            elTechField.style.display = 'none';
        }
    }
    elActivite.addEventListener('change', syncTechField);
    syncTechField();

    /* set sensible default date if empty */
    if (!elDate.value) {
        const d = new Date();
        d.setDate(d.getDate() + 1);
        elDate.value = d.toISOString().slice(0, 10);
    }

    /* ── helpers ─────────────────────────────────────── */
    function showOnly(node) {
        [elLoading, elError, elEmpty, elGrid].forEach(n => n.classList.add('hidden'));
        if (node) node.classList.remove('hidden');
    }

    function formatPrice(n) {
        return Number(n).toLocaleString('fr-FR', {
            minimumFractionDigits: 0, maximumFractionDigits: 0
        }) + ' €';
    }

    function formatDateFr(yyyymmdd) {
        const [y, m, d] = yyyymmdd.split('-');
        return `${d}/${m}/${y}`;
    }

    /* ── search ──────────────────────────────────────── */
    btnSearch.addEventListener('click', async function () {
        if (!elDate.value || !elDebut.value || !elFin.value
            || !elActivite.value || !elPersonnes.value) {
            elErrorMsg.textContent = "Merci de remplir tous les champs avant de lancer la recherche.";
            step2.classList.remove('hidden');
            elStatus.classList.add('hidden');
            showOnly(elError);
            step2.scrollIntoView({behavior: 'smooth', block: 'start'});
            return;
        }

        if (elFin.value <= elDebut.value) {
            elErrorMsg.textContent = "L'heure de fin doit être postérieure à l'heure de début.";
            step2.classList.remove('hidden');
            elStatus.classList.add('hidden');
            showOnly(elError);
            step2.scrollIntoView({behavior: 'smooth', block: 'start'});
            return;
        }

        /* reset selection */
        elIdStudio.value = '';
        step3.classList.add('hidden');

        step2.classList.remove('hidden');
        elStatus.classList.add('hidden');
        showOnly(elLoading);
        step2.scrollIntoView({behavior: 'smooth', block: 'start'});

        const payload = new FormData();
        payload.append('_token',       csrfToken);
        payload.append('date',         elDate.value);
        payload.append('heure_debut',  elDebut.value);
        payload.append('heure_fin',    elFin.value);
        payload.append('id_activite',  elActivite.value);
        payload.append('nb_personnes', elPersonnes.value);

        try {
            const resp = await fetch(searchUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept':       'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: payload,
            });

            if (!resp.ok) {
                const data = await resp.json().catch(() => ({}));
                elErrorMsg.textContent = data.error
                    || (data.message || `Erreur ${resp.status}.`);
                showOnly(elError);
                return;
            }

            const data = await resp.json();
            renderResults(data);
        } catch (e) {
            elErrorMsg.textContent = "Impossible de joindre le serveur. Vérifiez votre connexion.";
            showOnly(elError);
        }
    });

    /* ── render ──────────────────────────────────────── */
    function renderResults(data) {
        const studios = data.studios || [];
        const duree   = data.duree   || 0;

        elStatus.innerHTML = `
            <strong>${studios.length}</strong> studio${studios.length > 1 ? 's' : ''}
            disponible${studios.length > 1 ? 's' : ''}
            le <strong>${formatDateFr(elDate.value)}</strong>
            de <strong>${elDebut.value}</strong> à <strong>${elFin.value}</strong>
            (${duree.toFixed(duree % 1 === 0 ? 0 : 1)}h).
        `;
        elStatus.classList.remove('hidden');

        if (studios.length === 0) {
            showOnly(elEmpty);
            return;
        }

        elGrid.innerHTML = '';
        studios.forEach((s, idx) => {
            const card = document.createElement('div');
            card.className = 'studio-card';
            card.style.animationDelay = (0.04 * idx) + 's';
            card.dataset.id   = s.id_studio;
            card.dataset.num  = s.numero_studio;
            card.dataset.total = s.prix_estime;

            const equip = (s.materiels && s.materiels.length)
                ? `<div class="studio-equip">
                       <span class="studio-equip-label">Équipement</span>
                       <div class="studio-equip-list">
                           ${s.materiels.map(m => `<span>${escapeHtml(m.nom)}</span>`).join('')}
                       </div>
                   </div>`
                : '';

            const desc = s.description
                ? `<p class="studio-desc">${escapeHtml(s.description)}</p>`
                : `<p class="studio-desc">Studio ${escapeHtml(s.activite_type)} — ${escapeHtml(s.structure_nom)}.</p>`;

            card.innerHTML = `
                <div class="studio-head">
                    <div class="studio-num">
                        <small>Studio</small>${String(s.numero_studio).padStart(2, '0')}
                    </div>
                    <div class="studio-rate">
                        ${formatPrice(s.taux_horaire)}<small>/h</small>
                    </div>
                </div>
                <div class="studio-meta">
                    <span class="chip">${escapeHtml(s.activite_type)}</span>
                    <span class="chip">${s.capacite} pers. max</span>
                    ${s.amenageable == 1 ? '<span class="chip">aménageable</span>' : ''}
                </div>
                ${desc}
                ${equip}
                <div class="studio-total">
                    <span class="studio-total-label">Total estimé</span>
                    <span class="studio-total-value">${formatPrice(s.prix_estime)}</span>
                </div>
            `;

            card.addEventListener('click', () => selectStudio(card, s));
            elGrid.appendChild(card);
        });

        showOnly(elGrid);
    }

    /* ── select ──────────────────────────────────────── */
    function selectStudio(card, s) {
        elGrid.querySelectorAll('.studio-card').forEach(c => c.classList.remove('selected'));
        card.classList.add('selected');
        elIdStudio.value = s.id_studio;

        recapStudio.textContent = 'N°' + String(s.numero_studio).padStart(2, '0');
        recapDate.textContent   = formatDateFr(elDate.value);
        recapTime.textContent   = elDebut.value + ' → ' + elFin.value;
        recapPeople.textContent = elPersonnes.value;
        recapTotal.textContent  = formatPrice(s.prix_estime);

        step3.classList.remove('hidden');
        setTimeout(() => step3.scrollIntoView({behavior: 'smooth', block: 'start'}), 80);
    }

    /* ── safety ──────────────────────────────────────── */
    function escapeHtml(str) {
        return String(str ?? '').replace(/[&<>"']/g, c => ({
            '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;'
        }[c]));
    }

    /* prevent submit without studio */
    document.getElementById('reservation-form').addEventListener('submit', function (e) {
        if (!elIdStudio.value) {
            e.preventDefault();
            alert('Merci de sélectionner un studio avant d\'envoyer la demande.');
        }
    });
})();
</script>
@endsection
