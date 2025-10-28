<?php
declare(strict_types=1);
namespace iutnc\deefy\render;

use iutnc\deefy\audio\lists\AudioList;
use iutnc\deefy\audio\tracks\Piste;


class AudioListRenderer implements Renderer{
    private AudioList $audiolist;

    public function __construct(AudioList $audiolist){
        $this->audiolist = $audiolist;
    }

    public function render (int $selector): string{
        $html = "<div class='audiolist'>\n";
        $html .= "<h2>{$this->audiolist->nom}</h2>\n";
        $html .= "<ul>\n";
        foreach ($this->audiolist->pistes as $piste) {
            $trackRenderer = new PisteRenderer($piste);
            $html .= "<li>" . $trackRenderer->render(Renderer::COMPACT) . "</li>\n";
        }

        $html .= "</ul>\n";
        $html .= "<p><strong>Nombre de pistes :</strong> {$this->audiolist->nombrePistes}</p>\n";
        $html .= "<p><strong>Durée totale :</strong> {$this->audiolist->dureeTotale} secondes</p>\n";
        $html .= "</div>\n";

        return $html;
    }

}