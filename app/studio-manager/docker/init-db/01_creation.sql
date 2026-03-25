-- ============================================================
--  BASE DE DONNÉES - GESTION DE STUDIO DE MUSIQUE
-- ============================================================

CREATE TABLE STRUCTURE (
                           SIREN       CHAR(9)         PRIMARY KEY,
                           nom         VARCHAR(100)    NOT NULL
);

CREATE TABLE ACTIVITE (
                          id_activite         INT             PRIMARY KEY AUTO_INCREMENT,
                          type                VARCHAR(50)     NOT NULL,
                          employe_obligatoire BOOLEAN         NOT NULL DEFAULT FALSE
);

CREATE TABLE SPECIALITE (
                            id_specialite   INT             PRIMARY KEY AUTO_INCREMENT,
                            specialite      VARCHAR(50)     NOT NULL,
                            taux_horaire    DECIMAL(3,0)    NOT NULL
);

CREATE TABLE STUDIO (
                        numero_studio   INT             PRIMARY KEY AUTO_INCREMENT,
                        capacite        INT             NOT NULL,
                        amenageable     BOOLEAN         NOT NULL DEFAULT FALSE,
                        taux_horaire    DECIMAL(3,0)    NOT NULL,
                        SIREN           CHAR(9)         NOT NULL,
                        id_activite     INT             NOT NULL,
                        FOREIGN KEY (SIREN)         REFERENCES STRUCTURE(SIREN),
                        FOREIGN KEY (id_activite)   REFERENCES ACTIVITE(id_activite)
);

CREATE TABLE EMPLOYE (
                         NIR     CHAR(15)        PRIMARY KEY,
                         nom     VARCHAR(50)     NOT NULL,
                         prenom  VARCHAR(50)     NOT NULL,
                         SIREN   CHAR(9)         NOT NULL,
                         FOREIGN KEY (SIREN) REFERENCES STRUCTURE(SIREN)
);

CREATE TABLE CLIENT (
                        numero_client   INT             PRIMARY KEY AUTO_INCREMENT,
                        nom             VARCHAR(50)     NOT NULL,
                        prenom          VARCHAR(50)     NOT NULL,
                        email           VARCHAR(100)    NOT NULL UNIQUE,
                        telephone       VARCHAR(15)
);

CREATE TABLE MATERIEL (
                          id_materiel     INT             PRIMARY KEY AUTO_INCREMENT,
                          nom             VARCHAR(100)    NOT NULL,
                          mobile          BOOLEAN         NOT NULL DEFAULT FALSE,
                          numero_studio   INT,
                          FOREIGN KEY (numero_studio) REFERENCES STUDIO(numero_studio)
);

CREATE TABLE DEMANDE (
                         numero_demande  INT             PRIMARY KEY AUTO_INCREMENT,
                         nb_personnes    INT             NOT NULL,
                         date            DATE            NOT NULL,
                         nb_technicien   INT             NOT NULL DEFAULT 0,
                         numero_client   INT             NOT NULL,
                         id_activite     INT             NOT NULL,
                         FOREIGN KEY (numero_client) REFERENCES CLIENT(numero_client),
                         FOREIGN KEY (id_activite)   REFERENCES ACTIVITE(id_activite)
);

CREATE TABLE SESSION (
                         id_session      INT             PRIMARY KEY AUTO_INCREMENT,
                         statut          ENUM('en_attente', 'confirmee', 'annulee', 'terminee') NOT NULL DEFAULT 'en_attente',
                         debut           DATETIME        NOT NULL,
                         fin             DATETIME        NOT NULL,
                         prix            DECIMAL(8,0),
                         nb_personnes    INT             NOT NULL,
                         numero_studio   INT             NOT NULL,
                         id_demande      INT             NOT NULL,
                         FOREIGN KEY (numero_studio) REFERENCES STUDIO(numero_studio),
                         FOREIGN KEY (id_demande)    REFERENCES DEMANDE(numero_demande)
);

-- Tables de jonction

CREATE TABLE AVOIR_POUR_SPECIALITE (
                                       NIR             CHAR(15)    NOT NULL,
                                       id_specialite   INT         NOT NULL,
                                       PRIMARY KEY (NIR, id_specialite),
                                       FOREIGN KEY (NIR)           REFERENCES EMPLOYE(NIR),
                                       FOREIGN KEY (id_specialite) REFERENCES SPECIALITE(id_specialite)
);

CREATE TABLE AFFECTER (
                          NIR         CHAR(15)    NOT NULL,
                          id_session  INT         NOT NULL,
                          PRIMARY KEY (NIR, id_session),
                          FOREIGN KEY (NIR)       REFERENCES EMPLOYE(NIR),
                          FOREIGN KEY (id_session) REFERENCES SESSION(id_session)
);

CREATE TABLE REQUERIR (
                          numero_demande  INT     NOT NULL,
                          id_materiel     INT     NOT NULL,
                          PRIMARY KEY (numero_demande, id_materiel),
                          FOREIGN KEY (numero_demande)    REFERENCES DEMANDE(numero_demande),
                          FOREIGN KEY (id_materiel)       REFERENCES MATERIEL(id_materiel)
);