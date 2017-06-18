FishBlock
=========

Projet fils rouge pour la fin d'année de formation de développeur à l'IMIE.

Groupe: Maxime, Benjamin, Thomas, Loïc

Documentation du projet
=======================
Mise en place du projet Symfony FishBlock
-----------------------------------------

1-Créer une base de données vide qui s'appelle fishblock
2-Cloner le répository.
3-Se placer dans le repertoire Fishblock
4-Faire composer install
5-A la fin de composer install, rentrés les différentes options de configuration demander
6-Faire un php bin/console doctrine:schema:update --force pour créer les tables
7-Créer le jeux de données

NB: Certaine personne auront reçus par mail un jeux de données a importer dans une database fishblock vide qui s'occupe de créer les tables et de les remplir (évite les étapes 6 et 7)

Pour la création du jeux de données:
---------------------------------------
    Appeler dans un controleur:
        $this->get("SaveSerie")->saveSerie("NomSerieSansEspace");
        Pour peupler la base de données.
        Puis faire:
        $this->get("SaveSerie")->genDataBase();
        Pour générer des utilisateurs, commentaire, favoris, like de commentaire

Bundle utiliser:
----------------
    Pour la connection à l'api: adrenth/thetvdb2
    Pour gérer les utilisateurs: friendsofsymfony/user-bundle
    Pour gerer doctrine qui utilise des uuid: ramsey/uuid et ramsey/uuid-doctrine

Adrenth / thetvdb2
------------------
Il s'agit d'un client API (Application Programming Interface ou Interface de programmation) pour le site thetvdb.com. Il utilise les flux XML (C'est un format d'échange de données, défini en XML version 1.0. On peut délivrer des données en les intégrant dans ce format, et l'on peut recueillir des données de sources multiples dans ce format. On désigne les sources par fil ou flux RSS) disponibles publiquement.

>>Enregistrement de clé API

Pour utiliser ce paquet PHP, vous devez demander une clé API à partir du site Web thetvdb.com : http://thetvdb.com/?tab=apiregister .

>>Directives à suivre:

Si vous utilisez les informations de l'API dans un produit commercial ou un site Web, vous devez envoyer un courriel à scott@thetvdb.com et attendre l'autorisation avant d'utiliser l'API. Toutefois, vous pouvez utiliser l'API pour le développement et les tests avant une publication publique.
Si vous disposez d'un programme accessible au public, VOUS DEVEZ informer vos utilisateurs de ce site Web et leur demander de contribuer à l'information et à l'illustration si possible.
Vous devez vous familiariser avec notre structure de données, qui est détaillée dans la documentation wiki.
Vous NE DEVEZ PAS effectuer plus de demandes que nécessaire pour chaque utilisateur. Cela signifie qu'il n'y a pas de téléchargement de tout notre contenu (nous fournirons la base de données si vous en avez besoin). Jouez bien avec notre serveur.
Vous NE DEVEZ PAS accéder directement à nos données sans utiliser les méthodes API documentées.
VOUS DEVEZ conserver l'adresse e-mail dans les informations de votre compte au courant et exacte au cas où nous devrions vous contacter en ce qui concerne votre clé (nous détestons le spam autant que n'importe qui, donc nous ne divulguerons jamais votre adresse électronique à personne).
N'hésitez pas à nous contacter et à demander des modifications à notre site et / ou API. Nous examinerons volontiers toutes les suggestions raisonnables.
Source: thetvdb.com

<<>>API v2 (celle utilisée pour le fil rouge)

>>Installation
Installation du paquet en utilisant le compositeur: $ composer require adrenth/thetvdb

>>Usage
Créer une instance client:
$apiKey = 'yourapikey';
$cache = new \Doctrine\Common\Cache\FilesystemCache('path/to/cache');
$client = new Client($cache, $apiKey);

>>Cache
$client->setCacheTtl(3600); // in seconds

>>La langue
$language = new Language('nl');
echo $language->getCode();
// 'nl'
echo $language->getLabel();
// 'Nederlands'
$language = $client->getUserPreferredLanguage($accountId);

