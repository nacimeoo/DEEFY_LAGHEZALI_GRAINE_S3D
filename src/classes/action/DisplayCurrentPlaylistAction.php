<?php

namespace iutnc\deefy\action;

class DisplayCurrentPlaylistAction extends Action{

    public function execute(): string{
        if (!isset($_SESSION['playlist'])) {
            return "<p>Aucune playlist courante.</p>";
        }

        $pl = $_SESSION['playlist'];

        $nom = htmlspecialchars($pl['nom']);
        $id_pl = htmlspecialchars((string)$pl['id']);
        return <<<fin
            <div class="playlist-container">
                <h2 class="playlist-title">Playliste courante</h2>
                <div class="playlist-grid">
                    <div class="playlist-card">
                        <a href="?action=setPlaylist&id=$id_pl">$nom</a>
                    </div>
                </div>
            </div>
            fin;

    }
}