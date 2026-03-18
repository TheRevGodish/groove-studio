-- ============================================================
--                          INSERT
--  Ordre à respecter pour les contraintes FK
-- ============================================================

-- STRUCTURE
INSERT INTO STRUCTURE (SIREN, nom)
VALUES ('123456789', 'Groove');

-- ACTIVITE
INSERT INTO ACTIVITE (type, employe_obligatoire)
VALUES ('Répétition', FALSE), -- id 1
       ('Enregistrement', FALSE), -- id 2
       ('Mix', FALSE), -- id 3
       ('Mastering', TRUE); -- id 4

-- SPECIALITE
INSERT INTO SPECIALITE (specialite, taux_horaire)
VALUES ('Technicien son', 25), -- id 1
       ('Ingénieur son', 40), -- id 2
       ('Ingénieur mastering', 70); -- id 3

-- STUDIO (dépend de STRUCTURE et ACTIVITE)
INSERT INTO STUDIO (capacite, amenageable, taux_horaire, SIREN, id_activite)
VALUES (00, FALSE, 60, '123456789', 4), -- mastering
       (00, FALSE, 35, '123456789', 3), -- mixing
       (00, TRUE, 25, '123456789', 2), -- enregistrement
       (00, TRUE, 20, '123456789', 2), -- enregistrement
       (00, TRUE, 12, '123456789', 1), -- répétition
       (00, TRUE, 8, '123456789', 1); -- répétition

-- EMPLOYE (dépend de STRUCTURE)
INSERT INTO EMPLOYE (NIR, nom, prenom, SIREN)
VALUES ('197053226784966', 'DUPONT', 'Henri', '123456789'),
       ('295053363784421', 'CROCHE', 'Sarah', '123456789'),
       ('190050860784471', 'MAGNE', 'Charles', '123456789'),
       ('108115660174310', 'POLEGUE', 'Patrick', '123456789');

-- AVOIR_POUR_SPECIALITE (dépend de EMPLOYE et SPECIALITE)
INSERT INTO AVOIR_POUR_SPECIALITE (NIR, id_specialite)
VALUES ('197053226784966', 2),
       ('295053363784421', 3),
       ('190050860784471', 1),
       ('108115660174310', 1);

-- CLIENT
INSERT INTO CLIENT (nom, prenom, email, telephone)
VALUES ('SAJUS', 'Thomas', 'thomas.sajus@hotmail.fr', '0640973094'),
       ('SCHNEIDER', 'Rodolphe', 'rodolphe.schneider@gmail.com', '0789947201');

-- MATERIEL (dépend de STUDIO, nullable si mobile)
INSERT INTO MATERIEL (nom, mobile, numero_studio)
VALUES ('Batterie TAMA Starclassic', FALSE, 1),  -- matériel fixe dans studio 1
       ('Moog Subharmonicon', TRUE, NULL);  -- matériel mobile

-- DEMANDE (dépend de CLIENT et ACTIVITE)
INSERT INTO DEMANDE (nb_personnes, date, nb_technicien, numero_client, id_activite)
VALUES (1, '2026-05-03', 1, 1, 4),
       (4, '2026-05-03', 0, 2, 1);

-- REQUERIR (dépend de DEMANDE et MATERIEL)
INSERT INTO REQUERIR (numero_demande, id_materiel)
VALUES (2, 1);

-- SESSION (dépend de STUDIO et DEMANDE)
INSERT INTO SESSION (statut, debut, fin, prix, nb_personnes, numero_studio, id_demande)
VALUES ('confirmee', '2026-05-03 09:00:00', '2026-05-03 18:00:00', 600, 1, 1, 1),
       ('en_attente', '2026-05-03 14:00:00', '2026-05-03 17:00:00', 24, 4, 6, 2);


-- AFFECTER (dépend de EMPLOYE et SESSION)
INSERT INTO AFFECTER (NIR, id_session)
VALUES ('295053363784421', 1);