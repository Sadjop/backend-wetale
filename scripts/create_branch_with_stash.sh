#!/bin/bash

# Récupère le nom de la branche actuelle
branch_name=$(git rev-parse --abbrev-ref HEAD)

# Vérifie si l'utilisateur est bien dans un dépôt Git
if ! git rev-parse --is-inside-work-tree &>/dev/null; then
  echo "❌ Vous n'êtes pas dans un dépôt Git."
  exit 1
fi

# Vérifie si la branche actuelle est 'main'
if [[ "$branch_name" == "main" ]]; then
  # Vérifie si des modifications locales ou des commits non poussés existent
  has_changes=$(git diff --quiet || echo "1")
  has_staged_changes=$(git diff --cached --quiet || echo "1")
  has_unpushed_commits=$(git log origin/main..HEAD --oneline)

  if [[ "$has_changes" == "1" || "$has_staged_changes" == "1" || -n "$has_unpushed_commits" ]]; then
    echo "⚠️  Des modifications ou des commits non poussés ont été détectés sur 'main'."

    # Demande les informations pour la nouvelle branche
    read -p "Type de tâche (feature, bugfix, etc.) : " type
    read -p "Module (backend, frontend, etc.) : " module
    read -p "Numéro d'identifiant : " id
    read -p "Description : " description

    # Vérifie que tous les champs requis sont remplis
    if [[ -z "$type" || -z "$module" || -z "$id" || -z "$description" ]]; then
      echo "❌ Tous les champs doivent être remplis."
      exit 1
    fi

    # Formatage de la description
    formatted_description=$(echo "$description" | tr '[:upper:]' '[:lower:]' | tr ' ' '-')
    new_branch_name="${type}/${module}-${id}-${formatted_description}"

    # Création d'une nouvelle branche à partir de 'main'
    echo "📦 Création de la nouvelle branche : $new_branch_name"
    git checkout -b "$new_branch_name"

    # Gestion des commits en attente
    if [[ -n "$has_unpushed_commits" ]]; then
      echo "📤 Les commits en attente sont automatiquement transférés vers '$new_branch_name'."
      # Les commits sont automatiquement portés sur la nouvelle branche.
    fi

    # Gestion des modifications locales (non suivies et indexées)
    if [[ "$has_changes" == "1" || "$has_staged_changes" == "1" ]]; then
      echo "📤 Déplacement des modifications locales vers '$new_branch_name'..."

      # Ajoute toutes les modifications locales et non suivies
      git add -A
      git commit -m "WIP: Modifications déplacées depuis 'main'"
    fi

    # Réinitialisation de 'main'
    echo "♻️ Réinitialisation de la branche 'main' à son état distant..."
    git checkout main
    git reset --hard origin/main

    echo "✅ Les modifications et commits ont été déplacés vers la branche '$new_branch_name'."
    exit 0
  else
    echo "✅ Aucun changement ou commit en attente détecté sur 'main'. Vous pouvez continuer normalement."
    exit 0
  fi
else
  echo "Vous n'êtes pas sur la branche 'main'. Aucune action nécessaire."
  exit 0
fi
