# Projet PHP | Airsoft

> Ce projet est une plateforme de vente en ligne (e-commerce) développée en PHP natif. L'architecture repose principalement sur le **Page Controller Pattern** (Contrôleur de Page), où chaque page ou action spécifique prend en charge sa propre requête, traite la logique requise et affiche la vue correspondante.
> Le site permet aux utilisateurs de s'inscrire, de vendre des articles, d'acheter des produits via un système de panier, d'effectuer des paiements et de gérer leur compte.

---

## Architecture du projet (Page Controller Pattern)

Le projet est structuré de manière à séparer les responsabilités tout en gardant un point d'entrée dédié pour chaque grande fonctionnalité (ex: `pages/articles.php`, `pages/account.php`) :

- **`assets/`** : Contient les ressources statiques telles que les feuilles de style CSS, les scripts JavaScript et les images.
- **`config/`** : Fichiers de configuration, notamment pour la connexion à la base de données via PDO.
- **`controller/`** : Contient les scripts PHP gérant la logique d'action spécifique (traitement de formulaires, interactions avec la base de données). Ces fichiers sont souvent inclus par les pages pour séparer le traitement des données de l'affichage.
- **`includes/`** : Éléments HTML/PHP réutilisables de l'interface, comme l'en-tête (header) et le pied de page (footer).
- **`pages/`** : Agissent comme les contrôleurs de page principaux. Chaque fichier reçoit la requête HTTP, inclut la logique nécessaire (depuis le dossier controller ou en direct) et s'occupe de l'affichage (la vue).
- **`uploads/`** : Dossier de destination pour les fichiers et images uploadés par les utilisateurs (lors de la mise en vente d'un article).
- **`.env`** : Fichier contenant les variables d'environnement (identifiants de base de données).

---

## Fonctionnalités principales

- **Authentification et Gestion de compte** : Inscription, connexion et gestion du profil utilisateur (solde, informations).
- **Achat et Vente** : Possibilité de lister des articles à vendre, avec ajout d'images, gestion des prix, et système de panier d'achat.
- **Paiement** : Système de paiement simulé basique pour finaliser les commandes fictives.
- **Filtres et Recherche** : Système de filtrage pour rechercher des produits facilement selon différents critères.
- **Panneau d'administration** : Interface dédiée aux administrateurs pour gérer la plateforme.

---

## Prérequis et Installation (WampServer)

Ce projet est conçu pour fonctionner dans un environnement serveur local de type WampServer sous Windows.

### 1. Cloner ou télécharger le projet

Placez le dossier du projet dans le répertoire racine de votre serveur WampServer, généralement localisé ici :

```text
C:\wamp64\www\akm_projet_php
```

### 2. Configuration de la base de données

1. Lancez WampServer et assurez-vous que tous les services sont démarrés (l'icône doit être verte).
2. Accédez à phpMyAdmin (généralement via `http://localhost/phpmyadmin`).
3. Créez une nouvelle base de données (par exemple : `php_exam_db`).
4. Importez le fichier `php_exam_db.sql` fourni à la racine du projet pour construire la structure des tables et intégrer des données de test initiales.

### 3. Fichier d'environnement (.env)

Vérifiez ou créez le fichier `.env` à la racine de votre projet avec vos propres informations de configuration :

```env
DB_HOST=127.0.0.1
DB_PORT=3307
DB_NAME=php_exam_db
DB_USER=votre_utilisateur
DB_PASS=votre_mot_de_passe
```

_(Remarque : Remplacez les valeurs par celles correspondantes à votre environnement local)._

### 4. Lancement du site

Ouvrez votre navigateur et accédez à l'adresse suivante :

```text
http://localhost/akm_projet_php/
```

---

## Technologies utilisées

| Catégorie               | Technologie                                     |
| ----------------------- | ----------------------------------------------- |
| **Langage**             | PHP 8+                                          |
| **Base de données**     | MySQL (MariaDB)                                 |
| **Frontend**            | HTML5, Vanilla CSS, JavaScript (sans framework) |
| **Architecture**        | Page Controller Pattern                         |
| **Environnement local** | WampServer (Windows)                            |

---

## Notes pour le développement

> **Mise en forme :** Le design du site a été réalisé sans utiliser de bibliothèque CSS tierce, en se concentrant sur du Vanilla CSS réparti dans plusieurs fichiers spécifiques au sein du dossier `assets`.

> **Architecture :** Plutôt qu'un Front Controller (MVC strict) unique routant toutes les requêtes, ce projet utilise des point d'entrées multiples (`pages/`) qui traitent chacun leur domaine fonctionnel, facilitant la lisibilité des actions par page.
