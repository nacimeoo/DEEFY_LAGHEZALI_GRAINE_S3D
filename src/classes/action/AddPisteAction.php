<?php
declare(strict_types=1);
namespace iutnc\deefy\action;

use iutnc\deefy\repository\DeefyRepository;

class AddPisteAction extends Action{

    public function execute():string{
        if (!isset($_SESSION['playlist'])) {
            return "<p>Vous devez d'abord sélectionner une playlist.</p>
                    <a href='?action=displayPlaylist'>Voir mes playlists</a>";
        }

        $playlistName = htmlspecialchars($_SESSION['playlist']['nom']);

        if ($this->http_method === 'GET') {
            return <<<fin
            <div class="content-box">
                <h1>Ajouter une piste de podcast</h1>
                <form method="post" action="?action=addPiste">
                    <label>Titre :</label>
                    <input type="text" name="titre" required><br>
                    
                    <label>Auteur :</label>
                    <input type="text" name="auteur" required><br>
                    
                    <label>Genre :</label>
                    <input type="text" name="genre" required><br>
                    
                    <label>Durée (en secondes) :</label>
                    <input type="number" name="duree" min="1" required><br>
                    
                    <label>Chemin :</label>
                    <input type="text" name="chemin" required><br>
                    
                    <button type="submit">Ajouter la piste</button>
                </form>
            </div>
            fin;
        } else {
            $titre = filter_var($_POST['titre'], FILTER_SANITIZE_SPECIAL_CHARS);
            $auteur = filter_var($_POST['auteur'], FILTER_SANITIZE_SPECIAL_CHARS);
            $genre = filter_var($_POST['genre'], FILTER_SANITIZE_SPECIAL_CHARS);
            $duree = intval($_POST['duree']);
            $chemin = filter_var($_POST['chemin'], FILTER_SANITIZE_SPECIAL_CHARS);

            $repo = DeefyRepository::getInstance();
            $playlistId = (int)$_SESSION['playlist']['id'];

            $repo->addPistePlaylist($playlistId, ['titre' => $titre, 'auteur' => $auteur, 'duree' => $duree, 'filename' => $chemin, 'genre' =>$genre]);

            return "<div> la piste $titre a été ajouté à la playlist $playlistName </div>
                    <a href='?action=displayCurrentP'>Voir la playliste</a>";

        }


    }
}