>>Gérer les notes des utilisateurs
// Returns a UserFavoritesResponse
$favorites = $client->getUserFavorites($accountId);
$seriesIds = $favorites->getSeriesIds();
$favorites = $client->addUserFavorite($accountId, $seriesId);
$seriesIds = $favorites->getSeriesIds();
$favorites = $client->removeUserFavorite($accountId, $seriesId);
$seriesIds = $favorites->getSeriesIds();

>>Gérer les notes des utilisateurs
$rating = $client->addUserRatingForEpisode($accountId, $episodeId, $rating);
$rating = $client->removeUserRatingForEpisode($accountId, $episodeId);
$rating = $client->addUserRatingForSeries($accountId, $seriesId, $rating);
$rating = $client->removeUserRatingForSeries($accountId, $seriesId);
echo $rating->getUserRating();
// 7
echo $rating->getCommunityRating();
// 7.65

>>Série recherche / recherche
$language = new Language('nl');
$response = $client->getSeries('Ray Donovan', $language, $accountId);
$seriesCollection = $response->getSeries();
foreach ($seriesCollection as $series) {
    echo $series->getName();
}
$response = $client->getSeriesByImdbId('tt0290978');
$response = $client->getSeriesByImdbId('tt0290978', new \Adrenth\Thetvdb\Language('de'));
$response = $client->getSeriesByZap2itId('EP01579745', new \Adrenth\Thetvdb\Language('nl'));

>>Mise en cache
Ce paquetage nécessite une Cacheinstance Doctrine . Pour désactiver la mise en cache (ce que je ne recommanderai jamais!), Il suffit de fournir une instance VoidCacheou ArrayCache.
Pour plus d'informations sur Doctrine Cache, visitez https://github.com/doctrine/cache


friendsofsymfony/user-bundle
----------------------------
Le composant de sécurité Symfony2 fournit un cadre de sécurité flexible qui nous permet de charger les utilisateurs à partir de la configuration, d'une base de données ou d'autres endroits que nous pouvons imaginer.

Si nous devons persister et récupérer des utilisateurs dans notre système vers et à partir d'une base de données, c'est le bundle adéquat.

<<>>Conditions préalables d'utilisation du bundle :

>>Traductions
Pour utiliser des textes par défaut fournis dans le paquage, nous devons nous assurer que notre traducteur est activé dans notre configuration:
app/resources/translations/message.fr.yml

