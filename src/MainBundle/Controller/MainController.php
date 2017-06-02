<?php

namespace MainBundle\Controller;

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
        return $this->render("MainBundle:Main:home.html.twig");
    }

    /**
     * Wall
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

    /**
     * Serie
     */
    public function serieAction(Request $request)
    {
        return $this->render("MainBundle:Main:serie.html.twig");
    }

}
