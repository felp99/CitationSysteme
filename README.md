# Système de Gestion des Auteurs et des Citations

## Vue d'ensemble

Projet développé pour étudier la PHP brute.

### Pour installer la base de données :

Changez la variable `$new_database` par le nom que vous voulez donner à votre nouvelle base de données.

Après avoir accédé à l'adresse, le script générera une nouvelle base de données sans données.

Accéder au fichier `config/init.php` à l'adresse http://localhost:8888/citationSysteme/config/init.php.


### UML

```mermaid
classDiagram
      class Manager {
        <<abstract>>
          #create(Object)
          #read(int)
          #readFromAttributes
          #update(Object)
          #delete(ind)
          #readAll():[]
          #generateObjectFromArray([]):Object[]
          #exists(Object):int
          -connectDB()
      }
      class AuteurManager {
      }
      class CitationManager {
      }

      class Object {
        <<abstract>>
          -id: int
          -createdAt: datetime
          -updatedAt: datetime
          +validate()
      }
      class Auteur {
          -nom: string
          -prenom: string
          -anneeNaissance: int
      }
      class Citation {
          -texte: string
          -date: datetime
          -auteurId: int
      }

      Object <|-- Auteur
      Object <|-- Citation

      Manager <|-- AuteurManager
      Manager <|-- CitationManager

      AuteurManager "1" --> "*" Auteur
      CitationManager "1" --> "*" Citation

      Auteur "1" --> "*" Citation

    
```

## Licence

Ce projet est sous licence MIT.
