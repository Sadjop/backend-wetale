# 🛠 Gestion des Branches Git

## 🎯 Convention de nommage des branches
TESTEEE
Pour garantir une organisation claire et cohérente du projet, toutes les branches doivent respecter la convention suivante :
```
[type]/[module]-[id]-[description]
```

- **type** : Le type de la branche, parmi :
  - `feature` : Pour une nouvelle fonctionnalité.
  - `bugfix` : Pour une correction de bug.
  - `hotfix` : Pour une correction urgente.
  - `release` : Pour une version spécifique.
  - `chore` : Pour les tâches de maintenance.
  - `doc` : Pour les modifications de documentation.
- **module** : La partie du projet concernée, par exemple `backend`, `frontend`, `ui`, etc.
- **id** : Un identifiant unique pour la tâche (numéro incrémental ou basé sur une date).
- **description** : Une description concise, en minuscules, avec les espaces remplacés par des tirets.

### Exemples
- `feature/backend-001-setup-project`
- `bugfix/ui-002-fix-navbar`
- `chore/20250129-update-dependencies`

---

## 🚀 Script de création automatique des branches

Un script Bash est disponible pour simplifier la création de branches tout en respectant la convention de nommage. Ce script demande les informations nécessaires et génère automatiquement une branche au bon format.

### Utilisation
1. Exécutez le script :
   ```bash
   ./create_branch.sh
   ```
2. Renseignez les informations demandées :
    - **Type de tâche** (par exemple `feature`, `bugfix`, etc.).
    - **Module** (par exemple `backend`, `frontend`, etc.).
    - **Identifiant** (par exemple `001`, `002`, etc.).
    - **Description** (par exemple "add-login").
3. La branche sera automatiquement créée.

### Exemple
```bash
$ ./create_branch.sh
Type de tâche (feature, bugfix, etc.) : feature
Module (backend, frontend, etc.) : backend
Numéro d'identifiant : 001
Description : setup project
Nouvelle branche créée : feature/backend-001-setup-project
```

---

## 🛡 Hook `pre-push` : Validation des noms de branches

Un hook Git `pre-push` a été mis en place pour vérifier que toutes les branches respectent la convention de nommage avant d'être poussées vers le dépôt distant. Ce hook empêche les branches invalides d'être poussées.

### Fonctionnement
- Avant chaque `git push`, le hook vérifie que le nom de la branche correspond au format attendu.
- Si le nom de la branche est incorrect, le push est bloqué et un message d’erreur est affiché.

### Exemple d’erreur
Si vous essayez de pousser une branche nommée `nom-branche-invalide` :
```bash
$ git push
Erreur : Le nom de la branche 'nom-branche-invalide' ne respecte pas la convention.
Format attendu : [type]/[module]-[id]-[description]
Exemple : feature/backend-001-setup-project
```

### Installation du hook
Le hook est préconfiguré dans le dépôt. Pour l’installer ou le réinstaller manuellement :
1. Copiez le fichier `pre-push` dans le dossier des hooks Git :
   ```bash
   cp pre-push .git/hooks/
   ```
2. Rendez le fichier exécutable :
   ```bash
   chmod +x .git/hooks/pre-push
   ```

---

## 🔧 Personnalisation

- **Script de création de branches** : Modifiez `create_branch.sh` pour ajouter d'autres types de branches ou modules spécifiques à votre projet.
- **Hook `pre-push`** : Adaptez les règles de validation dans le script `pre-push` pour refléter vos besoins spécifiques.

---
