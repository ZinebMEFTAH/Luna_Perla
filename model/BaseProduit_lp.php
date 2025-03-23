<?php
namespace bd;

use \PDO;
require('../class/BaseProduit_lp.php');
require('GestionBD.php');

use bd\GestionBD;

class BaseProduit_lp {

    /**
     * Save a new base product (Insert into `base_produit_lp`)
     */
    public function saveBaseProduit($baseProduit) {
        $BD = new GestionBD();
        $BD->connexion();

        $sql = "INSERT INTO base_produit_lp (name, multicolor, description) VALUES (:name, :multicolor, :description)";
        $stmt = $BD->pdo->prepare($sql);
        $result = $stmt->execute([
            ':name' => $baseProduit->name,
            ':multicolor' => $baseProduit->multicolor,
            ':description' => $baseProduit->description
        ]);

        $BD->deconnexion();
        return $result;
    }

    /**
     * Update an existing base product
     */
    public function updateBaseProduit($baseProduit) {
        $BD = new GestionBD();
        $BD->connexion();

        $sql = "UPDATE base_produit_lp SET name = :name, multicolor = :multicolor, description = :description WHERE id = :id";
        $stmt = $BD->pdo->prepare($sql);
        $result = $stmt->execute([
            ':name' => $baseProduit->name,
            ':multicolor' => $baseProduit->multicolor,
            ':description' => $baseProduit->description,
            ':id' => $baseProduit->id
        ]);

        $BD->deconnexion();
        return $result;
    }

    /**
     * Delete a base product by ID
     */
    public function deleteBaseProduit($baseProduit_id) {
        $BD = new GestionBD();
        $BD->connexion();

        $sql = "DELETE FROM base_produit_lp WHERE id = :baseProduit_id";
        $stmt = $BD->pdo->prepare($sql);
        $result = $stmt->execute([':baseProduit_id' => $baseProduit_id]);

        $BD->deconnexion();
        return $result;
    }

    /**
     * Get all base products
     */
    public function listBaseProduits() {
        $BD = new GestionBD();
        $BD->connexion();

        $sql = "SELECT * FROM base_produit_lp";
        $stat = $BD->pdo->prepare($sql);
        $stat->execute();
        $baseProduits = $stat->fetchAll(PDO::FETCH_ASSOC);

        $BD->deconnexion();
        return $baseProduits;
    }

    /**
     * Get a single base product by ID
     */
    public function getBaseProduitById($baseProduit_id) {
        $BD = new GestionBD();
        $BD->connexion();

        $sql = "SELECT * FROM base_produit_lp WHERE id = :baseProduit_id";
        $stat = $BD->pdo->prepare($sql);
        $stat->bindParam(':baseProduit_id', $baseProduit_id);
        $stat->execute();
        $baseProduit = $stat->fetch(PDO::FETCH_ASSOC);

        $BD->deconnexion();
        return $baseProduit;
    }
}
?>