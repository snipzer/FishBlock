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


        $CriticNotationRepo = $this->getDoctrine()->getRepository("MainBundle:CriticNotation");

        $IdCriticForNotation = $request->get('idCriticForNotation');
        $like = $request->get('like');
        $dislike = $request->get('dislike');

        if(isset($IdCriticForNotation))
        {
            $isHaveNotation = $CriticNotationRepo->checkIfNotationAlreadyHere($IdCriticForNotation, $userId);

            if($isHaveNotation === false)
            {
                if(isset($IdCriticForNotation) && isset($like))
                {
                    $like = true;
                    $CriticNotationRepo->addNotation($IdCriticForNotation, $userId, $like);
                }

                if(isset($IdCriticForNotation) && isset($dislike))
                {
                    $dislike = false;
                    $CriticNotationRepo->addNotation($IdCriticForNotation, $userId, $dislike);
                }
            }
        }

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

        $serieSuggest = [];//$this->get("SuggestSerie")->getSuggestion($userId);
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

        $userId = $user->getId()->__toString();

        $CriticNotationRepo = $this->getDoctrine()->getRepository("MainBundle:CriticNotation");
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
            $CritiqueRepository->postCritic($CriticTitle, $CriticContent, $CriticNote, $userId, $serieId);
        }

        $IdCriticForNotation = $request->get('idCriticForNotation');
        $like = $request->get('like');
        $dislike = $request->get('dislike');

        if(isset($IdCriticForNotation))
        {
            $isHaveNotation = $CriticNotationRepo->checkIfNotationAlreadyHere($IdCriticForNotation, $userId);

            if($isHaveNotation === false)
            {
                if(isset($IdCriticForNotation) && isset($like))
                {
                    $like = true;
                    $CriticNotationRepo->addNotation($IdCriticForNotation, $userId, $like);
                }

                if(isset($IdCriticForNotation) && isset($dislike))
                {
                    $dislike = false;
                    $CriticNotationRepo->addNotation($IdCriticForNotation, $userId, $dislike);
                }
            }
        }


        $serie = $SerieRepository->getSerieWithId($serieId);
        $critics = $CritiqueRepository->getValidatedCriticsAndNotationFromSerie($serieId);
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
        $userId = $user->getId()->__toString();

        $CriticNotationRepo = $this->getDoctrine()->getRepository("MainBundle:CriticNotation");
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
            $CritiqueRepository->postCritic($CriticTitle, $CriticContent, $CriticNote, $userId, $serieId);
        }


        $IdCriticForNotation = $request->get('idCriticForNotation');
        $like = $request->get('like');
        $dislike = $request->get('dislike');

        if(isset($IdCriticForNotation))
        {
            $isHaveNotation = $CriticNotationRepo->checkIfNotationAlreadyHere($IdCriticForNotation, $userId);

            if($isHaveNotation === false)
            {
                if(isset($IdCriticForNotation) && isset($like))
                {
                    $like = true;
                    $CriticNotationRepo->addNotation($IdCriticForNotation, $userId, $like);
                }

                if(isset($IdCriticForNotation) && isset($dislike))
                {
                    $dislike = false;
                    $CriticNotationRepo->addNotation($IdCriticForNotation, $userId, $dislike);
                }
            }
        }


        $serie = $SerieRepository->getSerieWithId($serieId);
        $episode = $EpisodeRepository->getEpisode($episodeId);
        $critics = $CritiqueRepository->getValidatedCriticsAndNotationFromSerie($serieId);
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

        $NewFirstName = htmlentities($request->get('firstname'));
        $NewLastName = htmlentities($request->get('lastname'));
        $NewUserName = htmlentities($request->get('username'));
        $NewEmail = htmlentities($request->get('email'));

        if((isset($NewFirstName) && isset($NewLastName) && isset($NewUserName) && isset($NewEmail)) && ($NewFirstName != "" && $NewLastName != "" && $NewUserName != "" && $NewEmail != ""))
        {
            $this->getDoctrine()->getRepository("MainBundle:User")->changeUserInformation($userId, $NewEmail, $NewUserName, $NewFirstName, $NewLastName);
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
