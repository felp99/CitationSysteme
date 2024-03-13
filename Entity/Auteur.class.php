<?php 
declare(strict_types=1);

class Auteur extends GeneralObject {
    private string $nom;
    private string $prenom;
    private int $anneeNaissance;
    private array $citations = [];

    public function __construct(string $prenom, string $nom, int $anneeNaissance) {
        // Valider le prénom
        if (!is_string($prenom) || empty(trim($prenom))) {
            throw new InvalidArgumentException("Le prénom doit être une chaîne non vide.");
        }
        $this->prenom = $prenom;

        // Valider le nom
        if (!is_string($nom) || empty(trim($nom))) {
            throw new InvalidArgumentException("Le nom doit être une chaîne non vide.");
        }
        $this->nom = $nom;

        // Valider l'année de naissance
        if (!is_numeric($anneeNaissance) || $anneeNaissance > date("Y") || $anneeNaissance <= 0) {
            throw new InvalidArgumentException("L'année de naissance doit être une année valide.");
        }
        $this->anneeNaissance = $anneeNaissance;
    }

    public function getNomComplet() {
        return $this->prenom . " " . $this->nom . " " . $this->anneeNaissance;
    }

    public function getNom(){
        return $this -> nom;
    }

    public function getPrenon(){
        return $this -> prenom;
    }
    public function getCitations() {

        $citation_manager = new CitationManager();

        $this -> citations = $citation_manager -> readAll(false, -1, $this -> getId());

        return $this->citations;
    }
    

    public function getAnneeNaissance(){
        return $this->anneeNaissance;
    }
}
