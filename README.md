# Initiation à docker
## Auteur
```Axel COUDROT```
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

## TP2
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

- Utilisation de :
```bash
docker run -ti --name=my-ubuntu --volume /working/<votre_login>/s4-docker/partage:/myData ubuntu /bin/bash
```
- A la racine du container, les fichier ne persistent pas en dehors de celui-ci, ils ne sont présent que à l'intérieur. Pour accéder à des fichier dans la machine hôte il faut utiliser le dossier spécifié lors de la création, dans notre exemple : /myData
![Partage de fichiers entre le container et l'hôte](image.png)


## TP5
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