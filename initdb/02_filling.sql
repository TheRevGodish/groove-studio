-- ============================================================
--                          INSERT
--  Ordre à respecter pour les contraintes FK
-- ============================================================

-- Structure
INSERT INTO Structure (nom)
VALUES ('Groove'); -- id_structure = 1

-- Activite
INSERT INTO Activite (type, employe_obligatoire)
VALUES ('Répétition', FALSE),    -- id_activite = 1
       ('Enregistrement', FALSE), -- id_activite = 2
       ('Mix', FALSE),            -- id_activite = 3
       ('Mastering', TRUE);       -- id_activite = 4

-- Specialite
INSERT INTO Specialite (description, taux_horaire)
VALUES ('Technicien son', 25),      -- id_specialite = 1
       ('Ingénieur son', 40),       -- id_specialite = 2
       ('Ingénieur mastering', 70); -- id_specialite = 3

-- Studio (dépend de Structure et Activite)
INSERT INTO Studio (numero_studio, capacite, amenageable, taux_horaire, siren, description, id_activite, id_structure)
VALUES (1, 2,  FALSE, 60, '123456789', 'Mastering analog/digital, acoustique calibrée',   4, 1), -- id_studio = 1
       (2, 4,  FALSE, 35, '123456789', 'Régie SSL pour mixage stéréo et immersif',        3, 1), -- id_studio = 2
       (3, 8,  TRUE,  25, '123456789', 'Live room polyvalente avec grand piano droit',    2, 1), -- id_studio = 3
       (4, 6,  TRUE,  20, '123456789', 'Cabine d''enregistrement isolée et chaleureuse',  2, 1), -- id_studio = 4
       (5, 10, TRUE,  12, '123456789', 'Local de répétition équipé pour groupe complet',  1, 1), -- id_studio = 5
       (6, 6,  TRUE,   8, '123456789', 'Salle de répétition compacte pour duo/trio',      1, 1); -- id_studio = 6

-- Employe (dépend de Structure)
INSERT INTO Employe (nom, prenom, nir, siren, id_structure)
VALUES ('DUPONT',  'Henri',   '197053226784966', '123456789', 1), -- id_employe = 1
       ('CROCHE',  'Sarah',   '295053363784421', '123456789', 1), -- id_employe = 2
       ('MAGNE',   'Charles', '190050860784471', '123456789', 1), -- id_employe = 3
       ('POLEGUE', 'Patrick', '108115660174310', '123456789', 1); -- id_employe = 4

-- avoir_pour_specialite (dépend de Employe et Specialite)
INSERT INTO avoir_pour_specialite (id_employe, id_specialite)
VALUES (1, 2), -- DUPONT  → ingénieur son
       (2, 3), -- CROCHE  → ingénieur mastering
       (3, 1), -- MAGNE   → technicien son
       (4, 1); -- POLEGUE → technicien son

-- Utilisateur
INSERT INTO Utilisateur (nom, prenom, password, email, telephone, is_admin)
VALUES ('SAJUS',     'Thomas',    'password', 'thomas.sajus@hotmail.fr',        '0640973094', FALSE), -- id_utilisateur = 1
       ('SCHNEIDER', 'Rodolphe',  'password', 'rodolphe.schneider@gmail.com',   '0789947201', TRUE),  -- id_utilisateur = 2
       ('MOREL',     'Léa',       'password', 'lea.morel@gmail.com',            '0612345678', FALSE), -- id_utilisateur = 3
       ('BERNARD',   'Antoine',   'password', 'antoine.bernard@gmail.com',      '0623456789', FALSE), -- id_utilisateur = 4
       ('LEROY',     'Camille',   'password', 'camille.leroy@gmail.com',        '0634567890', FALSE), -- id_utilisateur = 5
       ('GIRARD',    'Yanis',     'password', 'yanis.girard@gmail.com',         '0645678901', FALSE), -- id_utilisateur = 6
       ('FONTAINE',  'Élise',     'password', 'elise.fontaine@gmail.com',       '0656789012', FALSE); -- id_utilisateur = 7

-- Materiel
-- mobile = TRUE  → matériel transportable (peut être emprunté pour une demande)
-- mobile = FALSE → matériel fixe d'un studio (dans la table contenir)
INSERT INTO Materiel (nom, mobile, type)
VALUES ('Batterie TAMA Starclassic',     FALSE, 'Percussion'),     -- id_materiel = 1
       ('Moog Subharmonicon',            TRUE,  'Synthétiseur'),   -- id_materiel = 2
       ('Microphone Neumann U87',        FALSE, 'Microphone'),     -- id_materiel = 3
       ('Console SSL AWS 948',           FALSE, 'Console'),        -- id_materiel = 4
       ('Microphone Shure SM57',         TRUE,  'Microphone'),     -- id_materiel = 5
       ('Guitare Fender Stratocaster',   TRUE,  'Cordes'),         -- id_materiel = 6
       ('Ampli Marshall JCM800',         TRUE,  'Amplificateur'),  -- id_materiel = 7
       ('Piano droit Yamaha U3',         FALSE, 'Clavier'),        -- id_materiel = 8
       ('Pro Tools Ultimate',            FALSE, 'Logiciel'),       -- id_materiel = 9
       ('Casque Beyerdynamic DT 770',    TRUE,  'Casque');         -- id_materiel = 10