>>Installation
Processus en 8 étapes:
    >Télécharger FOSUserBundle
        Les fichiers du bundle seront téléchargés dans le répertoire:
        vendor/fsofsymfony/userBundle
        Sous-modules git, exécutez les opérations suivantes:
        $ Git submodule add git: //github.com/FriendsOfSymfony/FOSUserBundle.git fournisseur / bundles / FOS / UserBundle
        Mise à jour du module de $ git --init
    >Configurer l'autochargeur
        On ajoute l'espace de noms à notre chargeur automatique:
        <? Php
        // app / autoload.php
        $ Loader -> registerNamespaces ( array ( // ... ' FOS ' => __DIR__ . ' /../vendor/bundles ' , ));  
    >Activer le Bundle
        On active le lot dans le noyau:
        <? Php
        // app / AppKernel.php
        Public  function  registerBundles () 
        { 
            $ bundles = array ( // ... nouveau FOS \ UserBundle \ FOSUserBundle (),     ); }
    >Création de notre classe User
        On persiste une Userclasse dans notre base de données (MySql) puis on crée la classe User pour l'application. On ajoute les propriétés ou méthodes souhaitées qu'on trouve utiles.
        On utilise comme suit:
            *On étend la Userclasse de base
            *On mappe l'id champ qui doit être protégé car il hérite de la classe parent.
    >Configurez le security.yml de votre application
    >Configurez le FOSUserBundle
    >Importer le routage FOSUserBundle
    >Mettre à jour votre schéma de base de données


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
Le routing permet d'interpréter une URL et en déduire l'action et donc la page à afficher. 
C'est un système très puissant qui nous permettra de gérer tous les liens internes du projet. 
Le routing nous permet aussi de gérer facilement des URLs plus parlantes et de savoir à quelle action et donnée elle correspond. 

Pour comprendre comment fonctionne le routing dans Symfony, voici un petit schéma qui explique globalement le processus de traitement d'une requête HTTP: 
http://www.lafermeduweb.net/images/tutorial/47/.orig/symfony2-schema-routing.jpg

Le fichier contenant les routes de notre bundle est chargé dans le fichier app/config/routing.yml
 (Le chemin d'accès au fichier contenant toutes les routes de notre bundle.)
Eventuellement on peut ajouter un préfixe à nos routes.

//\\Explications sur les routes de notre projet fil rouge:
main_home:
    path:     /{_locale}
    defaults:
        _controller: MainBundle:Main:home
        _locale: en
    requirements:
        _locale: en|fr

Cette route fait appel à la méthode homeAction du controller MainController et renvoit les informations des séries populaires.

On y accède en rajoutant dans l'URL: /{_locale} ou ../en ou ../fr
+++++++++++++++++++++++++++++++++++++++++++
main_wall:
    path:     /{_locale}/wall
    defaults:
        _controller: MainBundle:Main:wall
    requirements:
        _locale: en|fr

Cette route fait appel à la méthode wallAction du controller MainController et renvoit les informations sur:
    >le wall (mur), 
    >les suggestions de séries 
    >l'utilisatuer.

On y accède en rajoutant dans l'URL: /{_locale}/wall ou _locale: /en ou /fr
++++++++++++++++++++++++++++++++++++++++++++++++++
main_unloggedWall:
    path:     /{_locale}/unWall
    defaults:
        _controller: MainBundle:Main:unloggedWall
    requirements:
        _locale: en|fr

Cette route fait appel à la méthode unloggedWallAction du controller MainController et renvoit les informations sur: 
    >les tendances des séries, 
    >les dernières publications d'une série, 
    >les dernières publications d'un épisode, 
    >les dernières publications des critiques.

On y accède en rajoutant dans l'URL: /{_locale}/unWall ou _locale: /en ou /fr
+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
main_search:
    path:     /{_locale}/search
    defaults:
        _controller: MainBundle:Main:search
    requirements:
        _locale: en|fr

Cette route fait appel à la méthode searchAction du controller MainController et renvoit les informations sur: 
    >les séries, 
    >l'utilisateur, 
    >les acteurs, 
    >les genres de série.

On y accède en rajoutant dans l'URL: /{_locale}/search ou _locale: /en ou /fr
+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
main_favoris:
    path:     /{_locale}/favoris
    defaults:
        _controller: MainBundle:Main:favoris
    requirements:
        _locale: en|fr

Cette route fait appel à la méthode favorisAction du controller MainController et renvoit les informations sur: 
    >les suggestions d'une série, 
    >l'utilisateur,
    >les favoris.

On y accède en rajoutant dans l'URL: /{_locale}/favoris ou _locale: /en ou /fr
+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
main_add_favoris:
   path:     /{_locale}/favoris/{idSerie}
   defaults:
       _controller: MainBundle:Main:favoris
   requirements:
       _locale: en|fr

Cette route fait appel à la méthode favorisAction du controller MainController et renvoit les informations sur: 
    >les suggestions d'une série, 
    >l'utilisateur,
    >les favoris.
En plus elle rajoute une série en favoris.

On y accède en rajoutant dans l'URL: /{_locale}/favoris ou _locale: /en ou /fr
+++++++++++++++++++++++++++++++++++++++++++++++++
main_serie:
    path:     /{_locale}/serie/{idSerie}
    defaults:
        _controller: MainBundle:Main:serie
    requirements:
        idSerie: '[a-zA-Z-0-9]{36}'
        _locale: en|fr

Cette route fait appel à la méthode serieAction du controller MainController et renvoit les informations sur: 
    >la liste des épisodes de la série, 
    >les infos de la série,
    >les infos sur les acteurs de la série,
    >les infos sur les genres de la série,
    >les infos sur l'utilisateur connecté,
    >les infos sur les critiques de la série.

On y accède en rajoutant dans l'URL: /{_locale}/serie/{idSerie} ou _locale: /en ou /fr
+++++++++++++++++++++++++++++++++++++++++++++++++
main_episode:
    path:     /{_locale}/serie/{idSerie}/episode/{idEpisode}
    defaults:
        _controller: MainBundle:Main:serie
    requirements:
        idSerie: '[a-zA-Z-0-9]{36}'
        idEpisode: '[a-zA-Z-0-9]{36}'
        _locale: en|fr

Cette route fait appel à la méthode episodeAction du controller MainController et renvoit les informations sur: 
    >les infos des épisodes d'une série, 
    >les infos de la série,
    >les infos sur les acteurs de la série,
    >les infos sur les genres de la série,
    >les infos sur l'utilisateur connecté,
    >les infos d'un épisode de la série.

On y accède en rajoutant dans l'URL: /{_locale}/serie/{idSerie}/episode/{idEpisode} ou _locale: /en ou /fr
+++++++++++++++++++++++++++++++++++++++++++++++++
main_account:
    path:     /{_locale}/account
    defaults:
        _controller: MainBundle:Main:account
    requirements:
        _locale: en|fr

Cette route fait appel à la méthode accountAction du controller MainController et renvoit les informations sur: 
    >l'utilisateur connecté,
    >les suggestions série.

On y accède en rajoutant dans l'URL: /{_locale}/account ou _locale: /en ou /fr
+++++++++++++++++++++++++++++++++++++++++++++++++
main_legal:
    path:     /{_locale}/legal
    defaults:
        _controller: MainBundle:Main:legal
    requirements:
        _locale: en|fr

Cette route fait appel à la méthode legalAction du controller MainController et renvoit les informations légales sur le l'utilisation du site.

On y accède en rajoutant dans l'URL: /{_locale}/legal ou _locale: /en ou /fr
+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
admin_modifSerie:
    path:     /{_locale}/admin/modifSerie
    defaults:
        _controller: MainBundle:Admin:modifSerie
    requirements:
        _locale: en|fr

Cette route fait appel à la méthode modifSerieAction du controller AdminController et devrait renvoyer après développement les idées suivantes:
         * Récupérer toutes les modifications en attente pour une série (SerieRepository)
         * Récupération du formulaire
         *      validation de la série (isValid en true)
         *      mettre l'ancienne qui a isValid=true en false
         *      supprimer les modifications refuser
         *      bannir un utilisateur
         * Récupérer toute les noms de série (a mettre dans le select) (SerieRepository)

On y accède en rajoutant dans l'URL: /{_locale}/admin/modifSerie ou _locale: /en ou /fr
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
admin_submitSerie:
    path:     /{_locale}/admin/submitSerie
    defaults:
        _controller: MainBundle:Admin:submitSerie
    requirements:
        _locale: en|fr

Cette route fait appel à la méthode submitSerieAction du controller AdminController et devrait renvoyer après développement les idées suivantes:
         * Récupérer les séries non valider et qui n'ont pas de doublon au niveau de l'uuid (SerieRepository)
         * Passer le valider de la série en cours à true (SerieRepository)
         * Supprimer la série de la base de données si on clique sur refuser (SerieRepository)
         * Bannir l'utilisateur (UserRepository)
         * Service de notification

On y accède en rajoutant dans l'URL: /{_locale}/admin/submitSerie ou _locale: /en ou /fr
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
admin_validCritic:
    path:     /{_locale}/admin/validCritic
    defaults:
        _controller: MainBundle:Admin:validCritic
    requirements:
        _locale: en|fr

Cette route fait appel à la méthode validCriticAction du controller AdminController et devrait renvoyer après développement les idées suivantes:
         * Récupération des série dans le select (SerieRepository)
         * Récupération des critiques non valider pour la série selectionner (CriticRepository)
         * Récupération du formulaire (CriticRepository)
         *      Si accepter passer isValid en true
         *      Si refuser supprime la critique
         * Service de notification (Service)

On y accède en rajoutant dans l'URL: /{_locale}/admin/validCritic ou _locale: /en ou /fr
++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
admin_userManager:
    path:     /{_locale}/admin/userManager
    defaults:
        _controller: MainBundle:Admin:userManager
    requirements:
        _locale: en|fr

Cette route fait appel à la méthode userManagerAction du controller AdminController et devrait renvoyer après développement les idées suivantes:
        * Récupération des informations utilisateurs (UserRepository)
        * Récupération du formulaire
        * Proumouvoir/bannir utilisateur

On y accède en rajoutant dans l'URL: /{_locale}/admin/validCritic ou _locale: /en ou /fr

NB: TOUTES CES FONCTIONNALITES RISQUE DE NE PAS ETRE PRESENTE DANS L'APPLICATION !


















