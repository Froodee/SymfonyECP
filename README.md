# ECP – Emballé c'est pesé

Boutique e-commerce Symfony 7.4 de produits bio-nettoyage écologiques.

---

## Prérequis

- PHP 8.3+ (Thread Safe, x64, VS2022) — installé via [Scoop](https://scoop.sh) : `scoop install php`
- [Composer](https://getcomposer.org)
- [Symfony CLI](https://symfony.com/download)
- Extensions PHP **sqlsrv** et **pdo_sqlsrv** (voir ci-dessous)

### Installer les extensions SQL Server pour PHP

1. Télécharger le package Windows depuis https://github.com/microsoft/msphpsql/releases
2. Extraire `php_sqlsrv_85_ts_x64.dll` et `php_pdo_sqlsrv_85_ts_x64.dll`
3. Les copier dans le dossier `ext/` de PHP (ex: `C:\Users\<user>\scoop\apps\php\current\ext\`)
4. Renommer en `php_sqlsrv.dll` et `php_pdo_sqlsrv.dll`
5. Ajouter dans `php.ini` :
   ```ini
   extension=sqlsrv
   extension=pdo_sqlsrv
   ```
6. Vérifier : `php -m | grep sql`

---

## Installation

```bash
# 1. Cloner le projet
git clone <url-du-repo>
cd SymfonyECP

# 2. Installer les dépendances
composer install

# 3. Configurer l'environnement
cp .env.local.dist .env.local
# Éditer .env.local avec les vraies valeurs (BDD, mailer)

# 4. Vider le cache
php bin/console cache:clear

# 5. Lancer le serveur
symfony serve
```

Le site est accessible sur https://127.0.0.1:8000

---

## Configuration

Toutes les valeurs sensibles se mettent dans `.env.local` (jamais committé) :

| Variable | Description |
|----------|-------------|
| `APP_SECRET` | Clé secrète Symfony (chaîne aléatoire) |
| `DATABASE_URL` | Connexion SQL Server |
| `MAILER_DSN` | Compte Gmail pour l'envoi des emails |

Les valeurs de connexion pour l'environnement ECP sont disponibles auprès du responsable du projet.

---

## Structure principale

```
src/
  Controller/   — Contrôleurs (Boutique, Panier, Contact, Profil…)
  Entity/       — Entités Doctrine (Produits, Avis, User, Commande…)
migrations/     — Migrations de la base de données
templates/      — Templates Twig
assets/         — CSS, JS, images
```

## Comptes de test

Créer un compte via `/register` (vérification email requise).