-- contenir : quel studio contient quel matériel fixe
INSERT INTO contenir (id_studio, id_materiel)
VALUES (1, 1), -- batterie fixe dans studio mastering
       (1, 4), -- console SSL dans studio 1 (mastering)
       (1, 9), -- Pro Tools dans studio 1
       (2, 3), -- Neumann U87 dans studio 2 (mix)
       (2, 9), -- Pro Tools dans studio 2
       (3, 8), -- Piano droit Yamaha dans studio 3 (enregistrement)
       (4, 9); -- Pro Tools dans studio 4 (enregistrement)

-- Demande (dépend de Utilisateur, Activite, Studio)
-- status : 0 = en_attente, 1 = acceptee, 2 = refusee
INSERT INTO Demande (nb_personnes, nb_techniciens, status, description, date_demande, debut, fin, id_activite, id_utilisateur, id_studio)
VALUES (1, 1, 1, NULL,                                '2026-05-03 09:00:00', '2026-05-03 09:00:00', '2026-05-03 18:00:00', 4, 1, 1), -- id_demande = 1 (acceptée, passée)
       (4, 0, 0, NULL,                                '2026-05-03 14:00:00', '2026-05-03 14:00:00', '2026-05-03 17:00:00', 1, 2, 5), -- id_demande = 2 (en attente)
       (3, 1, 1, 'Prise voix album EP',               '2026-04-12 10:30:00', '2026-04-20 14:00:00', '2026-04-20 17:00:00', 2, 6, 4), -- id_demande = 3 (acceptée, passée)
       (2, 1, 1, 'Mastering 4 titres',                '2026-04-18 09:15:00', '2026-04-25 10:00:00', '2026-04-25 16:00:00', 4, 3, 1), -- id_demande = 4 (acceptée, passée)
       (8, 0, 2, 'Trop de personnes pour ce studio',  '2026-04-10 17:45:00', '2026-04-15 18:00:00', '2026-04-15 20:00:00', 1, 4, 6), -- id_demande = 5 (refusée)
       (2, 1, 0, NULL,                                '2026-05-04 11:20:00', '2026-05-12 14:00:00', '2026-05-12 18:00:00', 3, 5, 2), -- id_demande = 6 (en attente, future)
       (3, 0, 0, 'Répétition avant concert',          '2026-05-04 19:05:00', '2026-05-08 19:00:00', '2026-05-08 21:00:00', 1, 6, 6), -- id_demande = 7 (en attente, future)
       (4, 1, 1, 'Session live band',                 '2026-04-28 15:40:00', '2026-05-15 10:00:00', '2026-05-15 14:00:00', 2, 3, 3), -- id_demande = 8 (acceptée, future)
       (5, 0, 0, NULL,                                '2026-05-05 08:30:00', '2026-05-20 18:00:00', '2026-05-20 20:30:00', 1, 1, 6), -- id_demande = 9 (en attente, future)
       (2, 1, 0, 'Mix single + radio edit',           '2026-05-05 09:10:00', '2026-05-22 14:00:00', '2026-05-22 19:00:00', 3, 7, 2); -- id_demande = 10 (en attente, future)

-- emprunter : quel matériel mobile est demandé dans quelle demande
INSERT INTO emprunter (id_materiel, id_demande)
VALUES (1, 2),  -- batterie demandée pour demande 2 (répétition)
       (5, 3),  -- micro SM57 pour demande 3 (enregistrement)
       (10, 6), -- casque pour demande 6 (mix)
       (6, 7),  -- guitare Strato pour demande 7 (répétition)
       (7, 7),  -- ampli Marshall pour demande 7
       (5, 8),  -- micro SM57 pour demande 8 (live band)
       (2, 8),  -- Moog Subharmonicon pour demande 8
       (1, 9);  -- batterie pour demande 9 (répétition)

-- Session (dépend de Demande, Activite, Studio)
-- Note: une Session n'est créée que pour une Demande acceptée (status = 1).
-- prix = durée (h) × taux_horaire studio
INSERT INTO Session (nb_personnes, debut, fin, prix, description, id_demande, id_activite, id_studio)
VALUES (1, '2026-05-03 09:00:00', '2026-05-03 18:00:00', 540, NULL, 1, 4, 1), -- id_session = 1 (mastering 9h × 60€)
       (3, '2026-04-20 14:00:00', '2026-04-20 17:00:00',  60, NULL, 3, 2, 4), -- id_session = 2 (rec   3h × 20€)
       (2, '2026-04-25 10:00:00', '2026-04-25 16:00:00', 360, NULL, 4, 4, 1), -- id_session = 3 (mast  6h × 60€)
       (4, '2026-05-15 10:00:00', '2026-05-15 14:00:00', 100, NULL, 8, 2, 3); -- id_session = 4 (rec   4h × 25€)

-- affecter : quel employé est affecté à quelle session
INSERT INTO affecter (id_employe, id_session)
VALUES (2, 1), -- CROCHE Sarah (ingénieur mastering) → session 1
       (1, 2), -- DUPONT Henri (ingénieur son)       → session 2
       (3, 2), -- MAGNE Charles (technicien son)     → session 2
       (2, 3), -- CROCHE Sarah (ingénieur mastering) → session 3
       (4, 3), -- POLEGUE Patrick (technicien son)   → session 3
       (1, 4), -- DUPONT Henri (ingénieur son)       → session 4
       (3, 4); -- MAGNE Charles (technicien son)     → session 4

-- reserver : quel matériel mobile est utilisé dans quelle session (issu de l'emprunter de la demande)
INSERT INTO reserver (id_materiel, id_session)
VALUES (5, 2),  -- micro SM57 → session 2 (rec)
       (5, 4),  -- micro SM57 → session 4 (live band)
       (2, 4);  -- Moog Subharmonicon → session 4
