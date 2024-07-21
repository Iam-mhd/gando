<?php

class UserModel {
    private $database;

    public function __construct($database) {
        $this->database = $database;
    }

    public function getUserById($id) {
        $query = "SELECT * FROM users WHERE id_user = :id";
        $stmt = $this->database->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllUsers() {
        $query = $this->database->prepare("SELECT * FROM users");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createUser($data) {
        $query = $this->database->prepare("INSERT INTO users (prenom, nom, telephone, email, mot_de_passe) VALUES (:prenom, :nom, :telephone, :email, :mot_de_passe)");
        return $query->execute([
            ':prenom' => $data['prenom'],
            ':nom' => $data['nom'],
            ':telephone' => $data['telephone'],
            ':email' => $data['email'],
            ':mot_de_passe' => $data['mot_de_passe']
        ]);
    }

    public function updateUser($id, $data) {
        $query = $this->database->prepare("UPDATE users SET prenom = :prenom, nom = :nom, telephone = :telephone, email = :email WHERE id_user = :id");
        return $query->execute([
            ':prenom' => $data['prenom'],
            ':nom' => $data['nom'],
            ':telephone' => $data['telephone'],
            ':email' => $data['email'],
            ':id' => $id
        ]);
    }

    public function deleteUser($id) {
        $query = $this->database->prepare("DELETE FROM users WHERE id_user = :id");
        return $query->execute([':id' => $id]);
    }
}
?>