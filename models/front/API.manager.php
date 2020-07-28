<?php

require_once 'models/Model.php';

class APIManager extends Model
{
    public function getDBAnimaux()
    {
        $req = " SELECT * 
            FROM animal a INNER JOIN famille f ON f.famille_id = a.famille_id
            INNER JOIN animal_continent ac ON ac.animal_id = a.animal_id
            INNER JOIN continent c ON c.continent_id = ac.continent_id
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $animaux = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $animaux;
    }

    public function getDBAnimal($idAnimal)
    {
        $req = " SELECT * 
            FROM animal a INNER JOIN famille f ON f.famille_id = a.famille_id
            INNER JOIN animal_continent ac ON ac.animal_id = a.animal_id
            INNER JOIN continent c ON c.continent_id = ac.continent_id
            WHERE a.animal_id = :idAnimal
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->bindValue(":idAnimal", $idAnimal, PDO::PARAM_INT);
        $stmt->execute();
        $lignesAnimal = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $lignesAnimal;
    }

    public function getDBFamilles()
    {
        $req = " SELECT * 
        FROM famille
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $familles = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $familles;
    }

    public function getDBContinents()
    {
        $req = " SELECT * 
        FROM continent
        ";
        $stmt = $this->getBdd()->prepare($req);
        $stmt->execute();
        $continents = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $stmt->closeCursor();
        return $continents;
    }
}