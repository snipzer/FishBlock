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
        $this->get('SaveSerie')->saveSerie("MacGyver");

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
        $trendingSerie = $this->getDoctrine()->getRepository("MainBundle:Critic")->getPopularSerie();

        $lastPublishedSerie = $this->getDoctrine()->getRepository("MainBundle:Serie")->getSeriesSortByDate();

        $lastPublishedCritics = $this->getDoctrine()->getRepository("MainBundle:Critic")->getLastUploadedAndValidatedCritics();

        return $this->render("MainBundle:App:unloggedWall.html.twig", [
            "trendingSerie" => $trendingSerie,
            "lastPublishedSerie" => $lastPublishedSerie,
            "lastPublishedCritics" => $lastPublishedCritics
        ]);
    }


    public function searchAction(Request $request)
    {
        $IdType = $request->get("types");
        $IdActor = $request->get("actors");
        $SerieName = $request->get('serieName');

        $SerieRepo = $this->getDoctrine()->getRepository("MainBundle:Serie");

        $series = $SerieRepo->getSeriesSortByDate();
        if(isset($SerieName))
        {
            $series = $SerieRepo->getSerieByName($SerieName);
            if((isset($IdActor) && isset($IdType)) && ($IdActor != "NULL" && $IdType != "NULL") )
            {
                $series = $SerieRepo->getSerieByNameAndTypeAndActor($SerieName, $IdActor, $IdType);
            }
            if(isset($IdActor) && $IdActor != "NULL")
            {
                $series = $SerieRepo->getSerieByNameAndActor($SerieName, $IdActor);
            }
            if(isset($IdType) && $IdType != "NULL")
            {
                $series = $SerieRepo->getSerieByNameAndType($SerieName, $IdType);
            }
        }

        $user = $this->getUser();
        $actors = $this->getDoctrine()->getRepository("MainBundle:Actor")->getActorsOrderByNameASC();
        $types = $this->getDoctrine()->getRepository("MainBundle:Type")->getTypesOrderByNameASC();

        return $this->render("MainBundle:App:search.html.twig", [
            "series" => $series,
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
        $FavorisRepo = $this->getDoctrine()->getRepository("MainBundle:Favoris");


        if($serieId)
        {
            if(!$FavorisRepo->checkIfSerieIsInFav($serieId, $userId))
                $FavorisRepo->addSerie($userId, $serieId);
        }

        $serieSuggest = $this->get("SuggestSerie")->getSuggestion($userId);
        $favoris = $FavorisRepo->getFavorisByUserId($userId);

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
