<?php
declare(strict_types=1);

namespace iutnc\deefy\audio\lists;

use iutnc\deefy\audio\tracks\AudioTrack;


class Playlist extends AudioList {

    public function __construct(string $nom, array $pistes = []) {
        parent::__construct($nom, $pistes);
    }

    public function ajouterPiste(AudioTrack $piste): void {
        $this->pistes[] = $piste;
        $this->nombrePistes = count($this->pistes);
        $this->dureeTotale += $piste->duree;
    }

    public function supprimerPiste(int $index): void {
        if (isset($this->pistes[$index])) {
            $this->dureeTotale -= $this->pistes[$index]->duree;
            unset($this->pistes[$index]);
            $this->pistes = array_values($this->pistes); 
            $this->nombrePistes = count($this->pistes);
        }
    }

    public function ajouterPistes(array $pistes): void {
        $merged = array_merge($this->pistes, $pistes);

        $unique = [];
        $seen = [];
        foreach ($merged as $piste) {
            $key = $piste->titre . '|' . $piste->chemin;
            if (!isset($seen[$key])) {
                $unique[] = $piste;
                $seen[$key] = true;
            }
        }

        $this->pistes = $unique;
        $this->nombrePistes = count($this->pistes);
        $this->dureeTotale = $this->calculerDureeTotale();
    }

    private function calculerDureeTotale(): int {
        $total = 0;
        foreach ($this->pistes as $piste) {
            $total += $piste->duree ?? 0;
        }
        return $total;
    }

    public function getID(): String {
        return $this->id;
    }

    public function getNom():string{
        return $this->nom;
    }
}
