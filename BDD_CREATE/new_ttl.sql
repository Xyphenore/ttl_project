CREATE SCHEMA TTL;

-- Creation des tables
CREATE TABLE T_typeMaison (
    T_type CHAR(2) PRIMARY KEY,
    CONSTRAINT c_type CHECK (T_type IN ('T1', 'T2', 'T3', 'T4', 'T5', 'T6')),

    T_description TEXT
);

CREATE TABLE T_energie (
    E_id_energie SERIAL PRIMARY KEY,
    E_description TEXT
);

CREATE TABLE T_utilisateur (
    U_mail   varchar(255) PRIMARY KEY,

    U_mdp    varchar(255)        NOT NULL,
    U_pseudo varchar(255) UNIQUE NOT NULL,

    U_nom    varchar(255)        NOT NULL,
    U_prenom varchar(255)        NOT NULL,

    U_admin  BOOLEAN        NOT NULL DEFAULT FALSE
);

CREATE TABLE T_annonce (
    A_idannonce SERIAL PRIMARY KEY,
    A_titre varchar(255) NOT NULL,

    F_u_mail VARCHAR(255) NOT NULL,
    CONSTRAINT fk_u_mail FOREIGN KEY (F_u_mail) REFERENCES T_utilisateur(U_mail),

    A_cout_loyer DECIMAL(10,2) NOT NULL,
    A_type_chauffage ENUM('COLLECTIF', 'INDIVIDUEL') NOT NULL,

    F_id_energie BIGINT UNSIGNED,
    CONSTRAINT fk_energie FOREIGN KEY (F_id_energie) REFERENCES T_energie(E_id_energie),
    CONSTRAINT c_id_energie CHECK
        ( (A_type_chauffage = 'INDIVIDUEL' AND F_id_energie IS NOT NULL) OR
          (A_type_chauffage = 'COLLECTIF' AND F_id_energie IS NULL) ),

    T_type_maison CHAR(2) NOT NULL,
    CONSTRAINT fk_maison FOREIGN KEY (T_type_maison) REFERENCES T_typeMaison(T_type),
    CONSTRAINT c_type_maison CHECK ( T_type_maison IN ('T1', 'T2', 'T3', 'T4', 'T5', 'T6') ),

    A_superficie BIGINT NOT NULL,

    A_description TEXT NOT NULL,

    A_adresse varchar(255) NOT NULL,
    A_ville varchar(255) NOT NULL,
    A_CP CHAR(5) CHECK ( A_CP REGEXP '[[:digit:]]{5}' ) NOT NULL,

    A_etat ENUM('EN COURS DE REDACTION', 'PUBLIER', 'ARCHIVEE') NOT NULL
);

CREATE TABLE T_message (
    M_dateheure_message DATETIME NOT NULL,
    M_texte_message TEXT NOT NULL,

    F_u_mail VARCHAR(255) NOT NULL,
    CONSTRAINT fk_u_mail FOREIGN KEY (F_u_mail) REFERENCES T_utilisateur(U_mail),

    T_idannonce BIGINT UNSIGNED NOT NULL,
    CONSTRAINT fk_t_idannonce FOREIGN KEY (T_idannonce) REFERENCES T_annonce(A_idannonce)
);

CREATE TABLE T_photo (
    P_idphoto SERIAL PRIMARY KEY,
    P_titre VARCHAR(255) NOT NULL,
    P_nom VARCHAR(255) NOT NULL,

    A_idannonce BIGINT UNSIGNED NOT NULL,
    CONSTRAINT fk_idannonce FOREIGN KEY (A_idannonce) REFERENCES T_annonce(A_idannonce)
);