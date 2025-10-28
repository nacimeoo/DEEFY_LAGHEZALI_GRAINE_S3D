<?php
declare(strict_types=1);
namespace iutnc\deefy\action;

use iutnc\deefy\repository\DeefyRepository;

class DisplayPlaylistAction extends Action{

    public function execute():string{
        if (!isset($_SESSION['user'])) {
            return "<p>Vous devez être connecté pour voir vos playlists.</p>";
        }

        $id = (int)$_SESSION['user']['id'];

        $repo = DeefyRepository::getInstance();
        $playlists = $repo->getPlaylistsByUser($id);

        if (empty($playlists)) {
            return "<p>Vous n'avez encore aucune playlist.</p>";
        }
        
        $html = <<<fin
            <div class="playlist-container">
                <h2 class="playlist-title">Mes playlists</h2>
            <div class="playlist-grid">
            fin;

        foreach ($playlists as $pl) {
            $nom = htmlspecialchars($pl['nom']);
            $id_pl = htmlspecialchars((string)$pl['id']);

            $html .= <<<fin
                <div class="playlist-card">
                    <a href="?action=setPlaylist&id=$id_pl">$nom</a>
                </div>
            fin;
            

        }
        $html .= <<<fin
            </div>
        </div>
        fin;

        return $html;

    }    
        
}