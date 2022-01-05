CREATE TABLE T_annonce (
    A_idannonce INT UNSIGNED NOT NULL AUTO_INCREMENT,
    A_titre VARCHAR(128) NOT NULL,
    A_cout_loyer INT UNSIGNED NOT NULL,
    A_cout_charges INT UNSIGNED NOT NULL,
    A_date_creation TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    A_date_modification TIMESTAMP ON UPDATE CURRENT_TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    A_type_chauffage ENUM('Collectif', 'Individuel') NOT NULL,
    A_superficie INT UNSIGNED NOT NULL,
    A_description MEDIUMTEXT NOT NULL,
    A_adresse VARCHAR(128) NOT NULL,
    A_ville VARCHAR(128) NOT NULL,
    A_CP DECIMAL(5, 0) NOT NULL,
    A_etat ENUM('Brouillon', 'Public', 'Archive', 'Bloc') NOT NULL DEFAULT 'Brouillon' ,

    E_idenergie ENUM('Electrique', 'Solaire', 'Fuel', 'Gaz', 'Bois', 'Autre') DEFAULT 'Autre',
    T_type ENUM('T1', 'T2', 'T3', 'T4', 'T5', 'T6') NOT NULL,
    U_mail VARCHAR(128) NOT NULL,

    PRIMARY KEY (A_idannonce),
    KEY idx_annonce(A_idannonce)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE T_photo(
    P_idphoto INT UNSIGNED NOT NULL AUTO_INCREMENT,
    P_titre VARCHAR(128) NOT NULL,
    P_data MEDIUMBLOB,
    P_vitrine BOOLEAN NOT NULL DEFAULT false, 

    A_idannonce INT UNSIGNED NOT NULL,

    PRIMARY KEY (P_idphoto),
    KEY idx_photo(P_idphoto)
) ENGINE = InnoDB DEFAULT CHARSET = utf8;


CREATE TABLE T_message(
    M_idmessage INT UNSIGNED NOT NULL AUTO_INCREMENT,
    M_dateheure_message TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    M_texte_message MEDIUMTEXT NOT NULL,
    M_lu BOOLEAN NOT NULL DEFAULT false, 
    U_mail VARCHAR(128) NOT NULL,
    A_idannonce INT UNSIGNED NOT NULL,

    PRIMARY KEY(M_idmessage),
    KEY idx_message(M_idmessage)

) ENGINE = InnoDB DEFAULT CHARSET = utf8;

CREATE TABLE T_energie(
    E_idenergie ENUM('Electrique', 'Solaire', 'Fuel', 'Gaz', 'Bois', 'Autre') NOT NULL,
    E_description VARCHAR(255) NOT NULL,

    PRIMARY KEY(E_idenergie),
    KEY idx_energie(E_idenergie)

) ENGINE = InnoDB DEFAULT CHARSET = utf8;


CREATE TABLE T_typeMaison(
    T_type ENUM('T1', 'T2', 'T3', 'T4', 'T5', 'T6') NOT NULL,
    T_description VARCHAR(255) NOT NULL,

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
    U_bloc BOOLEAN NOT NULL DEFAULT false, 

    PRIMARY KEY (U_mail),
    KEY idx_profil(U_pseudo)

) ENGINE = InnoDB DEFAULT CHARSET = utf8;



ALTER TABLE T_message 
    ADD CONSTRAINT FK_MESSAGE_ANNONCE FOREIGN KEY (A_idannonce) REFERENCES T_annonce(A_idannonce)
    ON DELETE CASCADE;

ALTER TABLE T_message 
    ADD CONSTRAINT FK_MESSAGE_USER FOREIGN KEY (U_mail) REFERENCES T_utilisateur(U_mail)
    ON DELETE CASCADE;

ALTER TABLE T_annonce
    ADD CONSTRAINT FK_ANNONCE_UTILISATEUR FOREIGN KEY (U_mail) REFERENCES T_utilisateur(U_mail)
    ON DELETE CASCADE;

ALTER TABLE T_annonce
    ADD CONSTRAINT FK_ANNONCE_ENERGIE FOREIGN KEY (E_idenergie) REFERENCES T_energie(E_idenergie)
    ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE T_annonce
    ADD CONSTRAINT FK_ANNONCE_TYPEMAISON FOREIGN KEY (T_type) REFERENCES T_typeMaison(T_type)
    ON UPDATE CASCADE ON DELETE CASCADE;

ALTER TABLE T_photo
    ADD CONSTRAINT FK_PHOTO_ANNONCE FOREIGN KEY (A_idannonce) REFERENCES T_annonce(A_idannonce)
    ON DELETE CASCADE;



INSERT INTO `T_typeMaison` (`T_type`, `T_description`) VALUES 
    ('T1', '1 pièce principale'), 
    ('T2', '1 pièce principale et 1 chambre'), 
    ('T3', '2 chambres'), 
    ('T4', '3 chambres'), 
    ('T5', '4 chambres'), 
    ('T6', '5 chambres') ;

INSERT INTO `T_energie` (`E_idenergie`, `E_description`) VALUES 
    ('Electrique', 'Tout type de chauffage electrique'), 
    ('Solaire', 'Panneaux photovoltaïques'), 
    ('Fuel', 'Chaudière au Fuel'), 
    ('Gaz', 'Chauffage au gaz'), 
    ('Bois', 'Cheminée, Poêle à bois'), 
    ('Autre', 'Autre source d energie');

delimiter $$
CREATE TRIGGER trigger_insert_mdp BEFORE INSERT ON T_utilisateur FOR EACH ROW
        IF UPPER(NEW.U_mdp) = 'FALSE' THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Cannot insert into T_mdp : hash_password (PHP) failed';
        END IF $$
delimiter ;

delimiter $$
CREATE TRIGGER trigger_update_mdp BEFORE UPDATE ON T_utilisateur FOR EACH ROW

        IF UPPER(NEW.U_mdp) = 'FALSE' THEN
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'Cannot update T_mdp : hash_password (PHP) failed';
        END IF $$
delimiter ;




INSERT INTO `T_annonce` (`A_idannonce`, `A_titre`, `A_cout_loyer`, `A_cout_charges`, `A_type_chauffage`, `A_superficie`, `A_description`, `A_adresse`, `A_ville`, `A_CP`, `A_etat`, `E_idenergie`, `T_type`, `U_mail`) 
VALUES 
(NULL, 'Maison Témoin', '1000', '150', 'Collectif', '110', 'Description maison témoin avec chauffage collectif', 'rue je ne sais pas', 'Tataouine les bains', '71000', default, default, 'T4', 'admin@domaine.com'), 
(NULL, 'Maison ancienne', '600', '20', 'Individuel', '80', 'Description maison avec chauffage individuel au fuel', 'impasse dans la foret', 'Farfarfaraway', '62900', 'Public', 'Fuel', 'T3', 'admin@domaine.com'),
(NULL, 'Appartement', '720', '45', 'Individuel', '95', 'Appartement à louer', 'Bois versun', 'Arles', '13200', default, 'Bois', 'T2', 'goi.suzy@gmail.com'),
(NULL, 'Studio Meublé', '300', '45', 'Collectif', '45', 'studio à louer', 'Centre ville', 'Arles', '13200', default, default, 'T1', 'chonchon@gmail.com'),
(NULL, ' Meublé', '300', '45', 'Collectif', '45', 'studio à louer', 'Centre ville', 'Arles', '13200', default, default, 'T1', 'chonchon@gmail.com')  ,
(NULL, 'Studio ', '390', '45', 'Collectif', '45', 'studio à louer', 'Centre ville', 'Arles', '13200', 'Public', default, 'T1', 'chonchon@gmail.com')  ,
(NULL, 'chambre', '300', '45', 'Collectif', '45', 'studio à louer', 'Centre ville', 'Arles', '13200', default, default, 'T1', 'goi.suzy@gmail.com')  ,
(NULL, 'chateau', '3000', '45', 'Collectif', '45', 'studio à louer', 'Centre ville', 'Arles', '13200', 'Public', default, 'T1', 'goi.suzy@gmail.com') ,
(NULL, ' Meublé', '300', '45', 'Collectif', '45', 'studio à louer', 'Centre ville', 'Arles', '13200', default, default, 'T1', 'toto@mail.com')  ,
(NULL, 'Studio ', '390', '45', 'Collectif', '45', 'studio à louer', 'Centre ville', 'Arles', '13200', 'Public', default, 'T1', 'toto@mail.com')  ,
(NULL, 'chambre', '300', '45', 'Collectif', '45', 'studio à louer', 'Centre ville', 'Arles', '13200', default, default, 'T1', 'suzy.test@test.fr')  ,
(NULL, 'chateau', '3000', '45', 'Collectif', '45', 'studio à louer', 'Centre ville', 'Arles', '13200', 'Public', default, 'T1', 'suzy.test@test.fr') ,
(NULL, 'Maison Témoin', '1000', '150', 'Collectif', '110', 'Description maison témoin avec chauffage collectif', 'rue je ne sais pas', 'Tataouine les bains', '71000', default, default, 'T4', 'admin@domaine.com'), 
(NULL, 'Maison ancienne', '600', '20', 'Individuel', '80', 'Description maison avec chauffage individuel au fuel', 'impasse dans la foret', 'Farfarfaraway', '62900', 'Public', 'Fuel', 'T3', 'admin@domaine.com'),
(NULL, 'Appartement', '720', '45', 'Individuel', '95', 'Appartement à louer', 'Bois versun', 'Arles', '13200', default, 'Bois', 'T2', 'goi.suzy@gmail.com'),
(NULL, 'Studio Meublé', '300', '45', 'Collectif', '45', 'studio à louer', 'Centre ville', 'Arles', '13200', default, default, 'T1', 'chonchon@gmail.com'),
(NULL, ' Meublé', '300', '45', 'Collectif', '45', 'studio à louer', 'Centre ville', 'Arles', '13200', default, default, 'T1', 'chonchon@gmail.com')  ,
(NULL, 'Studio ', '390', '45', 'Collectif', '45', 'studio à louer', 'Centre ville', 'Arles', '13200', 'Public', default, 'T1', 'goi.suzy@gmail.com')  ,
(NULL, 'chambre', '300', '45', 'Collectif', '45', 'studio à louer', 'Centre ville', 'Arles', '13200', default, default, 'T1', 'goi.suzy@gmail.com')  ,
(NULL, 'chateau', '3000', '45', 'Collectif', '45', 'studio à louer', 'Centre ville', 'Arles', '13200', 'Public', default, 'T1', 'goi.suzy@gmail.com') ,
(NULL, ' Meublé', '300', '45', 'Collectif', '45', 'studio à louer', 'Centre ville', 'Arles', '13200', default, default, 'T1', 'goi.suzy@gmail.com')  ,
(NULL, 'Studio ', '390', '45', 'Collectif', '45', 'studio à louer', 'Centre ville', 'Arles', '13200', 'Public', default, 'T1', 'toto@mail.com')  ,
(NULL, 'chambre', '300', '45', 'Collectif', '45', 'studio à louer', 'Centre ville', 'Arles', '13200', default, default, 'T1', 'suzy.test@test.fr')  ,
(NULL, 'chateau', '3000', '45', 'Collectif', '45', 'studio à louer', 'Centre ville', 'Arles', '13200', 'Public', default, 'T1', 'goi.suzy@gmail.com')    ; 


