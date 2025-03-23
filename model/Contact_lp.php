<?php
namespace bd;

use \PDO;
require('../class/Contact_lp.php');
require('GestionBD.php');

use bd\GestionBD;

class Contact_lp {

    /**
     * Save a new contact message (Insert into `contact_lp`)
     */
    public function saveContact($contact) {
        $BD = new GestionBD();
        $BD->connexion();

        $sql = "INSERT INTO contact_lp (user_id, sujet, message) VALUES (:user_id, :sujet, :message)";
        $stmt = $BD->pdo->prepare($sql);
        $result = $stmt->execute([
            ':user_id' => $contact->user_id,
            ':sujet' => $contact->sujet,
            ':message' => $contact->message
        ]);

        $BD->deconnexion();
        return $result;
    }

    /**
     * Update an existing contact message
     */
    public function updateContact($contact) {
        $BD = new GestionBD();
        $BD->connexion();

        $sql = "UPDATE contact_lp SET sujet = :sujet, message = :message WHERE id = :id";
        $stmt = $BD->pdo->prepare($sql);
        $result = $stmt->execute([
            ':sujet' => $contact->sujet,
            ':message' => $contact->message,
            ':id' => $contact->id
        ]);

        $BD->deconnexion();
        return $result;
    }

    /**
     * Delete a contact message by ID
     */
    public function deleteContact($contact_id) {
        $BD = new GestionBD();
        $BD->connexion();

        $sql = "DELETE FROM contact_lp WHERE id = :contact_id";
        $stmt = $BD->pdo->prepare($sql);
        $result = $stmt->execute([':contact_id' => $contact_id]);

        $BD->deconnexion();
        return $result;
    }

    /**
     * Get all contact messages
     */
    public function listContacts() {
        $BD = new GestionBD();
        $BD->connexion();

        $sql = "SELECT c.id, c.sujet, c.message, c.date_envoi, u.username, u.email 
                FROM contact_lp c
                JOIN user_lp u ON c.user_id = u.user_id";
        $stat = $BD->pdo->prepare($sql);
        $stat->execute();
        $contacts = $stat->fetchAll(PDO::FETCH_ASSOC);

        $BD->deconnexion();
        return $contacts;
    }

    /**
     * Get a single contact message by ID
     */
    public function getContactById($contact_id) {
        $BD = new GestionBD();
        $BD->connexion();

        $sql = "SELECT c.id, c.sujet, c.message, c.date_envoi, u.username, u.email 
                FROM contact_lp c
                JOIN user_lp u ON c.user_id = u.user_id
                WHERE c.id = :contact_id";
        $stat = $BD->pdo->prepare($sql);
        $stat->bindParam(':contact_id', $contact_id);
        $stat->execute();
        $contact = $stat->fetch(PDO::FETCH_ASSOC);

        $BD->deconnexion();
        return $contact;
    }
}
?>