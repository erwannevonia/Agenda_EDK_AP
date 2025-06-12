# 🗓️ Agenda_EDK_EDK_AP

Site web d’agenda connecté à la base de données EDK, développé en PHP avec Front‑end en Bootstrap et FullCalendar.

## 🧰 Technologies & outils

- **Langage serveur** : PHP (PDO)
- **Gestion des dépendances** : Composer (`composer.json`)
- **Front-end** :
  - Bootstrap 5
  - FullCalendar 6.1.15 (JS/CSS)
- **Structure** : fichiers `inc/`, `Metier/`, `css/`, `js/`, `vendor/`
- **Pages principales** :
  - `index.php` : page d’authentification
  - `accueil.php` : affichage de l’agenda
  - `a2f.php`, `otphp.php` : gestion d’authentification à 2 facteurs (OTP)
  - `error.php` : gestion des erreurs

## 🔌 Fonctionnalités principales

- 🔑 **Connexion** avec authentification (login/password + OTP si activé)
- 📅 **Agenda interactif** :
  - Affichage des cours/devoirs via FullCalendar
  - Chargement des événements depuis la base MySQL (via PDO)
- 🔄 **CRUD possible** des événements (à implémenter ou étendre)
- 💅 UI responsive et stylée grâce à Bootstrap et FullCalendar

## 📂 Arborescence du projet

```bash

Agenda\_EDK\_AP/
├── Metier/                    # classes métiers (ex. Event, Utilisateur…)
├── PDO/                       # connexion à la base via PDO
├── inc/                       # fichiers inclus (config, fonctions comm.)
├── css/                       # styles Bootstrap + custom
├── js/                        # FullCalendar + scripts persos
├── vendor/                    # dépendances Composer
├── a2f.php                    # vérif OTP (2FA)
├── otphp.php                  # générateur/validation OTP
├── index.php                  # page de login
├── accueil.php                # affichage agenda
├── error.php                  # page d’erreur personnalisée

```

## ⚙️ Installation & démarrage

### Prérequis

- PHP ≥ 7.4 avec PDO
- MySQL (base EDK)
- Serveur local : Apache / Nginx
- Node.js + npm si besoin de gérer `js/` ou `css/` (en cas de build ou mises à jour)

### Déploiement

1. Clone le dépôt :
```bash
git clone https://github.com/erwannevonia/Agenda_EDK_AP.git
cd Agenda_EDK_AP
```

2. Installe les dépendances PHP :

```bash
composer install
```

3. Configure la connexion MySQL dans `inc/config.php` (host, user, pwd, bdd).

4. Lance ton serveur local avec Apache/Nginx → dossier `EDK-Léger/` en root

5. Ouvre dans ton navigateur `http://localhost/EDK-Léger`

## 📜 Licence

Ce projet est réalisé dans un cadre **pédagogique**.
Usage libre à des fins d'apprentissage.

---