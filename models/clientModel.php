<?php
class ClientModel {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

public function getCommandesEnAttenteAvecClients() {
    $query = "SELECT c.*, cl.nom, cl.adresse, cl.telephone FROM commandes c 
              LEFT JOIN clients cl ON c.id_user = cl.id_client 
              WHERE c.statut = 'en attente'";
    $result = $this->database->query($query);
    return $result->fetchAll(PDO::FETCH_ASSOC);
}

    public function addClient($prenom, $nom, $adresse, $telephone, $email, $sexe) {
        $query = "INSERT INTO clients (nom, prenom, adresse, telephone, email, sexe) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$nom, $prenom, $adresse, $telephone, $email, $sexe]);
        return $this->db->lastInsertId();
    }

    public function findClientByEmail($email) {
        $query = "SELECT * FROM clients WHERE email = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
