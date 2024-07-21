<?php

class UserController {
    private $model; // Assurez-vous que vous utilisez ce nom partout dans la classe

    public function __construct($model) {
        $this->model = $model;
    }

    public function showUser($id) {
        $user = $this->model->getUserById($id);
        if ($user) {
            include __DIR__ . '/../views/userview.php'; // Utilisation d'un chemin absolu
        } else {
            echo "ERREUR";
        }
    }

    public function showAllUsers() {
        $users = $this->model->getAllUsers();
        include __DIR__ . '/../views/userview.php'; // Utilisation d'un chemin absolu
    }

    public function createUser($data) {
        if (!empty($data['prenom']) && !empty($data['email'])) {
            if ($this->model->createUser($data)) {
                $this->showAllUsers();
            } else {
                echo "Une erreur s'est produite";
            }
        }
    }

    public function updateUser($id, $data) {
        if ($this->model->updateUser($id, $data)) {
            $this->showAllUsers();
        } else {
            echo "Erreur lors de la mise à jour de l'utilisateur.";
        }
    }

    public function deleteUserById($id) {
        return $this->model->deleteUser($id); // Utilisez $this->model au lieu de $this->userModel
    }
}
?>
