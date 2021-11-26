CREATE TABLE T_annonce (
    A_idannonce INT UNSIGNED NOT NULL AUTO_INCREMENT,
    A_titre VARCHAR(128) NOT NULL,
    A_cout_loyer INT UNSIGNED NOT NULL,
    A_cout_charges INT UNSIGNED NOT NULL,
    A_date_creation TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    A_date_modification DATETIME ON UPDATE CURRENT_TIMESTAMP,
    A_type_chauffage ENUM('collectif', 'individuel') NOT NULL,
    A_superficie INT UNSIGNED NOT NULL,
    A_description TEXT NOT NULL,
    A_adresse VARCHAR(128) NOT NULL,
    A_ville VARCHAR(128) NOT NULL,
    A_CP DECIMAL(5, 0) NOT NULL,
    A_etat ENUM('en cours de rédaction', 'publiée', 'archivée') NOT NULL DEFAULT 'en cours de rédaction' ,

    E_idengie INT UNSIGNED NOT NULL,
    T_type ENUM('T1', 'T2', 'T3', 'T4', 'T5', 'T6') NOT NULL,
    U_mail VARCHAR(128) UNIQUE NOT NULL,

    PRIMARY KEY (A_idannonce),
    KEY idx_annonce(A_idannonce)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE T_photo(
    P_idphoto INT UNSIGNED NOT NULL AUTO_INCREMENT,
    P_titre VARCHAR(128) NOT NULL,
    P_nom VARCHAR(128) NOT NULL,

    A_idannonce INT UNSIGNED NOT NULL,

    PRIMARY KEY (P_idphoto),
    KEY idx_photo(P_idphoto)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;


CREATE TABLE T_message(
    M_dateheure_message TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    M_texte_message TEXT NOT NULL,
    U_mail VARCHAR(128) NOT NULL,
    A_idannonce INT UNSIGNED NOT NULL,

    PRIMARY KEY(U_mail,A_idannonce)

) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE T_energie(
    E_idengie INT UNSIGNED NOT NULL AUTO_INCREMENT,
    E_description VARCHAR(128) NOT NULL,

    PRIMARY KEY(E_idengie),
    KEY idx_engie(E_idengie)

) ENGINE = InnoDB DEFAULT CHARSET = utf8;


CREATE TABLE T_typeMaison(
    T_type ENUM('T1', 'T2', 'T3', 'T4', 'T5', 'T6') NOT NULL,
    T_description VARCHAR(128) NOT NULL,

    PRIMARY KEY (T_type),
    KEY idx_type(T_type)

) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE T_utilisateur(
    U_mail VARCHAR(128) UNIQUE NOT NULL,
    U_mdp VARCHAR(128) NOT NULL,
    U_pseudo VARCHAR(128) UNIQUE NOT NULL,
    U_nom VARCHAR(128) NOT NULL,
    U_prenom VARCHAR(128) NOT NULL,
    U_admin BOOLEAN NOT NULL DEFAULT false, 

    PRIMARY KEY (U_mail),
    KEY idx_profil(U_pseudo)

) ENGINE = InnoDB DEFAULT CHARSET = utf8;







-- ajout des contraintes de clé étrangères
ALTER TABLE T_message 
    ADD CONSTRAINT FK_MESSAGE_UTILISATEUR FOREIGN KEY (U_mail) REFERENCES T_utilisateur(U_mail)
    ON UPDATE CASCADE;

ALTER TABLE T_message 
    ADD CONSTRAINT FK_MESSAGE_ANNONCE FOREIGN KEY (A_idannonce) REFERENCES T_annonce(A_idannonce)
    ON UPDATE CASCADE;

ALTER TABLE T_annonce
    ADD CONSTRAINT FK_ANNONCE_UTILISATEUR FOREIGN KEY (U_mail) REFERENCES T_utilisateur(U_mail)
    ON UPDATE CASCADE;
ALTER TABLE T_annonce
    ADD CONSTRAINT FK_ANNONCE_ENERGIE FOREIGN KEY (E_idengie) REFERENCES T_energie(E_idengie)
    ON UPDATE CASCADE;
ALTER TABLE T_annonce
    ADD CONSTRAINT FK_ANNONCE_TYPEMAISON FOREIGN KEY (T_type) REFERENCES T_typeMaison(T_type)
    ON UPDATE CASCADE;

ALTER TABLE T_photo
    ADD CONSTRAINT FK_PHOTO_ANNONCE FOREIGN KEY (A_idannonce) REFERENCES T_annonce(A_idannonce)
    ON UPDATE CASCADE; --ON DELETE CASCADE; ?

    --TODO gérer les repercussion ON DELETE
