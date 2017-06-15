FishBlock
=========

Projet fils rouge pour la fin d'année de formation de développeur à l'IMIE.

Bundle utiliser:
    Pour la connection à l'api: adrenth/thetvdb2
    Pour gerer les utilisateurs: friendsofsymfony/user-bundle
    Pour gerer doctrine qui utilise des uuid: ramsey/uuid et ramsey/uuid-doctrine

Groupe: Maxime, Benjamin, Thomas, Loïc


Documentation du projet
=======================
Mise en place du projet Symfony FishBlock
-----------------------------------------
http://symfony.com/download 
Téléchargez   le   fichier   symfony   et   placez-le   dans   votre répertoire www de Wamp ou  projects d'EasyPHP.
Exécuter la commande suivante : 
	www> php symfony new <nom projet>
Afin   de   régler   les différents problèmes, rendez-vous à l'adresse :
		localhost/…/web/config.php 
Lorsque tout est réglé, rendez-vous sur la page:  	localhost/…/web/app_dev.php

Si  l'installeur  de  Symfony  ne  fonctionne  pas,  vous  pouvez également passer par Composer :

www> php composer.phar create-project symfony/framework-standard-edition <nom projet> "2.8.*"

Placez-vous dans le dossier créé pour toutes les autres commandes.


Structure du projet FishBlock
-----------------------------
app/bin/src/tests/var/vendor/web

app/
Ce répertoire contient la configuration de notre site, le  cache, les fichiers logs.
Le site est considéré comme une application.

src/
Ce répertoire contient l'ensemble du code source du site. 
C’est ici que se trouvent les bundles qui composent une application utilisant le framework Symfony.

vendor/
Ce répertoire contient les bibliothèques externes à l'application :
Twig, Doctrine, le kernel 

web/
Ce répertoire contient les fichiers qui doivent être accessibles librement par les visiteurs : img, CSS, JavaScript ainsi que le front controler (contrôleur fontral) …
Le contrôleur frontal reçoit toutes les requêtes de l'utilisateur, charge le Kernel de Symfony et lui transmet celles-ci.
app_dev.php   :   Le   contrôleur   frontal   chargeant   en   plus l'environnement de développement (outils de debug, etc)
app.php  :  L'environnement  de  production  (ne  redirige  vers aucune page pour le moment).
Les    erreurs    qui    surviennent    dans    l'environnement    de production   sont   stockées   dans   les   fichiers   logs   de Symfony: app/logs/prod.log


Création d'un bundle
--------------------
Définition Bundle
~~~~~~~~~~~~~~~~~
Un bundle est un ensemble de fichiers rangés dans un répertoire selon une architecture prédéfinie. Tous ces fichiers concernent la même fonctionnalité : exemple de bundles : Blog, Forum, Administration ...
Les fichiers contenus dans un bundle peuvent être aussi bien des fichiers PHP, CSS, JavaScript, des templates ...
Deux solutions pour créer notre bundle. Manuellement ou grâce à l'outil console. La deuxième méthode a été privilégiée car elle permet de générer une squelette générique de bundle (les dossiers, un contrôleur, un template, les ressources de routage, ...)
http://knpbundles.com/ 

Symfony> php app/console
Symfony> php app/console generate:bundle
Bundle namespace: Toto/TestBundle
Bundle name [TotoTestBundle]: tapez Entrée
Target directory [D:/[...]/projects/Symfony/src]: Entrée
Configuration format (yml, xml, php, or annotation) [annotation]: yml
Do you want to generate the whole directory structure [no]? yes  Entrée
Do you confirm generation [yes]? Entrée
Confirm automatic update of the Routing [yes]? Entrée


Structure de notre bundle
-------------------------
../src/
MainBundle/
Controller/AdminController.php
Controller/MainController.php

Controller/
Ce répertoire contient tous les contrôleurs du bundle.
C'est lui qui contient toute la logique de notre site Internet. Il utilise les services, les modèles et appèle la vue. Il se contente de faire la liaison entre tout le monde.
Permet de créer et retourner un objet Response. Le long de son parcours, il pourrait lire l'information depuis la requête, charger une ressource de base de données, envoyer un mail, ou placer une information sur la session utilisateur. Mais dans tous les cas, le contrôleur va éventuellement retourner l'objet Response qu'il va fournir en retour au client.

../src/
MainBundle/
Resources/
views/base.html.twig
App/home.html.twig
Layout/menu.html.twig

Resources/views/
Contient les templates Twig (c’est-à-dire les vues) de notre bundle (MainBundle), organisés par contrôleurs.

../tests/TestAdd.php
AppBundle/Controller/DefaultControllerTest.php
MainBundle/Controller/DefaultControllerTest.php

Tests/
Contient tous les tests de notre bundle.


Chargement de nos Bundles
-------------------------
Tous les bundles chargés dans notre application sont déclarés dans le fichier AppKernel.php (dossier app)
app/AppKernel.php


Chemin vers notre Bundle
------------------------
Les routes de notre application : 
app/config/routing.yml

app:
   resource: "@AppBundle/Controller/"
   type: annotation

Il est possible de changer ou renommer ce fichier dans le fichier de configuration :
app/config/config.yml

framework:
    #esi: ~
    default_locale: 'en'
    translator:
        fallbacks: ['%locale%']
    secret: '%secret%'
    router:
        resource: '%kernel.root_dir%/config/routing.yml'
        ...


Préfixer nos routes
-------------------
Le fichier contenant les routes de notre bundle est chargé dans 
le fichier app/config/routing.yml :
app:
    resource: "@AppBundle/Controller/"
    type: annotation (Ligne 2 : Le chemin d'accès au fichier contenant toutes les routes de notre bundle.)
Eventuellement on peut ajouter un préfixe à nos routes.
app_blog:
		 resource: "@AppBundle/Controller/BlogController"
         type: annotation
         prefix: /blog




