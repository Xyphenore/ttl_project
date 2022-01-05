Guide d'installation pour l'application TTL

Installation de la base de données :
Via une interface graphique :
 - Il vous faut que la base de données est une interface graphique
 - Référez-vous au guide de l'interface graphique, pour pouvoir créer la base de donnée ttl_db, créer l'utilisateur ttl, et exécuter le script ttl.sql
 - Si une base de données existe déjà, et que vous voulez l'utiliser, il suffira d'exécuter le script ttl.sql, pour créer les tables nécessaires
 - Après cela, la base de données sera fonctionnelle pour l'application

Installation du site web :
 - Copier le dossier TTL à l'endroit voulu sur le serveur web
 - Effectuer une redirection vers index.php du dossier TTL/public
 - Renommer le fichier 'env' en '.env'
 - Configurer le fichier .env pour que le site web communique avec la base de données : À partir de la ligne 48
   - Adresse de la base de données
   - Le nom d'utilisateur
   - Le mot de passe
   - Le port
   - Le nom de la base de donnée
   - Le charset s'il est différent d'utf8
 - Configurer le fichier .env pour que l'application sache l'adresse racine du site, il faudra modifier la variable app.baseUrl, à la ligne 24

Créer un seul compte en cliquant sur le bouton 'Se connecter' puis 'S'inscrire'.

Pour obtenir les droits administrateur.
Exécuter le script admin.sql sur la base de données créée, il passera toutes les personnes enregistrées dans la base de données en tant qu'admin.
Il vous faudra vous déconnecter et vous reconnecter, pour obtenir les droits admin sur le site.

Après ça, tous est bon. Le site est fonctionnel, bravo, vous avez configuré l'application manuellement.
