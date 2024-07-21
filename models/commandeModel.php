<?php
class CommandeModel {
    private $db;

    public function __construct($database) {
        $this->db = $database;
    }

    public function getCommandesEnAttente() {
        $query = "SELECT * FROM commandes WHERE statut = 'en attente'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function validerCommande($commandeId) {
        $query = "UPDATE commandes SET statut = 'validée' WHERE id_commande = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$commandeId]);
    }

    public function creerCommande($prenom, $nom, $adresse, $telephone, $totalPrice) {
        $query = "INSERT INTO commandes (prenom_client, nom_client, adresse_client, telephone_client, total_price, status) VALUES (?, ?, ?, ?, ?, 'en attente')";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$prenom, $nom, $adresse, $telephone, $totalPrice]);
        return $this->db->lastInsertId();
    }
}
?>
