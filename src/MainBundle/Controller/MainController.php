<?php

namespace MainBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{
    /**
     * Page d'accueil
     */
    public function homeAction(Request $request)
    {

        $popularSeries = $this->getDoctrine()->getRepository("MainBundle:Critic")->getPopularSerie();

        return $this->render("MainBundle:App:home.html.twig", [
            "popularSeries" => $popularSeries

        ]);
    }

    public function wallAction(Request $request)
    {
        $userId = $this->getUser()->getId()->__toString();
        $user = $this->getUser();

        $serieSuggest = $this->get("SuggestSerie")->getSuggestion($userId);
        $wallInfo = $this->getDoctrine()->getRepository("MainBundle:Favoris")->wall($userId);

        return $this->render("MainBundle:App:wall.html.twig", [
            "wallInfo" => $wallInfo,
            "serieSuggest" => $serieSuggest,
            "user" => $user
        ]);
    }

    public function unloggedWallAction(Request $request)
    {
        $serieId = "123f3c71-8462-4a24-9cb6-1c8152149edf";

        $trendingSerie = $this->getDoctrine()->getRepository("MainBundle:Critic")->getPopularSerie();

        //TODO: FAIRE EN SORTE DE RECUPERER LES DERNIERS EPISODES SORTIES
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
        $user = $this->getUser();
        $series = $this->getDoctrine()->getRepository("MainBundle:Serie")->getSeriesSortByDate();
        $actors = $this->getDoctrine()->getRepository("MainBundle:Actor")->getActors();
        $types = $this->getDoctrine()->getRepository("MainBundle:Type")->getTypes();

        return $this->render("MainBundle:App:search.html.twig", [
            "serie" => $series,
            "user" => $user,
            "actors" => $actors,
            "types" => $types
        ]);
    }

    public function favorisAction(Request $request)
    {
        $serieId = $request->attributes->get("idSerie");
        $userId = $this->getUser()->getId()->__toString();
        $user = $this->getUser();

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
            "serieSuggest" => $serieSuggest,
            "user" => $user
        ]);
    }

    public function serieAction(Request $request)
    {
        $serieId = $request->attributes->get("idSerie");

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
        $user = $this->getUser();

        return $this->render("MainBundle:App:serie.html.twig", [
            "episodes" => $episodes,
            "serie" => $serie,
            "critics" => $critics,
            "actors" => $actors,
            "types" => $types,
            "user" => $user
            ]);
    }

    public function episodeAction(Request $request)
    {
        $serieId = $request->attributes->get("idSerie");
        $episodeId = $request->attributes->get("idEpisode");

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
        $user = $this->getUser();

        return $this->render("MainBundle:App:serie.html.twig", [
            "episodes" => $episodes,
            "serie" => $serie,
            "critics" => $critics,
            "actors" => $actors,
            "types" => $types,
            "episode" => $episode,
            "user" => $user
        ]);
    }

    public function accountAction(Request $request)
    {
        $userId = $this->getUser()->getId()->__toString();

        $serieSuggest = $this->get("SuggestSerie")->getSuggestion($userId);
        $user = $this->getDoctrine()->getRepository("MainBundle:User")->getUserById($userId);

        return $this->render("MainBundle:App:account.html.twig", [
            "user" => $user,
            "serieSuggest" => $serieSuggest
        ]);
    }

    public function legalAction(Request $request)
    {
        return $this->render("MainBundle:App:legal.html.twig");
    }

}
