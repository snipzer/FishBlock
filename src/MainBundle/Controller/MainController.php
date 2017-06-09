<?php

namespace MainBundle\Controller;

use MainBundle\Entity\Actor;
use MainBundle\Entity\Episode;
use MainBundle\Entity\Serie;
use MainBundle\Entity\SerieActor;
use MainBundle\Entity\SerieType;
use MainBundle\Entity\Type;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{

    /**
     * Page d'accueil
     */
    public function homeAction(Request $request)
    {
        /**
         * TODO:
         * Login (UserRepository)
         * New User (EntityManager)
         * Recupération des séries populaires (SerieRepository)
         * Switch de la langue
         */

        //return $this->render("MainBundle::home.html.twig");

        $translated = $this->get('translator')->trans('english');

        return new Response($translated);
    }

    public function wallAction(Request $request)
    {
        /**
         * TODO:
         * Information série (SerieRepository)
         * Note série (SerieRepository)
         * Ajout série en favoris (FavoriteRepository)
         * Suggestion de série (SerieRepository)
         * Afficher les critiques des séries que l'utilisateur à en favoris (Service)
         * Système de like/dislike (CriticNotationRepository)
         */

        return $this->render("MainBundle::wall.html.twig");
    }

    public function unloggedWallAction(Request $request)
    {
        /**
         * TODO:
         * Service de notification (Service)
         * Récupération des séries populaires(SerieRepository)
         * Récupération des derniers épisodes publier (EpisodeRepository)
         * Récupération des dernières série publier (SerieRepository)
         * Récupération des dernières critiques (CriticRepository)
         */

        return $this->render("MainBundle::unloggedWall.html.twig");
    }


    public function searchAction(Request $request)
    {
        /**
         * TODO:
         * Récupération des séries (SerieRepository)
         * Process rechercher des séries (Service)
         *      Récupérer les séries en base de données avec la recherche
         *      SI pas de résultat: Récupére la série avec tvdb (Service TvdbConnector)
         *             Si pas de résultat on propose de créer la série
         *      Si un résultat l'envoyer sur la page
         * Ajout de série en favoris (FavorisRepository)
         *
         */

        $manager = $this->getDoctrine()->getManager();
        $tvdbClient = $this->get('tvdbconnector');

        $results = $tvdbClient->searchSerieByName("stargate");


        foreach($results as $result)
        {
            $serieId = $result->getId();
            $serieFromApi = $tvdbClient->getSerieById($serieId);

            $serie = new Serie();

            $serie->setTitle($serieFromApi->getSeriesName())
                ->setDescription($serieFromApi->getOverview())
                ->setPoster($serieFromApi->getBanner())
                ->setAirsDayOfWeek($serieFromApi->getAirsDayOfWeek())
                ->setAirsTime($serieFromApi->getAirsTime())
                ->setIsValid(true);


            $genres = $serieFromApi->getGenre();

            foreach($genres as $genre)
            {
                $type = new Type();
                $type->setName($genre);

                $serieType = new SerieType();
                $serieType->setType($type)
                        ->setSerie($serie);

                $serie->setSerieTypes($serieType);

                $manager->persist($serieType);

                $manager->persist($type);


            }

            $actorsFromApi = $tvdbClient->getActeursFromSerie($serieId);

            foreach($actorsFromApi as $actorFromApi)
            {
                $actor = new Actor();
                $actor->setName($actorFromApi->getName())
                      ->setPicture($actorFromApi->getImage());

                $serieActor = new SerieActor();
                $serieActor->setSerie($serie)
                           ->setActor($actor)
                           ->setRole($actorFromApi->getRole());

                $serie->setSerieActors($serieActor);
                $actor->setSerieActors($serieActor);

                $manager->persist($actor);


                $manager->persist($serieActor);

            }

            $episodesFromApi = $tvdbClient->getEpisodesFromSerie($serieId);

            foreach($episodesFromApi as $episodeFromApi)
            {
                $episode = new Episode();
                $episode->setTitle($episodeFromApi->getEpisodeName())
                        ->setDescription($episodeFromApi->getOverview())
                        ->setEpisodeNumber($episodeFromApi->getAiredEpisodeNumber())
                        ->setSeasonNumber($episodeFromApi->getAiredSeason())
                        ->setSerie($serie);

                $serie->setEpisodes($episode);

                $manager->persist($episode);

            }

            $manager->persist($serie);
            $manager->flush();
        }

        return $this->render("MainBundle::search.html.twig");
    }

    public function favorisAction(Request $request)
    {
        /**
         * TODO:
         * Suggestion de série (SerieRepository)
         * Ajout de série en favoris (FavorisRepository)
         * Service de notification (Service)
         * Récupération de la note de la série (SerieRepository)
         */

        return $this->render("MainBundle::favoris.html.twig");
    }

    public function serieAction(Request $request)
    {
        /**
         * TODO:
         * Récupérer les acteurs (ActorRepository)
         * Récupérer les types (TypeRepository)
         * Récupérer une/plusieurs série en fonction d'un submit utilisateur (SerieRepository)
         * Récupérer les épisodes d'une série (EpisodeRepository)
         * Créer une critique en fonction d'un submit utilisateur (EntityManager)
         * Modification d'une série avec un submit utilisateur (SerieRepository)
         * Système de like/dislike (CriticNotationRepository)
         * Récupération de toutes les critiques d'une série (CriticRepository)
         * Ajout de la série en favoris (FavorisRepository)
         * Récupération de la note d'une série (SerieRepository)
         * Notification (Service)
         */

        return $this->render("MainBundle::serie.html.twig");
    }

    public function episodeAction(Request $request)
    {
        /**
         * TODO:
         * Récupérer les informations d'un épidose (EpisodeRepository)
         */

        return $this->render("MainBundle::serie.html.twig");
    }

    public function accountAction(Request $request)
    {
        /**
         * TODO:
         * Récupérer les informations de l'utilisateur
         * Après soumission du formulaire enregistrer les nouvelles informations de l'utilisateur
         * ATTENTION !
         * Les mots de passe ne doivent pas être envoyer en clair !
         * Suggestion de serie (SerieRepository)
         */

        return $this->render("MainBundle::account.html.twig");
    }

}
