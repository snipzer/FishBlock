<?php

namespace MainBundle\Service;


use Adrenth\Thetvdb\Exception\ResourceNotFoundException;
use Doctrine\ORM\EntityManager;
use MainBundle\Entity\Actor;
use MainBundle\Entity\Episode;
use MainBundle\Entity\Serie;
use MainBundle\Entity\SerieActor;
use MainBundle\Entity\SerieType;
use MainBundle\Entity\Type;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SaveSerie extends Controller
{
    private $manager;
    private $tvdbClient;

    public function __construct(EntityManager $em, TvdbConnector $tvdbConnector)
    {
        $this->manager = $em;
        $this->tvdbClient = $tvdbConnector;
    }

    public function saveSerie($serieName)
    {

        $results = $this->tvdbClient->searchSerieByName($serieName);

        foreach ($results as $result)
        {
            if ($this->manager->getRepository("MainBundle:Serie")->checkIfSerieAlreadyHere($result->getSeriesName()))
            {

                $serieId = $result->getId();
                $serieFromApi = $this->tvdbClient->getSerieById($serieId);

                $serie = new Serie();
                $serie->setTitle(($serieFromApi->getSeriesName()) ? $serieFromApi->getSeriesName() : "undefined")
                    ->setDescription(($serieFromApi->getOverview()) ? $serieFromApi->getOverview() : "undefined")
                    ->setPoster(($serieFromApi->getBanner()) ? $serieFromApi->getBanner() : "undefined")
                    ->setAirsDayOfWeek(($serieFromApi->getAirsDayOfWeek()) ? $serieFromApi->getAirsDayOfWeek() : "undefined")
                    ->setAirsTime(($serieFromApi->getAirsTime()) ? $serieFromApi->getAirsTime() : "undefined")
                    ->setIsValid(true);

                $genres = $serieFromApi->getGenre();

                foreach ($genres as $genre)
                {
                    if ($this->manager->getRepository("MainBundle:Type")->checkIfTypeAlreadyHere($genre))
                    {
                        $type = new Type();
                        $type->setName($genre);

                        $serieType = new SerieType();
                        $serieType->setType($type)
                            ->setSerie($serie);

                        $serie->setSerieTypes($serieType);

                        $this->manager->persist($serieType);
                        $this->manager->persist($type);
                    }
                }

                $actorsFromApi = $this->tvdbClient->getActeursFromSerie($serieId);

                foreach ($actorsFromApi as $actorFromApi)
                {
                    if ($this->manager->getRepository("MainBundle:Actor")->checkIfActorAlreadyHere($actorFromApi->getName()))
                    {
                        $actor = new Actor();
                        $actor->setName(($actorFromApi->getName()) ? $actorFromApi->getName() : "undefined")
                            ->setPicture(($actorFromApi->getImage()) ? $actorFromApi->getImage() : "undefined");

                        $serieActor = new SerieActor();
                        $serieActor->setSerie($serie)
                            ->setActor($actor)
                            ->setRole(($actorFromApi->getRole()) ? $actorFromApi->getRole() : "undefined");

                        $serie->setSerieActors($serieActor);
                        $actor->setSerieActors($serieActor);

                        $this->manager->persist($actor);
                        $this->manager->persist($serieActor);
                    }
                }

                $episodesFromApi = $this->tvdbClient->getEpisodesFromSerie($serieId);

                foreach ($episodesFromApi as $episodeFromApi)
                {
                    $bool = $this->manager->getRepository("MainBundle:Episode")
                        ->CheckIfEpisodeAlreadyHere($episodeFromApi->getEpisodeName(), $episodeFromApi->getAiredEpisodeNumber(), $episodeFromApi->getAiredSeason());

                    if ($bool)
                    {
                        $episode = new Episode();
                        $episode->setTitle(($episodeFromApi->getEpisodeName()) ? $episodeFromApi->getEpisodeName() : "undefined")
                            ->setDescription(($episodeFromApi->getOverview()) ? $episodeFromApi->getOverview() : "undefined")
                            ->setEpisodeNumber(($episodeFromApi->getAiredEpisodeNumber()) ? $episodeFromApi->getAiredEpisodeNumber() : 9999)
                            ->setSeasonNumber(($episodeFromApi->getAiredSeason()) ? $episodeFromApi->getAiredSeason() : 9999)
                            ->setSerie($serie);

                        $serie->setEpisodes($episode);

                        $this->manager->persist($episode);
                    }
                }

                $this->manager->persist($serie);
                $this->manager->flush();
            }

        }

    }
}

?>