<<<<<<< HEAD
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
- **Catalogue de Produits** : Affichage des produits avec pagination (potentielle extension)
- **Détail Produit** : Vue détaillée avec description, prix et stock
- **Panier d'Achat** : Ajout, suppression et modification des quantités
- **Validation de Commande** : Processus de checkout simple avec mise à jour du stock

### Pour les Administrateurs
- **Panel Admin** : Accès réservé (utilisateur ID 1)
- **Gestion des Produits** : Vue d'ensemble des produits (extension possible pour ajout/modification)
- **Suivi des Commandes** : Liste des dernières commandes avec statut

## Structure du Projet

```
TPE_Hassan_Mbodou_Adam/
├── admin/                 # Panel d'administration
│   ├── index.php
│   └── README.md          # Documentation du panel admin
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
├── docker-compose.yml     # Configuration Docker
├── .gitignore             # Fichiers à ignorer par Git
├── .gitattributes         # Attributs Git
├── .editorconfig          # Configuration éditeur
├── README.md              # Ce fichier
├── CONTRIBUTING.md        # Guide de contribution
├── CHANGELOG.md           # Historique des versions
└── LICENSE                # Licence du projet
```

## Installation et Configuration

### Méthode 1 : Avec XAMPP (Recommandé pour Windows)

#### Prérequis
- XAMPP installé (Apache, MySQL, PHP)
- Navigateur web moderne

#### Étapes d'Installation

1. **Démarrer XAMPP**
   - Lancez le panneau de contrôle XAMPP
   - Démarrez les modules Apache et MySQL

2. **Importer la Base de Données**
   - Ouvrez phpMyAdmin : `http://localhost/phpmyadmin/`
   - Créez une nouvelle base de données nommée `ecommerce`
   - Importez le fichier `db.sql`

3. **Placer le Projet**
   - Le dossier du projet doit être dans `C:\xampp\htdocs\TPE_Hassan_Mbodou_Adam\`

4. **Accéder au Site**
   - URL : `http://localhost/TPE_Hassan_Mbodou_Adam/`

### Méthode 2 : Avec Docker (Alternative Multiplateforme)

#### Prérequis
- Docker et Docker Compose installés

#### Installation Rapide
```bash
# Depuis le dossier du projet
docker-compose up -d
```

#### Accès
- Site web : `http://localhost:8080`
- phpMyAdmin : `http://localhost:8081` (si ajouté)
- Base de données : `localhost:3306` avec user: `user`, password: `password`

## Utilisation

### Test des Fonctionnalités
1. **Inscription** : Créez un compte utilisateur
2. **Connexion** : Connectez-vous avec vos identifiants
3. **Navigation** : Parcourez les produits
4. **Achat** : Ajoutez des articles au panier et validez la commande
5. **Administration** : Connectez-vous avec l'utilisateur ID 1 pour accéder au panel admin

## Sécurité

**Note Importante** : Ce site est une démonstration éducative et n'est pas sécurisé pour un environnement de production.

- Mots de passe hashés avec `password_hash()`
- Protection contre les injections SQL avec PDO
- Sessions PHP pour la gestion des utilisateurs
- Validation basique des entrées

Pour une version production, ajouter :
- Validation côté client et serveur
- Protection CSRF
- Chiffrement des données sensibles
- Logs d'audit

## Dépannage

### Erreurs Courantes
- **Erreur de connexion DB** : Vérifiez que MySQL est démarré et que les identifiants dans `config.php` sont corrects
- **Pages blanches** : Vérifiez les logs Apache dans XAMPP
- **Erreur 404** : Assurez-vous que le dossier est bien dans `htdocs`

### Logs
- Apache : `C:\xampp\apache\logs\error.log`
- PHP : `C:\xampp\php\logs\php_error_log`

## Améliorations Possibles

- Ajout d'images pour les produits
- Système de notation/commentaires
- Passerelle de paiement (Stripe, PayPal)
- Interface d'administration complète (CRUD)
- Responsive design pour mobile
- API REST pour les futures extensions

## Auteur

- **Nom** : Hassan Mbodou Adam
- **Classe** : [Votre classe]
- **Établissement** : [Nom de l'établissement]
- **Année** : 2023-2024

## Remerciements


