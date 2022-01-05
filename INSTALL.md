Guide d'installation pour l'application TTL

Installation de la base de données :
Via ligne de commande (si vous avez les droits suffisants sur la machine contenant la base de donnée) :
 - Créer un nouvel utilisateur ttl :
   - Connexion à la base de donnée en tant que root : mysql -u root
   - Création de l'utilisateur ttl : GRANT ALL PRIVILEGES ON \*.* TO 'ttl'@'address' IDENTIFIED BY 'password';
     Où password est le mot de passe pour le nouvel utilisateur
     Où address est l'adresse utilisée pour se connecter à la machine hôte
   - Déconnexion du compte root : \q
 - Connexion à la base en tant que ttl :
   - mysql -u ttl -p password -h address
     Où 'password' est le mot de passe du compte ttl
 - Création de la base de donnée : CREATE DATABASE ttl_db;
 - Executer le script de création des tables : mysql ttl_db < chemin_vers_ttl.sql
   - Le script se nomme 'ttl.sql', il se trouve dans le dossier BDD_CREATE, qui se trouve dans ttl_project

Via une interface graphique :
 - Il vous faut que la base de données est une interface graphique
 - Référez-vous au guide de l'interface graphique, pour pouvoir créer la base de donnée ttl_db, créer l'utilisateur ttl, et exécuter le script ttl.sql
 - Après cela, la base de données sera fonctionnelle pour l'application

Installation du site web :
 - Copier le dossier TTL à l'endroit voulu sur le serveur web
 - Effectuer une redirection vers index.php du dossier TTL/public
 - Configurer le fichier .env pour que le site web communique avec la base de données :
   - Adresse de la base de données
   - Le nom d'utilisateur
   - Le mot de passe
   - Le port
   - Le nom de la base de donnée
   - Le charset s'il est différent d'utf8
 - Configurer le fichier .env pour que l'application sache l'adresse racine du site, il faudra modifier la variable app.baseUrl

Créer un compte en cliquant sur le bouton 'Se connecter' puis 'S'inscrire'.
Le premier compte créé est le compte admin.

Après ça, tous est bon. Le site est fonctionnel, bravo, vous avez configuré l'application manuellement.
