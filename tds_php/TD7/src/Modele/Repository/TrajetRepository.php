<?php

namespace App\Covoiturage\Modele\Repository;

use App\Covoiturage\Modele\DataObject\AbstractDataObject;
use App\Covoiturage\Modele\DataObject\Utilisateur;
use App\Covoiturage\Modele\DataObject\Trajet;
use DateTime;

/**
 * @extends AbstractRepository<Trajet>
 */
class TrajetRepository extends AbstractRepository
{
    protected function getNomTable(): string
    {
        return "trajet";
    }

    protected function getNomClePrimaire(): string
    {
        return "id";
    }

    protected function getNomsColonnes(): array
    {
        return [
            "id",
            "depart",
            "arrivee",
            "date",
            "prix",
            "conducteurLogin",
            "nonFumeur"
        ];
    }

    protected function formatTableauSQL(AbstractDataObject $objet): array
    {
        /** @var Trajet $trajet */
        $trajet = $objet;

        return [
            "idTag" => $trajet->getId(),
            "departTag" => $trajet->getDepart(),
            "arriveeTag" => $trajet->getArrivee(),
            "dateTag" => $trajet->getDate()->format("Y-m-d"),
            "prixTag" => $trajet->getPrix(),
            "conducteurLoginTag" => $trajet->getConducteur()->getLogin(),
            "nonFumeurTag" => (int) $trajet->isNonFumeur()
        ];
    }

    /**
     * @return Trajet
     */
    protected function construireDepuisTableauSQL(
        array $objetFormatTableau
    ): Trajet {
        $date = new DateTime($objetFormatTableau['date']);

        $utilisateur = (new UtilisateurRepository())
            ->recupererParClePrimaire(
                $objetFormatTableau["conducteurLogin"]
            );

        $trajet = new Trajet(
            $objetFormatTableau["id"],
            $objetFormatTableau["depart"],
            $objetFormatTableau["arrivee"],
            $date,
            $objetFormatTableau["prix"],
            $utilisateur,
            $objetFormatTableau["nonFumeur"]
        );

        $trajet->setPassagers(self::recupererPassagers($trajet));

        return $trajet;
    }

    /**
     * @return Utilisateur[]
     */
    private static function recupererPassagers(Trajet $trajet): array
    {
        $sql = "SELECT u.loginBaseDeDonnees
                FROM passager p
                INNER JOIN utilisateur u
                    ON p.passagerLogin = u.loginBaseDeDonnees
                WHERE p.trajetId = :trajetIdTag";

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $pdoStatement->execute([
            "trajetIdTag" => $trajet->getId()
        ]);

        $passagers = [];
        $utilisateurRepository = new UtilisateurRepository();

        foreach ($pdoStatement as $passagerTableau) {
            $passager = $utilisateurRepository->recupererParClePrimaire(
                $passagerTableau["loginBaseDeDonnees"]
            );

            if ($passager !== null) {
                $passagers[] = $passager;
            }
        }

        return $passagers;
    }
}