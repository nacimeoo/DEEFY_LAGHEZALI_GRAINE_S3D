<?php
declare(strict_types=1);

namespace iutnc\deefy\audio\tracks;



class Piste extends AudioTrack
{
    protected string $auteur;
    protected int $date; 

    public function __construct(string $titre, string $auteur, int $duree, string $chemin)
    {
        parent::__construct($titre, $chemin);
        $this->setDuree($duree);
        $this->setAuteur($auteur);
    }

    public function setAuteur(string $auteur): void {
        $this->auteur = $auteur;
    }

    public function setDate(int $date): void {
        $this->date = $date;
    }

    public function __toString(): string
    {
        return json_encode(get_object_vars($this));
    }
}
