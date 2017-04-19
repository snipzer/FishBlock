<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{

    /**
     * Fonction qui affiche la page d'accueil
     * Elle demande a l'utilisateur de se logger pour pouvoir continuer
     * Elle permet aussi de créer un compte
     */
    public function homeAction(Request $request)
    {
        return $this->render("MainBundle:Main:home.html.twig");
    }

    /**
     * Si l'utilisateur est connecter, il peut voir sont wall
     * Le wall est constitué de l'ensembles des nouvelles critique arrivé sur les séries que l'utilisateur à en favoris
     */
    public function wallAction(Request $request)
    {
        return $this->render("MainBundle:Main:wall.html.twig");
    }

    /**
     * Affichage de toutes les séries que l'utilisateur a dans ses favoris
     */
    public function favorisAction(Request $request)
    {
        return $this->render("MainBundle:Main:favoris.html.twig");
    }

}
