FishBlock
=========

Projet fils rouge pour la fin d'année de formation de développeur à l'IMIE.

Pour la création de la base de données:
=
    Appeler dans un controleur:
        $this->get("SaveSerie")->saveSerie("NomSerieSansEspace");
        Pour peupler la base de données.
        Puis faire:
        $this->get("SaveSerie")->genDataBase();
        Pour générer des utilisateurs, commentaire, favoris, like de commentaire


Bundle utiliser:
=
    Pour la connection à l'api: adrenth/thetvdb2
    Pour gerer les utilisateurs: friendsofsymfony/user-bundle
    Pour gerer doctrine qui utilise des uuid: ramsey/uuid et ramsey/uuid-doctrine

Groupe: Maxime, Benjamin, Thomas, Loïc
