<?php

namespace MainBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class MainController extends Controller
{

    public function homeAction(Request $request)
    {
        $firstName = htmlentities($request->get('firstname'));
        $lastName = htmlentities($request->get('lastname'));
        $userName = htmlentities($request->get('username'));
        $email = htmlentities($request->get('email'));
        $password = htmlentities($request->get("password"));
        $passwordConfirm = htmlentities($request->get("passwordConfirmation"));
        $birthDate = htmlentities($request->get('birthday'));

        if((isset($firstName) && isset($lastName) && isset($userName) && isset($password) && isset($passwordConfirm) && isset($birthDate) && isset($email))
            && ($firstName != "" && $lastName != "" && $userName != "" && $password != "" && $passwordConfirm != "" && $birthDate != "" && $email != ""))
        {
            if($password === $passwordConfirm)
            {
                $this->getDoctrine()->getRepository("MainBundle:User")->createUser($email, $password, $userName, $firstName, $lastName, "ROLE_USER");
                $error = "Compte créer";
            }
            else
            {
                $error = "Password should be identical";
            }
        }

        $popularSeries = $this->getDoctrine()->getRepository("MainBundle:Critic")->getPopularSerie();
        $user = $this->getUser();

        if (isset($user))
        {
            return $this->render("MainBundle:App:home.html.twig", [
                "popularSeries" => $popularSeries,
                "user" => $user
            ]);
        }

        if(isset($error))
        {
            return $this->render("MainBundle:App:home.html.twig", [
                "popularSeries" => $popularSeries,
                "error" => $error
            ]);
        }

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
        $trendingSeries = $this->getDoctrine()->getRepository("MainBundle:Critic")->getPopularSerie();

        $lastPublishedSeries = $this->getDoctrine()->getRepository("MainBundle:Serie")->getSeriesSortByDate();

        $lastPublishedCritics = $this->getDoctrine()->getRepository("MainBundle:Critic")->getLastUploadedAndValidatedCritics();

        return $this->render("MainBundle:App:unloggedWall.html.twig", [
            "trendingSeries" => $trendingSeries,
            "lastPublishedSeries" => $lastPublishedSeries,
            "lastPublishedCritics" => $lastPublishedCritics
        ]);
    }


    public function searchAction(Request $request)
    {
        $IdType = $request->get("types");
        $IdActor = $request->get("actors");
        $SerieName = htmlentities($request->get('serieName'));

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
        $favorisId = $request->attributes->get("idFavoris");

        if($serieId)
        {
            if(!$FavorisRepo->checkIfSerieIsInFav($serieId, $userId))
                $FavorisRepo->addSerie($userId, $serieId);
        }

        if($favorisId)
        {
            $FavorisRepo->removeFavoris($favorisId);
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
        $user = $this->getUser();


        $EpisodeRepository = $this->getDoctrine()->getRepository("MainBundle:Episode");
        $SerieRepository = $this->getDoctrine()->getRepository("MainBundle:Serie");
        $CritiqueRepository = $this->getDoctrine()->getRepository("MainBundle:Critic");
        $ActorRepository = $this->getDoctrine()->getRepository("MainBundle:SerieActor");
        $TypeRepository = $this->getDoctrine()->getRepository("MainBundle:SerieType");

        $CriticTitle = htmlentities($request->get("title"));
        $CriticContent = htmlentities($request->get("content"));
        $CriticNote = htmlentities($request->get('note'));

        if((isset($CriticTitle) && isset($CriticContent) && isset($CriticNote) && ($CriticTitle != "" && $CriticContent != "" && $CriticNote != "")))
        {
            $CritiqueRepository->postCritic($CriticTitle, $CriticContent, $CriticNote, $user->getId()->__toString(), $serieId);
        }

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
            "types" => $types,
            "user" => $user
            ]);
    }

    public function episodeAction(Request $request)
    {
        $serieId = $request->attributes->get("idSerie");
        $episodeId = $request->attributes->get("idEpisode");
        $user = $this->getUser();

        $EpisodeRepository = $this->getDoctrine()->getRepository("MainBundle:Episode");
        $SerieRepository = $this->getDoctrine()->getRepository("MainBundle:Serie");
        $CritiqueRepository = $this->getDoctrine()->getRepository("MainBundle:Critic");
        $ActorRepository = $this->getDoctrine()->getRepository("MainBundle:SerieActor");
        $TypeRepository = $this->getDoctrine()->getRepository("MainBundle:SerieType");

        $CriticTitle = htmlentities($request->get("title"));
        $CriticContent = htmlentities($request->get("content"));
        $CriticNote = htmlentities($request->get('note'));

        if((isset($CriticTitle) && isset($CriticContent) && isset($CriticNote) && ($CriticTitle != "" && $CriticContent != "" && $CriticNote != "")))
        {
            $CritiqueRepository->postCritic($CriticTitle, $CriticContent, $CriticNote, $user->getId()->__toString(), $serieId);
        }


        $serie = $SerieRepository->getSerieWithId($serieId);
        $episode = $EpisodeRepository->getEpisode($episodeId);
        $critics = $CritiqueRepository->getValidatedCriticsFromSerie($serieId);
        $episodes = $EpisodeRepository->getEpisodesFromSerie($serieId);
        $actors = $ActorRepository->getActorBySerieId($serieId);
        $types = $TypeRepository->getTypeBySerieId($serieId);


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
        $user = $this->getUser();

        $NewPassword = htmlentities($request->get('password'));
        $NewPasswordConfirm = htmlentities($request->get('passwordConfirmation'));

        if((isset($NewPassword) && isset($NewPasswordConfirm)) && ($NewPassword != "" && $NewPasswordConfirm != ""))
        {
            $this->getDoctrine()->getRepository("MainBundle:User")->changeUserPassword($userId, $NewPassword, $NewPasswordConfirm);
        }


        $serieSuggest = $this->get("SuggestSerie")->getSuggestion($userId);

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
