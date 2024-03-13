<?php 

class CitationManager extends Manager {

    public function create($citation) {

        if ($this -> exists($citation)){
            throw new InvalidArgumentException("La citation existe déjà dans le tableau.");
        }

        $sql = "INSERT INTO citation (citation_texte, citation_date, auteur_id) VALUES (:citationText, :citationDate, :authorId)";

        try {
            $stmt = $this->pdo->prepare($sql);

            $citationText = $citation ->getTexte();
            $citationDate = $citation->getDate()->format("Y-m-d");
            $authorId = $citation->getAuteur()->getId();

            // Binding parameters to prevent SQL injection.
            $stmt->bindParam(':citationText', $citationText, PDO::PARAM_STR);
            $stmt->bindParam(':citationDate', $citationDate, PDO::PARAM_STR);
            $stmt->bindParam(':authorId', $authorId, PDO::PARAM_INT);
            
            return $stmt->execute();
        } catch (PDOException $e) {
            die("Erreur lors de l'insertion de la citation: " . $e->getMessage());
        }
    }

    protected function read($id): Citation {
        $sql = "SELECT * FROM citation WHERE citation_id = :id";
    
        try {
            $stmt = $this->pdo->prepare($sql);
    
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
            $stmt->execute();
    
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $this -> generateObjectFromArray($data);

        } catch (PDOException $e) {
            die("Erreur lors de la lecture de la citation: " . $e->getMessage());
        }
    }

    protected function update($citation) {
        // Implement update logic for Citation
    }

    protected function delete($id) {
        // Implement delete logic for Citation
    }

    public function readAll(bool $sort = false, int $limit = 5, $auteurId = null): array
    {
        try {
            // Récupère toutes les citations
            // Base SQL query
            $sqlCitations = "SELECT * FROM citation";

            // Check if a limit is set
            if (isset($auteurId) && is_numeric($auteurId) && $auteurId > 0) {
                $sqlCitations .= " WHERE auteur_id = " . intval($auteurId);
            }

            // Check if sorting is required
            if (isset($sort) && $sort === true) {
                $sqlCitations .= " ORDER BY creationDate DESC";
            }

            // Check if a limit is set
            if (isset($limit) && is_numeric($limit) && $limit > 0) {
                $sqlCitations .= " LIMIT " . intval($limit);
            }

            $stmtCitations = $this->pdo->query($sqlCitations);
            $list_citations = $stmtCitations->fetchAll(PDO::FETCH_ASSOC);

            $citations = [];

            foreach ($list_citations as $row) {
                $citations[] = $this -> generateObjectFromArray($row);
            }

            return $citations;
        } catch (PDOException $e) {
            die("Erreur lors de la récupération des données Citation: " . $e->getMessage());
        }
    }
    
    protected function generateObjectFromArray(array $data): object
    {
        $auteur_manager = new AuteurManager();
        $auteur = $auteur_manager -> read(intval($data["auteur_id"]));

        $citation = new Citation(
            $data['citation_texte'],
            new DateTime($data['citation_date']),
            $auteur);

        $citation -> setId($data['citation_id']);
        $citation -> setCreatedAt(new Datetime($data['creationDate']));
        return $citation;
    }

    public function exists(Object $citation): int {
        
        $sql = "SELECT COUNT(*) FROM citation WHERE citation_texte = :citationTexte";
    
        try {
            $stmt = $this->pdo->prepare($sql);
            
            $citationTexte = $citation->getTexte();
            $stmt->bindParam(':citationTexte', $citationTexte, PDO::PARAM_STR);
            
            $stmt->execute();
    
            $count = $stmt->fetchColumn();
            return $count > 0;

        } catch (PDOException $e) {
            die("Erreur lors de la vérification de l'existence de la citation: " . $e->getMessage());
        }
    }

    public function readFromAttributes(object $auteur): Object {

        if (!$auteur instanceof Auteur) {
            throw new InvalidArgumentException('Object must be of type Auteur.');
        }
        
        $sql = "SELECT * FROM auteur WHERE nom = :nom and prenom = :prenom and anneeNaissance = :anneeNaissance";
    
        try {
            $stmt = $this->pdo->prepare($sql);
            
            $stmt->bindParam(':nom', $auteur ->getNom(), PDO::PARAM_STR);
            $stmt->bindParam(':prenom', $auteur->getPrenon(), PDO::PARAM_STR);
            $stmt->bindParam(':anneeNaissance', $auteur->getAnneeNaissance(), PDO::PARAM_INT);

            $stmt->execute();
    
            $data = $stmt->fetchColumn();
            
            return $this->generateObjectFromArray($data);

        } catch (PDOException $e) {
            die("Erreur lors de la vérification de l'existence de l'auteur: " . $e->getMessage());
        }
    }
    
}
