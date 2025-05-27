#!/bin/bash

# ===========================
# 🛠 INSTALLATION SCRIPT
# Projet Banque d’Images
# Remarques : - Donnez les droits d’exécution "chmod +x install.sh"
#             - Exécutez en tant que root "sudo ./install.sh"
# ===========================

set -e  # Stoppe si une commande échoue

# ANSI background + foreground combos
RED_BG_WHITE='\033[41;97m'
GREEN_BG_BLACK='\033[42;30m'
YELLOW_BG_BLACK='\033[43;30m'
BLUE_BG_WHITE='\033[44;97m'
NC='\033[0m'  # Reset

echo -e "${BLUE_BG_WHITE} Setup du projet Banque d’Images... ${NC}"
sleep 1

# Vérifie si l'utilisateur est root
if [ "$EUID" -ne 0 ]; then
  echo -e "${RED_BG_WHITE} ❌ Ce script doit être exécuté en tant que root (utilisez sudo) ${NC}"
  exit 1
fi

# Liste des paquets nécessaires
PAQUETS=(php php-mysql mysql-server apache2)
A_INSTALLER=()

echo -e "${YELLOW_BG_BLACK} Vérification des paquets requis... ${NC}"
sleep 1
for pkg in "${PAQUETS[@]}"; do
  if dpkg -l | grep -qw "$pkg"; then
    echo -e "${GREEN_BG_BLACK}  $pkg déjà installé. ${NC}"
  else
    echo -e "${YELLOW_BG_BLACK}  $pkg non trouvé, il sera installé. ${NC}"
    A_INSTALLER+=("$pkg")
  fi
done

if [ ${#A_INSTALLER[@]} -gt 0 ]; then
  echo -e "${YELLOW_BG_BLACK} Mise à jour des paquets... ${NC}"
  apt update
  echo -e "${YELLOW_BG_BLACK} Installation des paquets manquants : ${A_INSTALLER[*]} ${NC}"
  apt install -y "${A_INSTALLER[@]}"
  echo -e "${GREEN_BG_BLACK} ✅ Paquets manquants installés avec succès. ${NC}"
else
  echo -e "${GREEN_BG_BLACK} Tous les paquets nécessaires sont déjà installés. ${NC}"
fi

sleep 1

echo -e "${YELLOW_BG_BLACK} Démarrage de MySQL... ${NC}"
systemctl enable mysql
systemctl start mysql
sleep 1

echo -e "${YELLOW_BG_BLACK}  Création de la base de données et de l'utilisateur... ${NC}"
sleep 1

mysql -u root <<EOF
DROP DATABASE IF EXISTS l2info;
CREATE DATABASE l2info CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
DROP USER IF EXISTS 'l2info'@'localhost';
CREATE USER 'l2info'@'localhost' IDENTIFIED BY 'l2info';
GRANT ALL PRIVILEGES ON l2info.* TO 'l2info'@'localhost';
FLUSH PRIVILEGES;
EOF

sleep 1

# Import du script SQL
if [ -f "init.sql" ]; then
  echo -e "${YELLOW_BG_BLACK}  Import de init.sql... ${NC}"
  sleep 1
  mysql -u l2info -pl2info l2info < init.sql
  echo -e "${GREEN_BG_BLACK} ✅ Base de données initialisée avec succès. ${NC}"
else
  echo -e "${RED_BG_WHITE} ❌ Fichier init.sql introuvable dans le répertoire actuel. ${NC}"
  exit 1
fi

sleep 1
echo -e "${GREEN_BG_BLACK}  Installation terminée avec succès ! ${NC}"
echo -e "${BLUE_BG_WHITE}  Accédez à l'application : http://localhost/Banque-D-Images/public ${NC}"
