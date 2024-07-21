<?php
class CommandeController {
    private $commandeModel;

    public function __construct($commandeModel) {
        $this->commandeModel = $commandeModel;
    }

    public function getCommandesEnAttente() {
        return $this->commandeModel->getCommandesEnAttente();
    }

    public function validerCommande($idCommande) {
        $this->commandeModel->validerCommande($idCommande);
    }

    public function creerCommande($prenom, $nom, $adresse, $telephone, $totalPrice) {
        return $this->commandeModel->creerCommande($prenom, $nom, $adresse, $telephone, $totalPrice);
    }
}
?>
