# Initiation à docker
## Auteur
```Axel COUDROT```


## Table des matière
- [Début des séances](#a-chaque-début-de-séance)
- [Informations importantes](#informations-importantes)
- [TP2](#tp2)
- [TP3](#tp3)
- [TP4](#tp4)
- [TP5](#tp5)
- [TP6](#tp6)
- [TP7](#tp7)
- [TP8](#tp8)
- [TP9](#tp9)
- [TP10](#tp10)
- [TP11](#tp11)
- [TP12](#tp12)
- [TP13](#tp13)
## A chaque début de séance :
```bash
cd /working/coud0011/
rm s4-docker
mkdir s4-doker; cd s4-docker
git clone https://iut-info.univ-reims.fr/gitlab/coud0011/s4-docker.git
docker login
```
Si nécessaire :
```bash
/home/Users/coud0011/bin/docker-clean --all
```

## Informations importantes

- Lorsque vous voudrez vous connectez au serveur bd maria db (lorsque ce sera fait notamment à partir de [docker-compose](#tp5)), vous devrez vous connecter avec :

| Système | MySQL |
| :--------------- |:---------------:| 
| Serveur | my-mariadb |
| Utilisateur | root |
| Mot de passe | root |
| Base de données | vide |


## TP2
 *Retour à la [table des matière](#table-des-matière)*
### Commandes à savoir
- Pour lancer un containeur
```bash
docker run <nom du containeur>
```
- Pour lister les images présentes sur la machine
```bash
docker images
```
- Pour lister les container présents sur la machine
```bash
docker container ps -a
```
- Pour supprimer un container/une image
```bash
docker <container/image> rm <nom du container/image>
```
- De la même manière pour lister les container/une image
```bash
docker <container/image> ls (-a pour les container actif et inactifs)
```
- Pour télécharger la derniere version d'une image docker
```bash
docker pull <nom de l'image>
```
- Pour arrêter un container il y a deux manières : exit dans le mode interactif ou alors depuis un autre terminal : 
```bash
docker stop <nom du server>
```
- Pour lancer une commande dans un container sans passer par son pseudo terminal : 
```bash
docker exec <nom du conteneur> <commande linux>
```
- Pour relancer un container arrêté :
```bash
docker start <nom du serveur>
```
- Pour reconnecter les entrées / sorties du terminal avec un container lancé:
```bash
docker attach <nom du container lancé>
```
### Autres informations
- Lors d'un docker run sur un container inexistant, docker va télécharger l'image sur le hub docker, créer un container avec celle-ci et l'exécuter.
- Pour lancer un serveur en l'empechant de s'arrêter juste après, il faut rajouter -ti pour -t qui ouvre un pseudo-terminal et -i qui permet de rediriger l'entrée standard du container



## TP3
 *Retour à la [table des matière](#table-des-matière)*
### Commandes à savoir
- Pour accéder au logs d'un container (si besoin il est possible de le faire dynamiquement avec --follow avant le nom du container)
```bash
docker logs <--follow ><nom du container>
```
- Pour avoir l'usage des ressources de CPU, mémoire et réseau
```bash
docker stats <nom du container>
```
- Pour récupérer l'ensemble des informations liées à un conteneur 
```bash
docker inspect <nom du container>
```
- Pour créer un container sans le démarrer
```bash
docker container create <nom de l'image>
```
- Pour supprimer tous les conteneur inactifs
```bash
docker container prune
```

## TP4
 *Retour à la [table des matière](#table-des-matière)*

- Utilisation de :
```bash
docker run -ti --name=my-ubuntu --volume /working/<votre_login>/s4-docker/partage:/myData ubuntu /bin/bash
```
- A la racine du container, les fichier ne persistent pas en dehors de celui-ci, ils ne sont présent que à l'intérieur. Pour accéder à des fichier dans la machine hôte il faut utiliser le dossier spécifié lors de la création, dans notre exemple : /myData
![Partage de fichiers entre le container et l'hôte](image.png)


## TP5
 *Retour à la [table des matière](#table-des-matière)*
### Commandes à savoir
- Pour créer notre propre pont réseau ici nommé db-network
```bash
docker network create db-network
```
- Pour lister l'ensemble des réseaux
```bash
docker network ls
```
- Pour inspecter le réseau créé
```bash
docker network inspect db-network
```
- Pour ajouter ce network lors de la création de container : ajouter --network db-network dans les oprions, par exemple (avec en plus une bd mariadb et un mot de passe root en variable d'environnement):
```bash
 docker run --name my-mariadb --detach --env MYSQL_ROOT_PASSWORD=root --network db-network mariadb
 ```
 - Pour créer un container *adminer* permetant d'avoir une interface web : 
 ```bash
 docker run --network db-network --detach --publish 7080:8080 adminer
 ```
 - Si l'on n'utilisait pas --network, nous aurions un erreur comme celle ci-dessous lors de la connexion à la bd dans l'interface web. En effet, le pont entre les deux (l'interface et la bd n'auraient pas été mis en place) :
 ![connexion à la bd dans l'interface web](image-1.png)

 - Par défault, lors de la création du container, le volume et le network peuvent avoir du mal à coexister à cause d'un problème de droit (sous windows, il n'y a pas ce problème)


 ## TP6
 *Retour à la [table des matière](#table-des-matière)*
 ### Nouvelle(s) Méchanique(s)
 - Nous utiliserons désormais un fichier de configuration YAML nommé docker-compose pour stocker les information nécéssaires pour lancer un ensemble de conteneurs qui seront sur un même réseau créé automatiquement. Il sera possible de lancer la création à l'aide de la [première commande](#commandes-c3a0-savoir-3).
 ### Commandes à savoir
 - Commande pour lancez la pile de conteneur en mode détachée
 ```bash
 docker-compose up -d
 ```
 - Commande pour se connecter au serveur de bd avec un terminal de commande
 ```bash
 docker-compose exec my-mariadb bash
 ```
 *Cette commande est équivalente à la commande docker :*

    exec -it my-mariadb bash

- Vous pourrez dès lors listez les bases de données présentes sur ce serveur en tapant la commande suivante dans le terminal précédement ouvert
```bash
mariadb-show -p
```
*Le mot de passe demandé est [celui de l'adminstrateur de la BD](#informations-importantes).*



## TP7
 *Retour à la [table des matière](#table-des-matière)*


## TP8
 *Retour à la [table des matière](#table-des-matière)*


## TP9
 *Retour à la [table des matière](#table-des-matière)*


## TP10
 *Retour à la [table des matière](#table-des-matière)*


## TP11
 *Retour à la [table des matière](#table-des-matière)*


## TP12
 *Retour à la [table des matière](#table-des-matière)*


## TP13
 *Retour à la [table des matière](#table-des-matière)*
