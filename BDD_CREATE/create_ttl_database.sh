#!/bin/sh

# Générer les informations pour la base de données

db_name="ttl";
db_user="ttl";
db_password=$(openssl rand -base64 32);
db_host='localhost';
db_port=3306;

script="$(pwd)/new_ttl.sql";

# Paramétrer le nombre maximum de connexion

# Creation de la base de donnée MySQL
mysql CREATE DATABASE $db_name;

mysql CREATE USER "$db_user"@"$db_host" IDENTIFIED BY "$db_password" REQUIRE SSL;
mysql GRANT ALL PRIVILEGES ON "$db_name".* TO "$db_user"@"$db_host";
mysql FLUSH PRIVILEGES;

# Creation du schéma TTl
# Creation des tables
mysql --host="$db_host" --user="$db_user" --password="$db_password" --database="$db_name" --port="$db_port" < "$script";

# Copie de la configuration du site avec le framework codeIgniter Codeigniter

# Création du compte admin pour le site