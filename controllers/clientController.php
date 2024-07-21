<?php
class ClientController {
    private $clientModel;
    private $db; 

    public function __construct($clientModel, $database) {
        $this->clientModel = $clientModel;
        $this->db = $database; 
    }

    public function handleClient($data) {
        $client = $this->clientModel->findClientByEmail($data['email']);
        if (!$client) {
            return $this->clientModel->addClient($data['prenom'], $data['nom'], $data['adresse'], $data['telephone'], $data['email'], $data['sexe']);
        }
        return $client['id_client']; 
    }

    public function handleCommande($clientId, $totalPrice) {
        $query = "INSERT INTO commandes (id_client, total_price, statut) VALUES (?, ?, 'en attente')";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$clientId, $totalPrice]);

        if ($stmt->rowCount() > 0) {
            return $this->db->lastInsertId();
        } else {
            return false; 
        }
    }
}
?>
