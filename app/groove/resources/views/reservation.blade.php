@extends('layouts.app')
@section('title', 'Réservation')

@section('styles')
<style>
/* ── WIZARD ── */
.wizard {
    display: grid;
    grid-template-columns: 1fr 1fr 1.5fr 1fr;
    border: 0.5px solid var(--border);
    background: #fff;
}
.wiz-col {
    padding: 28px 24px;
    border-right: 0.5px solid var(--border);
    display: flex; flex-direction: column;
    min-height: 280px;
    transition: opacity 0.2s;
}
.wiz-col:last-child { border-right: none; }
.wiz-col.pending    { opacity: 0.25; pointer-events: none; user-select: none; }

/* ── COLUMN HEADER ── */
.wiz-hdr {
    display: flex; align-items: center; gap: 12px;
    padding-bottom: 18px; margin-bottom: 22px;
    border-bottom: 0.5px solid var(--border);
}
.wiz-num {
    width: 26px; height: 26px; flex-shrink: 0;
    border: 1px solid var(--border);
    display: flex; align-items: center; justify-content: center;
    font-size: 10px; font-weight: 500; letter-spacing: 0.04em;
    color: var(--gray); transition: all 0.2s;
}
.wiz-col.active .wiz-num { background: var(--black); border-color: var(--black); color: var(--cream); }
.wiz-col.done   .wiz-num { background: var(--black); border-color: var(--black); color: var(--accent); }
.wiz-title {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 22px; letter-spacing: 0.1em;
    color: var(--gray);
}
.wiz-col.active .wiz-title,
.wiz-col.done   .wiz-title { color: var(--black); }

/* ── DONE STATE ── */
.done-val {
    font-family: 'Bebas Neue', sans-serif;
    font-size: 24px; letter-spacing: 0.03em; line-height: 1.2;
    color: var(--black); margin-bottom: 4px;
}
.done-sub  { font-size: 12px; color: var(--gray); font-weight: 300; margin-bottom: 14px; }
.done-edit {
    font-size: 10px; letter-spacing: 0.08em; text-transform: uppercase;
    color: var(--gray); background: none; border: none; border-bottom: 1px solid var(--border);
    cursor: pointer; font-family: inherit; padding: 0;
    transition: color 0.15s, border-color 0.15s;
}
.done-edit:hover { color: var(--black); border-bottom-color: var(--black); }

/* ── PENDING HINT ── */
.pending-hint { font-size: 12px; color: var(--gray); font-weight: 300; font-style: italic; }

