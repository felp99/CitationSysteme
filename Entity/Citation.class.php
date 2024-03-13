<?php

declare(strict_types=1);

class Citation extends GeneralObject
{
    private String $texte; // Déclaration de la propriété texte, qui doit être une chaîne de caractères
    private Datetime $date; // Déclaration de la propriété date, qui doit être un objet Datetime
    private Auteur $auteur; // Déclaration de la propriété auteur, qui doit être un objet de la classe Auteur

    public function __construct(
        string $texte, 
        Datetime $date, 
        Auteur $auteur)
    {
        // Vérifie que texte est une chaîne non vide
        if (!is_string($texte) || trim($texte) === '') {
            throw new InvalidArgumentException("Le texte de la citation doit être une chaîne non vide.");
        }
        $this->texte = $texte;
        
        // Vérifier la date de la prestation
        if ($date > new DateTime()) {
            throw new InvalidArgumentException("La date de la citation doit être antérieure ou égale à la date du jour.");
        }
        $this->date = $date;
        
        // Vérifie si l'année de naissance de l'auteur est postérieure à l'année de la citation
        if ($auteur->getAnneeNaissance() >= $date->format('Y')) {
            throw new InvalidArgumentException("La date de naissance de l'auteur est supérieure ou égale à la date de la citation.");
        }
        $this->auteur = $auteur;
    }   

    public function getTexte(): string
    {
        return trim($this->texte);
    }

    public function getDate(): DateTime
    {
        return $this->date;
    }

    public function getAuteur(): Auteur
    {
        return $this->auteur; 
    }
}
