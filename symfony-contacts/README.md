# Découverte de Symfony avec un site internet de contact
## Auteur
Axel COUDROT
## INSTALLATION / CONFIGURATION
### INSTALLATION
Pour installer le projet, vous allez devoir : 
- Avoir installé symfony et composer sur votre machine,
- Cloner le projet : 
```
git clone https://iut-info.univ-reims.fr/gitlab/coud0011/symfony-contacts.git
```
- Configurer la base de donnée : http://cutrona/but/s3/symfony-contacts/#configuration-de-l-acces-base-de-donnees-de-l-application
### CONFIGURATION
Une fois le projet installé, vous avez des scripts mis à votre disposition :
Pour lancer le projet :
```shell
composer start
```
Pour analyser l'ensemble des codes php et savoir s'il y a des problèmes qui ne respectent pas les normes de cs fixer
```shell
composer test:cs
```
Pour corriger les problèmes de code détectés par cs fixer
```shell
composer fix:cs
```
Pour lancer les tests fonctionnels de codeception
```shell
composer test:codeception
```
Pour lancer l'ensemble des tests
```shell
composer test
```
Pour configurer la base de donnée, vous devez copier .env en .env.local et y changer les informations de la variable 
DATABASE_URL pour y assigner les informations pour accéder votre base de donnée (quelle qu'elle soit).
Pour réinitialiser la base de donnée et y rentrer des données factices : 
```shell
composer db
```

Vous avez accès à deux utilisateurs pour tester l'application :
- Tony Stark : Administrateur, root@example.com, mdp=test
- Peter Parker : Utilisateur, user@example.com, mdp=test