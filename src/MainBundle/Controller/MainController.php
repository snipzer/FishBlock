<?php

namespace MainBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
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
         * ~~Recupération des séries populaires (SerieRepository)
         */


        $popularSeries = $this->getDoctrine()->getRepository("MainBundle:Critic")->getPopularSerie();

        $this->get("SuggestSerie")->getSuggestion("151e72a7-7084-4132-9416-2ce4c96dfbda");

//        $popularSeries = $this->getDoctrine()->getRepository("MainBundle:Critic")->getPopularSerie();



        return $this->render("MainBundle:App:home.html.twig"/*, [
            "popularSeries" => $popularSeries

        ]);

        ]*/);

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
        $toto = $this->getDoctrine()->getRepository("MainBundle:Favoris")->wall("ded4a698-d81a-49ed-a9ab-0cba024ef1f4");

        return $this->render("MainBundle:App:wall.html.twig");
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

        return $this->render("MainBundle:App:unloggedWall.html.twig");
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

        $this->get("SaveSerie")->saveSerie("stargate");
        return $this->render("MainBundle:App:search.html.twig");
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

        return $this->render("MainBundle:App:favoris.html.twig");
    }

    public function serieAction(Request $request)
    {
        /**
         * TODO:
         * Récupérer les acteurs (ActorRepository)
         * Récupérer les types (TypeRepository)
         * Récupérer les épisodes d'une série (EpisodeRepository)
         * Créer une critique en fonction d'un submit utilisateur (EntityManager)
         * Modification d'une série avec un submit utilisateur (SerieRepository)
         * Système de like/dislike (CriticNotationRepository)
         * Récupération de toutes les critiques d'une série (CriticRepository)
         * Ajout de la série en favoris (FavorisRepository)
         * Récupération de la note d'une série (SerieRepository)
         * Notification (Service)
         */
        $EpisodeRepository = $this->getDoctrine()->getRepository("MainBundle:Episode");
        $SerieRepository = $this->getDoctrine()->getRepository("MainBundle:Serie");
        $CritiqueRepository = $this->getDoctrine()->getRepository("MainBundle:Critic");

        $serie = $SerieRepository->getSerieWithId("3d4bc83d-dcda-4835-94f7-b17cceaa417a");
        $critics = $CritiqueRepository->getValidatedCriticsFromSerie($serie->getId());
        $episodes = $EpisodeRepository->getEpisodesFromSerie($serie->getId());

        return $this->render("MainBundle:App:serie.html.twig", [
            "episodes" => $episodes,
            "serie" => $serie,
            "critics" => $critics
            ]);
    }

    public function episodeAction(Request $request)
    {
        /**
         * TODO:
         * Récupérer les informations d'un épidose (EpisodeRepository)
         */

        return $this->render("MainBundle:App:serie.html.twig");
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

        return $this->render("MainBundle:App:account.html.twig");
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
