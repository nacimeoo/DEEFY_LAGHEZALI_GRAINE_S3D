<?php
declare(strict_types=1);

namespace iutnc\deefy\render;
use iutnc\deefy\audio\tracks\AudioTrack;
use iutnc\deefy\audio\tracks\Piste;



class PisteRenderer extends AudioTrackRenderer{
    private Piste $podcast;

    public function __construct(Piste $podcast)
    {
        $this->podcast = $podcast;
    }



    protected function renderCompact(): string
    {
        return <<<fin
        <div class="podcast-compact">
            <strong>Titre : </strong>  {$this->podcast->titre} - <strong>Auteur : </strong>{$this->podcast->auteur}
        </div>
        fin;
    }

    protected function renderLong(): string
    {
        return <<<fin
        <div class="podcast-long" style="border:1px solid #ccc; padding:10px; margin:10px;">
            <h2>{$this->podcast->titre}</h2>
            <p><strong>Auteur:</strong> {$this->podcast->auteur}</p>
            <p><strong>Date:</strong> {$this->podcast->date}</p>
            <p><strong>Genre:</strong> {$this->podcast->genre}</p>
            <p><strong>Durée:</strong> {$this->podcast->duree} secondes</p>
        </div>
        fin;
    }
}
