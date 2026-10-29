<?php

namespace App\Covoiturage\Modele\Repository;

use App\Covoiturage\Modele\DataObject\AbstractDataObject;
use App\Covoiturage\Modele\DataObject\Utilisateur;

/**
 * @extends AbstractRepository<Utilisateur>
 */
class UtilisateurRepository extends AbstractRepository
{
    protected function getNomTable(): string
    {
        return "utilisateur";
    }

    protected function getNomClePrimaire(): string
    {
        return "loginBaseDeDonnees";
    }

    /** @return string[] */
    protected function getNomsColonnes(): array
    {
        return [
            "loginBaseDeDonnees",
            "nomBaseDeDonnees",
            "prenomBaseDeDonnees"
        ];
    }

    /**
     * @param AbstractDataObject $objet
     */
    protected function formatTableauSQL(AbstractDataObject $objet): array
    {
        /** @var Utilisateur $utilisateur */
        $utilisateur = $objet;

        return [
            "loginTag" => $utilisateur->getLogin(),
            "nomTag" => $utilisateur->getNom(),
            "prenomTag" => $utilisateur->getPrenom(),
        ];
    }

    /**
     * @return Utilisateur
     */
    protected function construireDepuisTableauSQL(
        array $objetFormatTableau
    ): Utilisateur {
        return new Utilisateur(
            $objetFormatTableau['loginBaseDeDonnees'],
            $objetFormatTableau['nomBaseDeDonnees'],
            $objetFormatTableau['prenomBaseDeDonnees']
        );
    }

    /**
     * @return Trajet[]
     */
    public static function recupererTrajetsCommePassager(
        Utilisateur $utilisateur
    ): array {
        $sql = "SELECT trajet.id
                FROM trajet
                JOIN passager ON trajet.id = passager.trajetId
                WHERE passager.utilisateurLogin = :loginTag";

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $pdoStatement->execute([
            "loginTag" => $utilisateur->getLogin()
        ]);

        $trajets = [];
        $trajetRepository = new TrajetRepository();

        foreach ($pdoStatement as $trajetFormatTableau) {
            $trajet = $trajetRepository->recupererParClePrimaire(
                (string) $trajetFormatTableau['id']
            );

            if ($trajet !== null) {
                $trajets[] = $trajet;
            }
        }

        return $trajets;
    }
}
?>