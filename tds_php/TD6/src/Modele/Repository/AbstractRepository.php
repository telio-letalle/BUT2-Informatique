<?php

namespace App\Covoiturage\Modele\Repository;

use App\Covoiturage\Modele\DataObject\AbstractDataObject;
use App\Covoiturage\Modele\DataObject\Utilisateur;

/**
 * @template T of AbstractDataObject
 */
abstract class AbstractRepository
{
    protected abstract function getNomTable(): string;

    protected abstract function getNomClePrimaire(): string;

    /** @return string[] */
    protected abstract function getNomsColonnes(): array;

    /** @param T $objet */
    protected abstract function formatTableauSQL(AbstractDataObject $objet): array;

    /**
     * @param T $objet
     */
    public function ajouter(AbstractDataObject $objet): bool
    {
        $nomsColonnes = $this->getNomsColonnes();
        $tableauSQL = $this->formatTableauSQL($objet);

        $colonnes = join(", ", $nomsColonnes);
        $parametres = join(
            ", ",
            array_map(
                fn($nomParametre) => ":" . $nomParametre,
                array_keys($tableauSQL)
            )
        );

        $sql = "INSERT INTO " . $this->getNomTable()
            . " (" . $colonnes . ")"
            . " VALUES (" . $parametres . ")";

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        return $pdoStatement->execute($tableauSQL);
    }

    /**
     * @param T $objet
     */
    public function mettreAJour(AbstractDataObject $objet): void
    {
        $nomsColonnes = $this->getNomsColonnes();
        $tableauSQL = $this->formatTableauSQL($objet);
        $nomsParametres = array_keys($tableauSQL);

        $indexClePrimaire = array_search(
            $this->getNomClePrimaire(),
            $nomsColonnes,
            true
        );

        $conditionsMiseAJour = [];

        foreach ($nomsColonnes as $index => $nomColonne) {
            $conditionsMiseAJour[] = $nomColonne
                . " = :" . $nomsParametres[$index];
        }

        $sql = "UPDATE " . $this->getNomTable()
            . " SET " . join(", ", $conditionsMiseAJour)
            . " WHERE " . $this->getNomClePrimaire()
            . " = :" . $nomsParametres[$indexClePrimaire];

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $pdoStatement->execute($tableauSQL);
    }

    public function supprimer(string $valeurClePrimaire): void
    {
        $sql = "DELETE FROM " . $this->getNomTable()
            . " WHERE " . $this->getNomClePrimaire()
            . " = :valeurClePrimaireTag";

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $pdoStatement->execute([
            "valeurClePrimaireTag" => $valeurClePrimaire
        ]);
    }

    /**
     * @return T
     */
    protected abstract function construireDepuisTableauSQL(array $objetFormatTableau): AbstractDataObject;

    /**
     * @return T[]
     */
    public function recuperer(): array
    {
        $sql = "SELECT * FROM " . $this->getNomTable();

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->query($sql);

        $objets = [];

        foreach ($pdoStatement as $objetFormatTableau) {
            $objets[] = $this->construireDepuisTableauSQL(
                $objetFormatTableau
            );
        }

        return $objets;
    }

    /**
     * @return T|null
     */
    public function recupererParClePrimaire(
        string $clePrimaire
    ): ?AbstractDataObject {
        $sql = "SELECT * FROM " . $this->getNomTable()
            . " WHERE " . $this->getNomClePrimaire()
            . " = :clePrimaireTag";

        $pdoStatement = ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $pdoStatement->execute([
            "clePrimaireTag" => $clePrimaire
        ]);

        $objetFormatTableau = $pdoStatement->fetch();

        if ($objetFormatTableau !== false) {
            return $this->construireDepuisTableauSQL(
                $objetFormatTableau
            );
        }

        return null;
    }
}
?>