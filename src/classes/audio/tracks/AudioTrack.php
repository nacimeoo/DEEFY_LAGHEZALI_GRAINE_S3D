<?php
declare(strict_types=1);

namespace iutnc\deefy\audio\tracks;


use iutnc\deefy\exception\InvalidPropertyNameException;
use iutnc\deefy\exception\InvalidPropertyValueException;

class AudioTrack
{
    protected string $titre;
    protected string $genre;
    protected int $duree = 0;
    protected string $chemin;

    public function __construct(string $titre, string $chemin)
    {
        $this->titre = $titre;
        $this->chemin = $chemin;
    }

    public function __get(string $name)
    {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        throw new InvalidPropertyNameException("invalid property : $name");
    }

    public function setGenre(string $genre): void {
        $this->genre = $genre;
    }

    public function setDuree(int $duree): void {
        if ($duree < 0) {
            throw new InvalidPropertyValueException("invalid property value for duree : $duree");
        }
        $this->duree = $duree;
    }

    public function __toString(): string
    {
        return json_encode(get_object_vars($this));
    }
}
