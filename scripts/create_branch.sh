#!/bin/bash

# Demande les informations nécessaires
read -p "Type de tâche (feature, bugfix, etc.) : " type
read -p "Module (backend, frontend, etc.) : " module
read -p "Numéro d'identifiant : " id
read -p "Description : " description

# Vérifie que tous les champs requis sont remplis
if [[ -z "$type" || -z "$module" || -z "$id" || -z "$description" ]]; then
    echo "Erreur : Tous les champs doivent être remplis."
    exit 1
fi

# Formatage de la description (remplace les espaces par des tirets, convertit en minuscule)
formatted_description=$(echo "$description" | tr '[:upper:]' '[:lower:]' | tr ' ' '-')
branch_name="${type}/${module}-${id}-${formatted_description}"

# Crée la branche
git checkout -b "$branch_name"
echo "Nouvelle branche créée : $branch_name"
