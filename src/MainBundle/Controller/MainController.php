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


    // Controleur qui permet d'afficher la page de recherche
    public function searchAction(Request $request)
    {
        // On récupère le type choisie dans la recherche
        $IdType = $request->get("types");
        // On récupère l'acteur choisie dans la recherche
        $IdActor = $request->get("actors");

        // On récupère le nom de la série à rechercher
        $SerieName = htmlentities($request->get('serieName'));

        // On récupère l'objet perettant de requêter sur la table série
        $SerieRepo = $this->getDoctrine()->getRepository("MainBundle:Serie");

        // On récupère les séries trier par date d'enregistrement, les plus récentes sorte en premier
        $series = $SerieRepo->getSeriesSortByDate();
        // Si une recherche est effectuer
        if(isset($SerieName))
        {
            // On récupère toutes les séries qui corresponde au nom du formulaire
            $series = $SerieRepo->getSerieByName($SerieName);

            // Si on fait une recherche avec l'acteur et le type
            if((isset($IdActor) && isset($IdType)) && ($IdActor != "NULL" && $IdType != "NULL") )
            {
                $series = $SerieRepo->getSerieByNameAndTypeAndActor($SerieName, $IdActor, $IdType);
            }

            // Si on fait une recherche avec juste l'acteur
            if(isset($IdActor) && $IdActor != "NULL")
            {
                $series = $SerieRepo->getSerieByNameAndActor($SerieName, $IdActor);
            }

            // Si on fait une recherche avec juste le type
            if(isset($IdType) && $IdType != "NULL")
            {
                $series = $SerieRepo->getSerieByNameAndType($SerieName, $IdType);
            }
        }

        // On récupère les informations de l'utilisateur connecter
        $user = $this->getUser();
        // On récupère les acteurs pour les placers dans le formulaire de recherche
        $actors = $this->getDoctrine()->getRepository("MainBundle:Actor")->getActorsOrderByNameASC();
        // On récupère les types pour les placer dans le formulaire de recherche
        $types = $this->getDoctrine()->getRepository("MainBundle:Type")->getTypesOrderByNameASC();

        // On affiche la page en transmettant toutes les information necessaire
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

    public function pdfAction()
    {
        return $this->render("MainBundle:App:PDF.html.twig");
    }
}
