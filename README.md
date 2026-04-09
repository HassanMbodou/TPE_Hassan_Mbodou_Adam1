# Site E-commerce Dynamique - TPE Hassan Mbodou Adam

---

**Auteur** : Hassan Mbodou Adam
**Matricule** : 23A624FS
**Projet** : TPE (Travail Personnel Encadré)
**Année** : 2025-2026

---

## Description du Projet

Ce projet est un site e-commerce complet réalisé en PHP avec MySQL dans le cadre d'un Travail Personnel Encadré (TPE). Il permet aux utilisateurs de naviguer dans un catalogue de produits, de s'inscrire, de se connecter, d'ajouter des articles à leur panier et de passer des commandes. Un panel d'administration est également disponible pour gérer les produits et les commandes.

## Technologies Utilisées

- **Langage Backend** : PHP 8.2
- **Base de Données** : MySQL
- **Serveur Web** : Apache (via XAMPP)
- **Frontend** : HTML5, CSS3, JavaScript
- **Architecture** : MVC simplifié avec sessions PHP

## Fonctionnalités Principales

### Pour les Utilisateurs
- **Inscription et Connexion** : Création de compte avec hashage des mots de passe
- **Catalogue de Produits** : Affichage des produits avec images
- **Détail Produit** : Vue détaillée avec description, prix, stock et avis
- **Panier d'Achat** : Ajout, suppression et modification des quantités
- **Validation de Commande** : Processus de checkout simple avec paiement simulé

### Pour les Administrateurs
- **Panel Admin** : Accès réservé (utilisateur ID 1)
- **Gestion des Produits** : Ajout, modification, suppression (CRUD)
- **Suivi des Commandes** : Liste des dernières commandes avec statut

## Nouvelles fonctionnalités ajoutées

- Ajout d'images produits dans le catalogue et la page détail
- Système de notation et commentaires clients
- Paiement simulé via Stripe ou PayPal
- Interface d'administration complète pour les produits
- Design responsive pour mobile
- API REST de base pour produits et avis

## Structure du Projet

```
TPE_Hassan_Mbodou_Adam/
├── admin/                 # Panel d'administration
│   ├── index.php
│   ├── product_form.php   # Ajout / modification de produit
│   └── product_delete.php # Suppression de produit
├── css/                   # Feuilles de style
│   ├── style.css
│   └── README.md          # Documentation des styles
├── js/                    # Scripts JavaScript
│   ├── script.js
│   └── README.md          # Documentation des scripts
├── .github/               # Configuration GitHub
│   └── workflows/
│       └── ci.yml
├── config.php             # Configuration de la base de données
├── db.sql                 # Script de création de la base de données
├── index.php              # Page d'accueil
├── product.php            # Page de détail produit
├── cart.php               # Gestion du panier
├── checkout.php           # Validation de commande
├── login.php              # Connexion
├── register.php           # Inscription
├── logout.php             # Déconnexion
├── add_to_cart.php        # Ajout au panier
├── remove_from_cart.php   # Suppression du panier
├── api.php                # API REST produits / avis
├── docker-compose.yml     # Configuration Docker
├── .gitignore             # Fichiers à ignorer par Git
├── .gitattributes         # Attributs Git
├── .editorconfig          # Configuration éditeur
├── README.md              # Ce fichier
├── CONTRIBUTING.md        # Guide de contribution
├── CHANGELOG.md          # Historique des versions
└── LICENSE                # Licence du projet
```

