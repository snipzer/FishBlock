<?php

namespace MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends Controller
{

    public function modifSerieAction(Request $request)
    {
        /**
         * TODO:
         * Récupérer toutes les modifications en attente pour une série (SerieRepository)
         * Récupération du formulaire
         *      validation de la série (isValid en true)
         *      mettre l'ancienne qui a isValid=true en false
         *      supprimer les modifications refuser
         *      bannir un utilisateur
         * Récupérer toute les noms de série (a mettre dans le select) (SerieRepository)
         */
        return $this->render("MainBundle:App:admin.html.twig");
    }

    public function submitSerieAction(Request $request)
    {
        /**
         * TODO:
         * Récupérer les séries non valider et qui n'ont pas de doublon au niveau de l'uuid (SerieRepository)
         * Passer le valider de la série en cours à true (SerieRepository)
         * Supprimer la série de la base de données si on clique sur refuser (SerieRepository)
         * Bannir l'utilisateur (UserRepository)
         * Service de notification
         */
        return $this->render("MainBundle:App:admin.html.twig");
    }

    public function validCriticAction(Request $request)
    {
        /**
         * TODO:
         * Récupération des série dans le select (SerieRepository)
         * Récupération des critiques non valider pour la série selectionner (CriticRepository)
         * Récupération du formulaire (CriticRepository)
         *      Si accepter passer isValid en true
         *      Si refuser supprime la critique
         * Service de notification (Service)
         */
        return $this->render("MainBundle:App:admin.html.twig");
    }

    public function userManagerAction(Request $request)
    {
        /**
         * TODO:
         * Récupération des informations utilisateurs (UserRepository)
         * Récupération du formulaire
         *      Proumouvoir/bannir utilisateur
         */
        return $this->render("MainBundle:App:admin.html.twig");
    }
}
