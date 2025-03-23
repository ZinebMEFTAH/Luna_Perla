<?php
namespace bd;

use \PDO;
require('../class/Produit_lp.php');
require('GestionBD.php');

use bd\GestionBD;

class Produit_lp {

    public function saveProduit($produit) {
        $BD = new GestionBD();
        $BD->connexion();

        $sql = "INSERT INTO produit_lp (base_id, collection_id, specific_name, prix, stock, image, availability) 
                VALUES (:base_id, :collection_id, :specific_name, :prix, :stock, :image, :availability)";
        $stmt = $BD->pdo->prepare($sql);
        $result = $stmt->execute([
            ':base_id' => $produit->base_id,
            ':collection_id' => $produit->collection_id,
            ':specific_name' => $produit->specific_name,
            ':prix' => $produit->prix,
            ':stock' => $produit->stock,
            ':image' => $produit->image,
            ':availability' => $produit->availability
        ]);

        $BD->deconnexion();
        return $result;
    }

    public function updateProduit($produit) {
        $BD = new GestionBD();
        $BD->connexion();

        $sql = "UPDATE produit_lp SET specific_name = :specific_name, prix = :prix, stock = :stock, image = :image, availability = :availability
                WHERE id = :produit_id";
        $stmt = $BD->pdo->prepare($sql);
        $result = $stmt->execute([
            ':specific_name' => $produit->specific_name,
            ':prix' => $produit->prix,
            ':stock' => $produit->stock,
            ':image' => $produit->image,
            ':availability' => $produit->availability,
            ':produit_id' => $produit->id
        ]);

        $BD->deconnexion();
        return $result;
    }


    public function deleteProduit($produit_id) {
        $BD = new GestionBD();
        $BD->connexion();

        $sql = "DELETE FROM produit_lp WHERE id = :produit_id";
        $stmt = $BD->pdo->prepare($sql);
        $result = $stmt->execute([':produit_id' => $produit_id]);

        $BD->deconnexion();
        return $result;
    }

    public function listProduits() {
        $BD = new GestionBD();
        $BD->connexion();

        $sql = "SELECT p.id, p.specific_name, p.prix, p.stock, p.image, c.collection_name 
                FROM produit_lp p 
                LEFT JOIN collection_lp c ON p.collection_id = c.id";
        $stat = $BD->pdo->prepare($sql);
        $stat->execute();
        $produits = $stat->fetchAll(PDO::FETCH_ASSOC);

        $BD->deconnexion();
        return $produits;
    }

    public function getProduitById($produit_id) {
        $BD = new GestionBD();
        $BD->connexion();

        $sql = "SELECT p.id, p.specific_name, p.prix, p.stock, p.image, c.collection_name 
                FROM produit_lp p 
                LEFT JOIN collection_lp c ON p.collection_id = c.id 
                WHERE p.id = :produit_id";
        $stat = $BD->pdo->prepare($sql);
        $stat->bindParam(':produit_id', $produit_id);
        $stat->execute();
        $produit = $stat->fetch(PDO::FETCH_ASSOC);

        $BD->deconnexion();
        return $produit;
    }
}
?>