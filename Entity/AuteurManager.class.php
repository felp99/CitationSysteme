<?php 

class AuteurManager extends Manager {
    public function create(object $auteur):int
    {
        if (!$auteur instanceof Auteur) {
            throw new InvalidArgumentException('Object must be of type Auteur.');
        }

        $sql = "INSERT INTO auteur (nom, prenom, anneeNaissance) VALUES (:nom, :prenom, :anneeNaissance)";

        try {
            $stmt = $this->pdo->prepare($sql);

            $nom = $auteur -> getNom();
            $prenom = $auteur-> getPrenon();
            $anneeNaissance = $auteur -> getAnneeNaissance();

            // Binding parameters to prevent SQL injection.
            $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $stmt->bindParam(':anneeNaissance', $anneeNaissance, PDO::PARAM_INT);
            
            $stmt->execute();
        } catch (PDOException $e) {
            die("Erreur lors de l'insertion du auteur: " . $e->getMessage());
        }

        return $this->pdo -> lastInsertId();
    }

    public function read($id) : Auteur
    {
        $sql = "SELECT * FROM auteur WHERE auteur_id = :id";
    
        try {
            $stmt = $this->pdo->prepare($sql);
    
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
            $stmt->execute();
    
            $auteurData = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $this -> generateObjectFromArray($auteurData);

        } catch (PDOException $e) {
            die("Erreur lors de la lecture du auteur: " . $e->getMessage());
        }
    }
    

    protected function update($auteur) {
        // Implement update logic for Auteur
    }

    protected function delete($id) {
        // Implement delete logic for Auteur
    }

    public function readAll():array{
        try {
            // Récupère toutes les citations
            $sqlAuteurs = "SELECT * FROM auteur";
            $stmtAuteurs = $this->pdo->query($sqlAuteurs);
            $list_auteurs = $stmtAuteurs->fetchAll(PDO::FETCH_ASSOC);

            $auteurs = [];
            foreach ($list_auteurs as $row) {
                $auteurs[] = $this ->generateObjectFromArray($row);
            }
            return $auteurs;
        } catch (PDOException $e) {
            die("Erreur lors de la récupération des données Auteurs: " . $e->getMessage());
        }
    }

    protected function generateObjectFromArray(array $auteurData):Auteur{

        $auteur = new Auteur(
            $auteurData['prenom'], 
            $auteurData['nom'], 
            $auteurData['anneeNaissance']);

        $auteur -> setId($auteurData['auteur_id']);

        return $auteur;

    }

    public function exists(object $auteur): int {

        if (!$auteur instanceof Auteur) {
            throw new InvalidArgumentException('Object must be of type Auteur.');
        }
        
        $sql = "SELECT COUNT(*) FROM auteur WHERE nom = :nom and prenom = :prenom and anneeNaissance = :anneeNaissance";
    
        try {
            $stmt = $this->pdo->prepare($sql);

            $nom = $auteur -> getNom();
            $prenom = $auteur-> getPrenon();
            $anneeNaissance = $auteur -> getAnneeNaissance();
            
            $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $stmt->bindParam(':anneeNaissance', $anneeNaissance, PDO::PARAM_INT);

            $stmt->execute();
    
            $count = $stmt->fetchColumn();
            return $count > 0;

        } catch (PDOException $e) {
            die("Erreur lors de la vérification de l'existence de l'auteur: " . $e->getMessage());
        }
    }

    public function readFromAttributes(object $auteur): Object {

        if (!$auteur instanceof Auteur) {
            throw new InvalidArgumentException('Object must be of type Auteur.');
        }
        
        $sql = "SELECT * FROM auteur WHERE nom = :nom and prenom = :prenom and anneeNaissance = :anneeNaissance";
    
        try {
            $stmt = $this->pdo->prepare($sql);

            $nom = $auteur -> getNom();
            $prenom = $auteur-> getPrenon();
            $anneeNaissance = $auteur -> getAnneeNaissance();
            
            $stmt->bindParam(':nom', $nom, PDO::PARAM_STR);
            $stmt->bindParam(':prenom', $prenom, PDO::PARAM_STR);
            $stmt->bindParam(':anneeNaissance', $anneeNaissance, PDO::PARAM_INT);

            $stmt->execute();
    
            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            return $this->generateObjectFromArray($data);

        } catch (PDOException $e) {
            die("Erreur lors de la vérification de l'existence de l'auteur: " . $e->getMessage());
        }
    }
}
