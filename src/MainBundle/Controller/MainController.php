<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{

    // Affiche la page d'accueil qui demande le login de l'utilisateur
    public function homeAction(Request $request)
    {
        return $this->render("MainBundle:Main:home.html.twig");
    }

    // Affichage du wall de l'utilisateur connecté
    public function wallAction(Request $request)
    {
        return $this->render("MainBundle:Main:wall.html.twig");
    }

    // Affichage de toutes les séries favorite pour l'utilisateur
    public function favorisAction(Request $request)
    {
        return $this->render("MainBundle:Main:favoris.html.twig");
    }

}
