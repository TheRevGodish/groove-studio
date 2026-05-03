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
INSERT INTO Studio (numero_studio, capacite, amenageable, taux_horaire, siren, id_activite, id_structure)
VALUES (1, 0, FALSE, 60, '123456789', 4, 1), -- mastering    → id_studio = 1
       (2, 0, FALSE, 35, '123456789', 3, 1), -- mix          → id_studio = 2
       (3, 0, TRUE,  25, '123456789', 2, 1), -- enregistrement → id_studio = 3
       (4, 0, TRUE,  20, '123456789', 2, 1), -- enregistrement → id_studio = 4
       (5, 0, TRUE,  12, '123456789', 1, 1), -- répétition   → id_studio = 5
       (6, 0, TRUE,   8, '123456789', 1, 1); -- répétition   → id_studio = 6

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
       ('SCHNEIDER', 'Rodolphe',  'password', 'rodolphe.schneider@gmail.com',   '0789947201', TRUE);  -- id_utilisateur = 2

-- Materiel
INSERT INTO Materiel (nom, mobile, type)
VALUES ('Batterie TAMA Starclassic', FALSE, 'Percussion'),  -- id_materiel = 1
       ('Moog Subharmonicon',        TRUE,  'Synthétiseur'); -- id_materiel = 2

-- contenir : quel studio contient quel matériel fixe
INSERT INTO contenir (id_studio, id_materiel)
VALUES (1, 1); -- batterie fixe dans studio mastering

-- Demande (dépend de Utilisateur, Activite, Studio)
-- status : 0 = en_attente, 1 = acceptee, 2 = refusee
INSERT INTO Demande (nb_personnes, nb_techniciens, status, date_demande, id_activite, id_utilisateur, id_studio)
VALUES (1, 1, 1, '2026-05-03 09:00:00', 4, 1, 1), -- id_demande = 1 (acceptée)
       (4, 0, 0, '2026-05-03 14:00:00', 1, 2, 5); -- id_demande = 2 (en attente)

-- emprunter : quel matériel est demandé dans quelle demande
INSERT INTO emprunter (id_materiel, id_demande)
VALUES (1, 2); -- batterie demandée pour demande 2

-- Session (dépend de Demande, Activite, Studio)
INSERT INTO Session (nb_personnes, debut, fin, prix, status, id_demande, id_activite, id_studio)
VALUES (1, '2026-05-03 09:00:00', '2026-05-03 18:00:00', 600, 'confirmee',  1, 4, 1),
       (4, '2026-05-03 14:00:00', '2026-05-03 17:00:00',  24, 'en_attente', 2, 1, 5);

-- affecter : quel employé est affecté à quelle session
INSERT INTO affecter (id_employe, id_session)
VALUES (2, 1); -- CROCHE Sarah affectée à session 1
