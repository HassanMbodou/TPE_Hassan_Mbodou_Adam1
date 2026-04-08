# Panel d'Administration

Ce dossier contient les fichiers relatifs au panel d'administration du site e-commerce.

## Fichiers

- `index.php` : Page principale du panel admin, affiche les produits et les dernières commandes

## Accès

Pour accéder au panel admin :
1. Connectez-vous avec un compte utilisateur
2. L'utilisateur avec l'ID 1 (premier inscrit) a automatiquement les droits admin
3. Allez sur `/admin/`

## Fonctionnalités

### Gestion des Produits
- Vue d'ensemble de tous les produits
- Affichage du nom, prix et stock
- (Extension possible : ajout/modification/suppression de produits)

### Gestion des Commandes
- Liste des 10 dernières commandes
- Affichage de l'utilisateur, total, statut et date
- (Extension possible : modification du statut, détails complets)

## Sécurité

- Accès restreint aux administrateurs uniquement
- Vérification de l'ID utilisateur dans le code

## Améliorations Futures

- Interface complète CRUD pour les produits
- Gestion des utilisateurs
- Statistiques de vente
- Export des données