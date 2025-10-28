<?php
declare(strict_types=1);
namespace iutnc\deefy\action;

use iutnc\deefy\audio\lists\PlayList;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\render\Renderer;
use iutnc\deefy\repository\DeefyRepository;

class AddPlaylistAction extends Action{

    public function execute():string{
        if ($this->http_method === 'GET') {
        return <<<fin
        <div class="content-box">
            <h1>Créer une playlist</h1>
            <form method="post" action="?action=addPlaylist">
                <label>Nom de la playlist :</label>
                <input type="text" name="playlist_name" required>
                <button type="submit">Créer</button>
            </form>
        </div>
        fin;

        }else{

            if (!isset($_SESSION['user'])) {
                return "<p>Vous devez être connecté pour créer une playlist.</p>";
            }

            $playlist_name = filter_var($_POST['playlist_name'], FILTER_SANITIZE_SPECIAL_CHARS);
            $pl = new PlayList($playlist_name, []);
            
            $r = DeefyRepository::getInstance();
            $pl = $r->addPlaylist( $pl );

            $userId = (int)$_SESSION['user']['id'];
            $r->addPlaylistUser((int)$pl->getID(), $userId);

            $_SESSION['playlist'] = ['id' => $pl->getID(), 'nom' => $pl->getNom()];

            $renderer = new AudioListRenderer($pl);
            $html = $renderer->render(Renderer::LONG);
            $html .= "<a href='?action=addPiste'>Ajouter une piste</a>";

            return $html;

        }
    }    
    
}