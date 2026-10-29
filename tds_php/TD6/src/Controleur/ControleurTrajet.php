<?php

namespace App\Covoiturage\Controleur;

use App\Covoiturage\Modele\DataObject\Trajet;
use App\Covoiturage\Modele\Repository\TrajetRepository;
use App\Covoiturage\Modele\Repository\UtilisateurRepository;
use DateTime;

class ControleurTrajet
{
    private static function afficherVue(
        string $cheminVue,
        array $parametres = []
    ): void {
        extract($parametres);

        require __DIR__ . "/../vue/$cheminVue";
    }

    public static function afficherErreur(string $messageErreur = ""): void
    {
        self::afficherVue(
            'vueGenerale.php',
            [
                "messageErreur" => $messageErreur,
                "titre" => "Erreur",
                "cheminCorpsVue" => "trajet/erreur.php",
            ]
        );
    }

    public static function afficherListe(): void
    {
        /** @var Trajet[] $trajets */
        $trajets = (new TrajetRepository())->recuperer();

        self::afficherVue(
            'vueGenerale.php',
            [
                "trajets" => $trajets,
                "titre" => "Liste des trajets",
                "cheminCorpsVue" => "trajet/liste.php"
            ]
        );
    }

    public static function afficherDetail(): void
    {
        if (!isset($_GET['id'])) {
            self::afficherErreur("id obligatoire");
            return;
        }

        $id = $_GET['id'];

        $trajet = (new TrajetRepository())
            ->recupererParClePrimaire($id);

        if (!$trajet) {
            self::afficherErreur("trajet inexistant pour cet identifiant");
            return;
        }

        self::afficherVue(
            'vueGenerale.php',
            [
                "trajet" => $trajet,
                "titre" => "Afficher le trajet",
                "cheminCorpsVue" => "trajet/detail.php"
            ]
        );
    }

    public static function supprimer(): void
    {
        if (!isset($_GET['id'])) {
            self::afficherErreur("id obligatoire");
            return;
        }

        $id = $_GET['id'];

        (new TrajetRepository())->supprimer($id);

        self::afficherVue(
            'vueGenerale.php',
            [
                "titre" => "Trajet supprimé",
                "cheminCorpsVue" => "trajet/trajetSupprime.php"
            ]
        );
    }

    public static function afficherFormulaireCreation(): void
    {
        self::afficherVue(
            'vueGenerale.php',
            [
                "titre" => "Formulaire de création d'un trajet",
                "cheminCorpsVue" => "trajet/formulaireCreation.php"
            ]
        );
    }

    private static function construireDepuisFormulaire(array $tableauDonneesFormulaire): Trajet {

        $id = $tableauDonneesFormulaire["id"] ?? null;
        if ($id !== null) {
            $id = (int) $id;
        }

        $depart = $tableauDonneesFormulaire['depart'];
        $arrivee = $tableauDonneesFormulaire['arrivee'];
        $date = new DateTime($tableauDonneesFormulaire['date']);
        $prix = (int) $tableauDonneesFormulaire['prix'];
        $conducteurLogin = $tableauDonneesFormulaire['conducteurLogin'];
        $nonFumeur = isset($tableauDonneesFormulaire['nonFumeur']);

        $conducteur = (new UtilisateurRepository())->recupererParClePrimaire($conducteurLogin);

        return new Trajet(
            $id,
            $depart,
            $arrivee,
            $date,
            $prix,
            $conducteur,
            $nonFumeur
        );
    }

    public static function creerDepuisFormulaire(): void
    {
        $trajet = self::construireDepuisFormulaire($_GET);

        (new TrajetRepository())->ajouter($trajet);

        $trajets = (new TrajetRepository())->recuperer();

        self::afficherVue(
            'vueGenerale.php',
            [
                "trajets" => $trajets,
                "titre" => "Trajet créé",
                "cheminCorpsVue" => "trajet/trajetCree.php"
            ]
        );
    }

    public static function afficherFormulaireMiseAJour(): void
    {
        if (!isset($_GET['id'])) {
            self::afficherErreur("id obligatoire");
            return;
        }

        $trajet = (new TrajetRepository())
            ->recupererParClePrimaire($_GET['id']);

        if (!$trajet) {
            self::afficherErreur("Trajet inexistant pour cet identifiant");
            return;
        }

        self::afficherVue(
            'vueGenerale.php',
            [
                "trajet" => $trajet,
                "titre" => "Formulaire de mise à jour d'un trajet",
                "cheminCorpsVue" => "trajet/formulaireMiseAJour.php"
            ]
        );
    }

    public static function mettreAJour(): void
    {
        $trajet = self::construireDepuisFormulaire($_GET);

        (new TrajetRepository())->mettreAJour($trajet);

        $trajets = (new TrajetRepository())->recuperer();

        self::afficherVue(
            'vueGenerale.php',
            [
                "trajets" => $trajets,
                "titre" => "Trajet modifié",
                "cheminCorpsVue" => "trajet/trajetMisAJour.php"
            ]
        );
    }
}
?>