/* ── MINI CHOICE CARDS ── */
.mini-cards { display: flex; flex-direction: column; gap: 8px; flex: 1; }
.mini-card {
    display: flex; align-items: center; gap: 8px;
    padding: 10px 13px;
    background: var(--cream); border: 0.5px solid var(--border);
    text-decoration: none; color: var(--black);
    cursor: pointer; font-family: inherit;
    transition: border-color 0.15s, background 0.15s;
    text-align: left; width: 100%;
}
.mini-card:hover { border-color: var(--black); background: #fff; }
.mini-card-idx  { font-size: 10px; color: var(--gray); letter-spacing: 0.1em; flex-shrink: 0; }
.mini-card-name { font-family: 'Bebas Neue', sans-serif; font-size: 17px; letter-spacing: 0.04em; flex: 1; }
.mini-card-rate { font-size: 11px; color: var(--accent); flex-shrink: 0; }
.mini-card-arrow { font-size: 13px; color: var(--border); transition: color 0.15s; flex-shrink: 0; }
.mini-card:hover .mini-card-arrow { color: var(--black); }

/* ── CALENDAR ── */
.cal-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 14px; }
.cal-month  { font-family: 'Bebas Neue', sans-serif; font-size: 18px; letter-spacing: 0.06em; }
.cal-btn {
    width: 28px; height: 28px; border: 1px solid var(--border);
    background: transparent; cursor: pointer; font-size: 15px; color: var(--black);
    display: flex; align-items: center; justify-content: center;
    transition: border-color 0.15s; font-family: inherit;
}
.cal-btn:hover { border-color: var(--black); }
.cal-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 2px; margin-bottom: 4px; }
.cal-dh {
    text-align: center; font-size: 9px; font-weight: 500;
    letter-spacing: 0.06em; text-transform: uppercase; color: var(--gray); padding: 4px 0;
}
.cal-d {
    aspect-ratio: 1; display: flex; flex-direction: column;
    align-items: center; justify-content: center;
    font-size: 12px; position: relative; gap: 2px; border-radius: 2px;
}
.cal-d.avail { cursor: pointer; transition: background 0.12s; }
.cal-d.avail:hover { background: rgba(0,0,0,0.06); }
.cal-d.past  { color: var(--border); cursor: default; }
.cal-d.sel   { background: var(--black) !important; color: #fff !important; }
.cal-d .dot  { width: 3px; height: 3px; background: var(--accent); border-radius: 50%; }
.cal-d.sel .dot { background: rgba(255,255,255,0.4); }

/* ── TIME PICKER ── */
.tp-sep { border-top: 0.5px solid var(--border); padding-top: 16px; margin-top: 10px; }
.tp-date { font-size: 12px; font-weight: 500; color: var(--black); margin-bottom: 12px; text-transform: capitalize; }
.tl-hours { display: flex; justify-content: space-between; font-size: 9px; color: var(--gray); margin-bottom: 3px; }
.tl-track { height: 20px; background: #EDE9E1; border: 1px solid var(--border); position: relative; overflow: hidden; margin-bottom: 4px; }
.tl-occ   { position: absolute; top: 0; height: 100%; background: #D94040; opacity: 0.5; }
.tl-note  { font-size: 10px; color: var(--gray); font-weight: 300; margin-bottom: 14px; }
.time-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; margin-bottom: 14px; }
.form-field { display: flex; flex-direction: column; gap: 6px; }
.form-label { font-size: 9px; font-weight: 500; letter-spacing: 0.12em; text-transform: uppercase; color: var(--gray); }
.form-input {
    padding: 9px 11px; font-family: 'DM Sans', sans-serif; font-size: 13px;
    color: var(--black); background: #fff; border: 1px solid var(--border);
    outline: none; transition: border-color 0.2s; width: 100%;
    -webkit-appearance: none; appearance: none;
}
.form-input:focus { border-color: var(--black); }
.price-box {
    background: var(--black); padding: 12px 14px; margin-bottom: 14px;
    justify-content: space-between; align-items: center;
}
.price-box-lbl { font-size: 9px; letter-spacing: 0.1em; text-transform: uppercase; color: rgba(255,255,255,0.4); margin-bottom: 2px; }
.price-box-val { font-family: 'Bebas Neue', sans-serif; font-size: 24px; letter-spacing: 0.03em; color: var(--accent); }
.price-box-dur { font-size: 12px; color: rgba(255,255,255,0.55); }

/* ── STEP 4 ── */
.booking-mini { background: var(--black); padding: 14px 16px; margin-bottom: 18px; display: flex; flex-direction: column; gap: 8px; }
.bm-row  { display: flex; justify-content: space-between; align-items: baseline; gap: 8px; }
.bm-lbl  { font-size: 9px; letter-spacing: 0.1em; text-transform: uppercase; color: rgba(255,255,255,0.35); flex-shrink: 0; }
.bm-val  { font-size: 13px; color: #fff; font-weight: 300; text-align: right; }
.bm-val.accent { font-family: 'Bebas Neue', sans-serif; font-size: 22px; letter-spacing: 0.03em; color: var(--accent); }
.id-title { font-family: 'Bebas Neue', sans-serif; font-size: 16px; letter-spacing: 0.08em; margin-bottom: 4px; }
.id-sub   { font-size: 11px; color: var(--gray); font-weight: 300; margin-bottom: 14px; line-height: 1.5; }
.id-sep   { height: 0.5px; background: var(--border); margin: 18px 0; }
.gf       { display: flex; flex-direction: column; gap: 5px; margin-bottom: 10px; }
.user-pill-name  { font-size: 14px; font-weight: 500; color: var(--black); }
.user-pill-email { font-size: 11px; color: var(--gray); font-weight: 300; margin-bottom: 14px; }

@media (max-width: 960px) {
    .wizard { grid-template-columns: 1fr 1fr; }
    .wiz-col { border-bottom: 0.5px solid var(--border); min-height: auto; }
    .wiz-col:nth-child(2n)         { border-right: none; }
    .wiz-col:nth-last-child(-n+2)  { border-bottom: none; }
}
@media (max-width: 580px) {
    .wizard { grid-template-columns: 1fr; }
    .wiz-col { border-right: none; border-bottom: 0.5px solid var(--border); }
    .wiz-col:last-child { border-bottom: none; }
    .wiz-col.pending { display: none; }
}
</style>
@endsection

@section('content')

<div class="fade-1">
    <h1 class="page-title">RÉSERVATION</h1>
    <p class="page-sub">Réservez votre studio en quelques étapes.</p>
</div>

<div class="wizard fade-2" id="wizard">
    <div class="wiz-col" id="col-1">
        <div class="wiz-hdr">
            <span class="wiz-num" id="num-1">01</span>
            <span class="wiz-title">ACTIVITÉ</span>
        </div>
        <div id="body-1"></div>
    </div>
    <div class="wiz-col" id="col-2">
        <div class="wiz-hdr">
            <span class="wiz-num" id="num-2">02</span>
            <span class="wiz-title">STUDIO</span>
        </div>
        <div id="body-2"></div>
    </div>
    <div class="wiz-col" id="col-3">
        <div class="wiz-hdr">
            <span class="wiz-num" id="num-3">03</span>
            <span class="wiz-title">CRÉNEAU</span>
        </div>
        <div id="body-3"></div>
    </div>
    <div class="wiz-col" id="col-4">
        <div class="wiz-hdr">
            <span class="wiz-num" id="num-4">04</span>
            <span class="wiz-title">COORDONNÉES</span>
        </div>
        <div id="body-4"></div>
    </div>
</div>

@endsection

@section('scripts')
<script>
(function () {

/* ── DATA FROM PHP ── */
const ACTIVITES       = @json($activites);
const STUDIOS_BY_ACT  = @json($studios);   // { act_id: [{numero_studio, taux_horaire, ...}] }
const SESSIONS_BY_STU = @json($sessions);  // { studio_id: [{debut, fin}] }
const IS_AUTH         = {{ Auth::check() ? 'true' : 'false' }};
const AUTH_USER       = {!! Auth::check() ? json_encode(['prenom' => Auth::user()->prenom, 'nom' => Auth::user()->nom, 'email' => Auth::user()->email]) : 'null' !!};
const CSRF            = '{{ csrf_token() }}';
const SUBMIT_URL      = '{{ route("reservation.submit") }}';
const LOGIN_URL       = '{{ route("login") }}';
const ACT_DESC        = {
    'Enregistrement': 'Captez vos performances',
    'Répétition':     'Préparez vos concerts',
    'Mix':            'Sculptez votre son',
    'Mastering':      'Finalisez votre production',
};

/* ── STATE ── */
const state = {
    step:        1,
    activite:    null,   // { id, type }
    studio:      null,   // full studio object
    calYear:     new Date().getFullYear(),
    calMonth:    new Date().getMonth(),
    calSelected: null,   // 'YYYY-MM-DD'
    debut:       null,   // 'HH:MM'
    fin:         null,
};

/* ── RESTORE after login redirect ── */
try {
    const saved = sessionStorage.getItem('grooveWizard');
    if (saved && IS_AUTH) {
        sessionStorage.removeItem('grooveWizard');
        const d = JSON.parse(saved);
        const act = ACTIVITES.find(a => a.id_activite == d.activiteId);
        if (act) {
            const stu = Object.values(STUDIOS_BY_ACT).flat().find(s => s.numero_studio == d.studioId);
            if (stu) {
                state.activite    = { id: act.id_activite, type: act.type };
                state.studio      = stu;
                state.calSelected = d.date || null;
                state.debut       = d.debut || null;
                state.fin         = d.fin || null;
                state.step        = (d.debut && d.fin) ? 4 : (d.date ? 3 : 2);
                if (d.date) { const [y, m] = d.date.split('-').map(Number); state.calYear = y; state.calMonth = m - 1; }
            }
        }
    }
} catch (e) {}

/* ── HELPERS ── */
function pad(n)      { return String(n).padStart(2, '0'); }
function toMin(hhmm) { const [h, m] = hhmm.split(':').map(Number); return h * 60 + m; }
function fmtDur(h)   { const hi = Math.floor(h), m = Math.round((h - hi) * 60); return (hi > 0 ? hi + 'h' : '') + (m > 0 ? m + 'min' : ''); }
function esc(s)      { return String(s).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }
function hiddenInputs(extra) {
    return `<input type="hidden" name="_token"      value="${CSRF}">
            <input type="hidden" name="studio_id"   value="${state.studio?.numero_studio}">
            <input type="hidden" name="activite_id" value="${state.activite?.id}">
            <input type="hidden" name="date"        value="${state.calSelected}">
            <input type="hidden" name="debut"       value="${state.debut}">
            <input type="hidden" name="fin"         value="${state.fin}">
            ${extra || ''}`;
}

/* ── ACTIONS ── */
function selectActivity(id, type) {
    Object.assign(state, { activite: { id, type }, studio: null, calSelected: null, debut: null, fin: null, step: 2 });
    render();
}
function selectStudio(stu) {
    Object.assign(state, { studio: stu, calSelected: null, debut: null, fin: null, step: 3 });
    render();
}
function pickDay(key, year, month) {
    Object.assign(state, { calSelected: key, calYear: year, calMonth: month, debut: null, fin: null });
    render();
}
function prevMonth() { if (--state.calMonth < 0) { state.calMonth = 11; state.calYear--; } renderCol(3); }
function nextMonth() { if (++state.calMonth > 11) { state.calMonth = 0;  state.calYear++; } renderCol(3); }
function goToStep(n) {
    state.step = n;
    if (n <= 3) { state.fin = null; state.debut = null; state.calSelected = null; }
    if (n <= 2) { state.studio = null; }
    if (n <= 1) { state.activite = null; }
    render();
}
function confirmSlot() {
    if (!state.debut || !state.fin || state.fin <= state.debut) return;
    state.step = 4;
    render();
}

/* ── RENDER ── */
function render() { [1, 2, 3, 4].forEach(renderCol); }

function renderCol(n) {
    const col  = document.getElementById('col-'  + n);
    const num  = document.getElementById('num-'  + n);
    const body = document.getElementById('body-' + n);
    const isActive  = state.step === n;
    const isDone    = state.step > n;
    col.className   = 'wiz-col ' + (isActive ? 'active' : isDone ? 'done' : 'pending');
    num.textContent = isDone ? '✓' : '0' + n;
    body.innerHTML  = [b1, b2, b3, b4][n - 1]();
}

/* ── BODY RENDERERS ── */
function b1() {
    if (state.step > 1) {
        return `<div class="done-val">${esc(state.activite.type.toUpperCase())}</div>
                <button class="done-edit" data-action="goto" data-step="1">← Modifier</button>`;
    }
    return `<div class="mini-cards">${ACTIVITES.map((a, i) => `
        <button class="mini-card" data-action="sel-act" data-id="${a.id_activite}" data-type="${esc(a.type)}">
            <span class="mini-card-idx">0${i + 1}</span>
            <span class="mini-card-name">${esc(a.type.toUpperCase())}</span>
            <span class="mini-card-arrow">→</span>
        </button>`).join('')}</div>`;
}

function b2() {
    if (state.step < 2) return `<p class="pending-hint">Sélectionnez d'abord une activité.</p>`;
    if (state.step > 2) {
        return `<div class="done-val">STUDIO ${state.studio.numero_studio}</div>
                <div class="done-sub">${state.studio.taux_horaire} €/h</div>
                <button class="done-edit" data-action="goto" data-step="2">← Modifier</button>`;
    }
    const list = STUDIOS_BY_ACT[state.activite.id] || [];
    if (!list.length) return `<p class="pending-hint">Aucun studio pour cette activité.</p>`;
    return `<div class="mini-cards">${list.map(s => `
        <button class="mini-card" data-action="sel-stu" data-sid="${s.numero_studio}">
            <span class="mini-card-name">STUDIO ${s.numero_studio}</span>
            <span class="mini-card-rate">${s.taux_horaire} €/h</span>
            <span class="mini-card-arrow">→</span>
        </button>`).join('')}</div>`;
}

function b3() {
    if (state.step < 3) return `<p class="pending-hint">Sélectionnez d'abord un studio.</p>`;
    if (state.step > 3) {
        const [y, mo, d] = state.calSelected.split('-');
        return `<div class="done-val">${d}/${mo}/${y}</div>
                <div class="done-sub">${state.debut.replace(':','h')} → ${state.fin.replace(':','h')}</div>
                <button class="done-edit" data-action="goto" data-step="3">← Modifier</button>`;
    }

    /* Build occupied-by-date map */
    const raw = SESSIONS_BY_STU[state.studio.numero_studio] || [];
    const byDate = {};
    raw.forEach(s => {
        const k = s.debut.slice(0, 10);
        if (!byDate[k]) byDate[k] = [];
        byDate[k].push({ start: toMin(s.debut.slice(11,16)), end: toMin(s.fin.slice(11,16)), startStr: s.debut.slice(11,16), endStr: s.fin.slice(11,16) });
    });

    /* Calendar grid */
    const MFULL = ['Janvier','Février','Mars','Avril','Mai','Juin','Juillet','Août','Septembre','Octobre','Novembre','Décembre'];
    const DSH   = ['Lu','Ma','Me','Je','Ve','Sa','Di'];
    const { calYear: cy, calMonth: cm, calSelected: sel } = state;
    const today = new Date(); today.setHours(0,0,0,0);

    let html = `<div class="cal-header">
        <button class="cal-btn" data-action="prev-month">‹</button>
        <span class="cal-month">${MFULL[cm]} ${cy}</span>
        <button class="cal-btn" data-action="next-month">›</button>
    </div>
    <div class="cal-grid">${DSH.map(d => `<div class="cal-dh">${d}</div>`).join('')}`;

    let off = new Date(cy, cm, 1).getDay() - 1; if (off < 0) off = 6;
    for (let i = 0; i < off; i++) html += '<div class="cal-d"></div>';

    const tot = new Date(cy, cm + 1, 0).getDate();
    for (let d = 1; d <= tot; d++) {
        const dt  = new Date(cy, cm, d);
        const key = `${cy}-${pad(cm+1)}-${pad(d)}`;
        const past = dt < today, busy = !!byDate[key], isSel = key === sel;
        const cls  = 'cal-d' + (past ? ' past' : ' avail') + (isSel ? ' sel' : '');
        const dot  = busy && !past ? '<span class="dot"></span>' : '';
        html += past
            ? `<div class="${cls}">${d}${dot}</div>`
            : `<div class="${cls}" data-action="pick-day" data-key="${key}" data-cy="${cy}" data-cm="${cm}">${d}${dot}</div>`;
    }
    html += '</div>';

    /* Time picker */
    if (sel) {
        const occ = byDate[sel] || [];
        const S = 480, E = 1320, T = E - S;
        const blocks = occ.map(s =>
            `<div class="tl-occ" style="left:${((s.start-S)/T*100).toFixed(1)}%;width:${((s.end-s.start)/T*100).toFixed(1)}%" title="${s.startStr}–${s.endStr}"></div>`
        ).join('');

        const DLG  = ['Dimanche','Lundi','Mardi','Mercredi','Jeudi','Vendredi','Samedi'];
        const MLG  = ['janvier','février','mars','avril','mai','juin','juillet','août','septembre','octobre','novembre','décembre'];
        const sd   = new Date(parseInt(sel.slice(0,4)), parseInt(sel.slice(5,7))-1, parseInt(sel.slice(8,10)));
        const dlbl = `${DLG[sd.getDay()]} ${sd.getDate()} ${MLG[sd.getMonth()]} ${sd.getFullYear()}`;

        const ok   = state.debut && state.fin && state.fin > state.debut;
        const durH = ok ? (toMin(state.fin) - toMin(state.debut)) / 60 : 0;

        html += `<div class="tp-sep">
            <p class="tp-date">${dlbl}</p>
            <div class="tl-hours"><span>8h</span><span>10h</span><span>12h</span><span>14h</span><span>16h</span><span>18h</span><span>20h</span><span>22h</span></div>
            <div class="tl-track">${blocks}</div>
            <p class="tl-note">Rouge = déjà réservé</p>
            <div class="time-row">
                <div class="form-field">
                    <label class="form-label">Début</label>
                    <input class="form-input" type="time" id="inp-debut" step="1800" min="08:00" max="21:30" value="${state.debut||''}">
                </div>
                <div class="form-field">
                    <label class="form-label">Fin</label>
                    <input class="form-input" type="time" id="inp-fin" step="1800" min="08:30" max="22:00" value="${state.fin||''}">
                </div>
            </div>
            <div class="price-box" id="pb-box" style="display:${ok?'flex':'none'};">
                <div><div class="price-box-lbl">Durée</div><div class="price-box-dur" id="pb-dur">${ok?fmtDur(durH):'—'}</div></div>
                <div style="text-align:right;"><div class="price-box-lbl">Estimation</div><div class="price-box-val" id="pb-val">${ok?Math.round(state.studio.taux_horaire*durH).toLocaleString('fr-FR')+' €':'—'}</div></div>
            </div>
            <button class="btn btn-primary" id="pb-continue" ${ok?'data-action="confirm-slot"':'disabled'}
                    style="width:100%;justify-content:center;${ok?'':'opacity:.35;cursor:not-allowed;'}">CONTINUER →</button>
        </div>`;
    }
    return html;
}

function b4() {
    if (state.step < 4) return `<p class="pending-hint">Sélectionnez un créneau pour finaliser.</p>`;

    const durH = (toMin(state.fin) - toMin(state.debut)) / 60;
    const [y, mo, d] = state.calSelected.split('-');
    const prix = Math.round(state.studio.taux_horaire * durH);

    let html = `<div class="booking-mini">
        <div class="bm-row"><span class="bm-lbl">Studio</span><span class="bm-val">Studio ${state.studio.numero_studio}</span></div>
        <div class="bm-row"><span class="bm-lbl">${d}/${mo}/${y}</span><span class="bm-val">${state.debut.replace(':','h')} → ${state.fin.replace(':','h')}</span></div>
        <div class="bm-row"><span class="bm-lbl">Total</span><span class="bm-val accent">${prix.toLocaleString('fr-FR')} €</span></div>
    </div>`;

    const hi = hiddenInputs();

    if (IS_AUTH) {
        html += `<div class="user-pill-name">${esc(AUTH_USER.prenom)} ${esc(AUTH_USER.nom)}</div>
                 <div class="user-pill-email">${esc(AUTH_USER.email)}</div>
                 <form id="confirm-form" method="POST" action="${SUBMIT_URL}" style="margin-top:14px;">${hi}
                     <button type="submit" class="btn btn-accent" style="width:100%;justify-content:center;">CONFIRMER →</button>
                 </form>`;
    } else {
        html += `<div class="id-title">SE CONNECTER</div>
                 <div class="id-sub">Suivez vos réservations depuis votre espace client.</div>
                 <button class="btn btn-primary" data-action="goto-login" style="width:100%;justify-content:center;">CONNEXION →</button>
                 <div class="id-sep"></div>
                 <div class="id-title">CONTINUER EN INVITÉ</div>
                 <div class="id-sub">Renseignez simplement vos coordonnées.</div>
                 <div id="guest-err" class="alert alert-error" style="display:none;margin-bottom:10px;font-size:12px;"></div>
                 <form id="guest-form" method="POST" action="${SUBMIT_URL}">${hi}
                     <div class="gf"><label class="form-label">Prénom *</label><input class="form-input" type="text" name="prenom" required placeholder="Votre prénom"></div>
                     <div class="gf"><label class="form-label">Nom</label><input class="form-input" type="text" name="nom" placeholder="Votre nom"></div>
                     <div class="gf"><label class="form-label">Email *</label><input class="form-input" type="email" name="email" required placeholder="votre@email.com"></div>
                     <div class="gf" style="margin-bottom:14px;"><label class="form-label">Téléphone</label><input class="form-input" type="tel" name="telephone" placeholder="+33 6 ..."></div>
                     <button type="submit" class="btn btn-accent" style="width:100%;justify-content:center;">CONFIRMER →</button>
                 </form>`;
    }
    return html;
}

/* ── EVENT DELEGATION ── */
const wizard = document.getElementById('wizard');

wizard.addEventListener('click', function (e) {
    const el = e.target.closest('[data-action]');
    if (!el) return;
    e.preventDefault();

    switch (el.dataset.action) {
        case 'sel-act':    selectActivity(parseInt(el.dataset.id), el.dataset.type); break;
        case 'sel-stu': {
            const sid = parseInt(el.dataset.sid);
            const stu = Object.values(STUDIOS_BY_ACT).flat().find(s => s.numero_studio == sid);
            if (stu) selectStudio(stu);
            break;
        }
        case 'pick-day':   pickDay(el.dataset.key, parseInt(el.dataset.cy), parseInt(el.dataset.cm)); break;
        case 'prev-month': prevMonth(); break;
        case 'next-month': nextMonth(); break;
        case 'confirm-slot': confirmSlot(); break;
        case 'goto':       goToStep(parseInt(el.dataset.step)); break;
        case 'goto-login':
            sessionStorage.setItem('grooveWizard', JSON.stringify({
                activiteId: state.activite?.id, studioId: state.studio?.numero_studio,
                date: state.calSelected, debut: state.debut, fin: state.fin,
            }));
            window.location.href = LOGIN_URL;
            break;
    }
});

/* Time inputs: update price without re-rendering */
wizard.addEventListener('change', function (e) {
    if (e.target.id !== 'inp-debut' && e.target.id !== 'inp-fin') return;
    if (e.target.id === 'inp-debut') {
        const finEl = document.getElementById('inp-fin');
        if (finEl?.value && finEl.value <= e.target.value) finEl.value = '';
        if (finEl) finEl.min = e.target.value;
    }
    state.debut = document.getElementById('inp-debut')?.value || null;
    state.fin   = document.getElementById('inp-fin')?.value   || null;

    const ok  = state.debut && state.fin && state.fin > state.debut;
    const box = document.getElementById('pb-box');
    const btn = document.getElementById('pb-continue');
    if (!box || !btn) return;

    if (ok) {
        const durH = (toMin(state.fin) - toMin(state.debut)) / 60;
        document.getElementById('pb-dur').textContent = fmtDur(durH);
        document.getElementById('pb-val').textContent = Math.round(state.studio.taux_horaire * durH).toLocaleString('fr-FR') + ' €';
        box.style.display = 'flex';
        btn.disabled = false; btn.style.opacity = '1'; btn.style.cursor = 'pointer';
        btn.setAttribute('data-action', 'confirm-slot');
    } else {
        box.style.display = 'none';
        btn.disabled = true; btn.style.opacity = '0.35'; btn.style.cursor = 'not-allowed';
        btn.removeAttribute('data-action');
    }
});

/* AJAX form submission */
wizard.addEventListener('submit', function (e) {
    if (e.target.id !== 'confirm-form' && e.target.id !== 'guest-form') return;
    e.preventDefault();
    submitReservation(e.target);
});

async function submitReservation(form) {
    const btn = form.querySelector('button[type="submit"]');
    btn.disabled = true;
    const origText = btn.textContent;
    btn.textContent = 'ENVOI…';

    try {
        const resp = await fetch(SUBMIT_URL, {
            method: 'POST',
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' },
            body: new FormData(form),
        });
        const data = await resp.json();

        if (resp.ok && data.success) {
            document.getElementById('body-4').innerHTML = `
                <div style="padding:16px 0; text-align:center;">
                    <div style="font-family:'Bebas Neue',sans-serif;font-size:28px;letter-spacing:0.05em;color:var(--black);margin-bottom:10px;">DEMANDE ENVOYÉE</div>
                    <p style="font-size:13px;color:var(--gray);font-weight:300;line-height:1.6;">${esc(data.message)}</p>
                    ${data.redirect ? `<a href="${data.redirect}" class="btn btn-accent" style="margin-top:20px;width:100%;justify-content:center;">MON ESPACE →</a>` : ''}
                </div>`;
        } else if (resp.status === 409) {
            showErr(data.message || 'Ce créneau n\'est plus disponible.');
            btn.disabled = false; btn.textContent = origText;
        } else {
            const errs = data.errors ? Object.values(data.errors).flat().join(' ') : (data.message || 'Erreur.');
            showErr(errs);
            btn.disabled = false; btn.textContent = origText;
        }
    } catch (err) {
        showErr('Une erreur est survenue. Veuillez réessayer.');
        btn.disabled = false; btn.textContent = origText;
    }
}

function showErr(msg) {
    const el = document.getElementById('guest-err');
    if (el) { el.textContent = msg; el.style.display = 'block'; }
}

/* ── INIT ── */
render();

})();
</script>
@endsection