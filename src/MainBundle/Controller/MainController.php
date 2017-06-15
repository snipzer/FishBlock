<?php

namespace MainBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;

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
         * ~~Recupération des séries populaires (SerieRepository)
         */


        $popularSeries = $this->getDoctrine()->getRepository("MainBundle:Critic")->getPopularSerie();

        return $this->render("MainBundle:App:home.html.twig", [
            "popularSeries" => $popularSeries
        ]);
    }

    public function wallAction(Request $request)
    {
        /**
         * TODO:
         * Information série (SerieRepository)
         * Note série (SerieRepository)
         * Ajout série en favoris (FavoriteRepository)
         * Suggestion de série (SerieRepository)
         * ~~Afficher les critiques des séries que l'utilisateur à en favoris (Service)
         * Système de like/dislike (CriticNotationRepository)
         */
        $userId = "52fc83e7-59b2-45d3-94c2-c674385afdbe";

        $serieSuggest = $this->get("SuggestSerie")->getSuggestion($userId);
        $wallInfo = $this->getDoctrine()->getRepository("MainBundle:Favoris")->wall($userId);

        return $this->render("MainBundle:App:wall.html.twig", [
            "wallInfo" => $wallInfo,
            "serieSuggest" => $serieSuggest
        ]);
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

        $serieId = "123f3c71-8462-4a24-9cb6-1c8152149edf";

        $trendingSerie = $this->getDoctrine()->getRepository("MainBundle:Critic")->getPopularSerie();

        $lastPublishedEpisode = $this->getDoctrine()->getRepository("MainBundle:Episode")->getLastEpisodeFromSerie($serieId);

        $lastPublishedSerie = $this->getDoctrine()->getRepository("MainBundle:Serie")->getSeriesSortByDate();

        $lastPublishedCritics = $this->getDoctrine()->getRepository("MainBundle:Critic")->getLastUploadedAndValidatedCritics();

        return $this->render("MainBundle:App:unloggedWall.html.twig", [
            "trendingSerie" => $trendingSerie,
            "lastPublishedSerie" => $lastPublishedSerie,
            "lastPublishedEpisode" => $lastPublishedEpisode,
            "lastPublishedCritics" => $lastPublishedCritics
        ]);
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

        $series = $this->getDoctrine()->getRepository("MainBundle:Serie")->getSeriesSortByDate();

        return $this->render("MainBundle:App:search.html.twig", [
            "series" => $series
        ]);
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

        $serieId = $request->attributes->get("serieId");
        $userId = "52fc83e7-59b2-45d3-94c2-c674385afdbe";

        if($serieId)
        {
            $this->getDoctrine()
                ->getRepository("MainBundle:Favoris")
                ->addSerie($userId, $serieId);
        }



        $serieSuggest = $this->get("SuggestSerie")->getSuggestion($userId);
        $favoris = $this->getDoctrine()->getRepository("MainBundle:Favoris")->getFavorisByUserId($userId);

        return $this->render("MainBundle:App:favoris.html.twig", [
            "favoris" => $favoris,
            "serieSuggest" => $serieSuggest
        ]);
    }

    public function serieAction(Request $request)
    {
        /**
         * TODO:
         * ~~Récupérer les acteurs (ActorRepository)
         * ~~Récupérer les types (TypeRepository)
         * ~~Récupérer les épisodes d'une série (EpisodeRepository)
         * Créer une critique en fonction d'un submit utilisateur (EntityManager)
         * Modification d'une série avec un submit utilisateur (SerieRepository)
         * Système de like/dislike (CriticNotationRepository)
         * ~~Récupération de toutes les critiques d'une série (CriticRepository)
         * Ajout de la série en favoris (FavorisRepository)
         * Récupération de la note d'une série (SerieRepository)
         * Notification (Service)
         */
        $serieId = "86f55cf8-e0b5-4c61-a893-e29d93ae9de9";

        $EpisodeRepository = $this->getDoctrine()->getRepository("MainBundle:Episode");
        $SerieRepository = $this->getDoctrine()->getRepository("MainBundle:Serie");
        $CritiqueRepository = $this->getDoctrine()->getRepository("MainBundle:Critic");
        $ActorRepository = $this->getDoctrine()->getRepository("MainBundle:SerieActor");
        $TypeRepository = $this->getDoctrine()->getRepository("MainBundle:SerieType");

        $serie = $SerieRepository->getSerieWithId($serieId);
        $critics = $CritiqueRepository->getValidatedCriticsFromSerie($serieId);
        $episodes = $EpisodeRepository->getEpisodesFromSerie($serieId);
        $actors = $ActorRepository->getActorBySerieId($serieId);
        $types = $TypeRepository->getTypeBySerieId($serieId);

        return $this->render("MainBundle:App:serie.html.twig", [
            "episodes" => $episodes,
            "serie" => $serie,
            "critics" => $critics,
            "actors" => $actors,
            "types" => $types
            ]);
    }

    public function episodeAction(Request $request)
    {
        /**
         * TODO:
         * Pareil que serieAction
         * Récupérer les informations d'un épidose (EpisodeRepository)
         */
        $serieId = "123f3c71-8462-4a24-9cb6-1c8152149edf";
        $episodeId = "6f75f97d-011d-4a97-ae2d-0d007663f84f";

        $EpisodeRepository = $this->getDoctrine()->getRepository("MainBundle:Episode");
        $SerieRepository = $this->getDoctrine()->getRepository("MainBundle:Serie");
        $CritiqueRepository = $this->getDoctrine()->getRepository("MainBundle:Critic");
        $ActorRepository = $this->getDoctrine()->getRepository("MainBundle:SerieActor");
        $TypeRepository = $this->getDoctrine()->getRepository("MainBundle:SerieType");


        $serie = $SerieRepository->getSerieWithId($serieId);
        $critics = $CritiqueRepository->getValidatedCriticsFromSerie($serieId);
        $episodes = $EpisodeRepository->getEpisodesFromSerie($serieId);
        $actors = $ActorRepository->getActorBySerieId($serieId);
        $types = $TypeRepository->getTypeBySerieId($serieId);
        $episode = $EpisodeRepository->getEpisode($episodeId);

        return $this->render("MainBundle:App:serie.html.twig", [
            "episodes" => $episodes,
            "serie" => $serie,
            "critics" => $critics,
            "actors" => $actors,
            "types" => $types,
            "episode" => $episode
        ]);
    }

    public function accountAction(Request $request)
    {
        /**
         * TODO:
         * ~~Récupérer les informations de l'utilisateur
         * Après soumission du formulaire enregistrer les nouvelles informations de l'utilisateur
         * ATTENTION !
         * Les mots de passe ne doivent pas être envoyer en clair !
         * ~~Suggestion de serie (SerieRepository)
         */

        $userId = "52fc83e7-59b2-45d3-94c2-c674385afdbe";

        $serieSuggest = $this->get("SuggestSerie")->getSuggestion($userId);
        $user = $this->getDoctrine()->getRepository("MainBundle:User")->getUserById($userId);

        return $this->render("MainBundle:App:account.html.twig", [
            "user" => $user,
            "serieSuggest" => $serieSuggest
        ]);
    }

    public function legalAction(Request $request)
    {
        /**
         * TODO:
         * Afficher les mentions légales du site
         */

        return $this->render("MainBundle:App:legal.html.twig");
    }
}
