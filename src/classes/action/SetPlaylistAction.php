<?php
declare(strict_types=1);
namespace iutnc\deefy\action;
use iutnc\deefy\audio\lists\Playlist;
use iutnc\deefy\audio\tracks\AudioTrack;
use iutnc\deefy\audio\tracks\Piste;
use iutnc\deefy\render\AudioListRenderer;
use iutnc\deefy\render\Renderer;
use iutnc\deefy\repository\DeefyRepository;


class SetPlaylistAction extends Action {

    public function execute(): string {
        if (!isset($_SESSION['user'])) {
            return "<p>Vous devez être connecté pour choisir une playlist.</p>";
        }

        $id_playlist = (int)$_GET['id'];

        $repo = DeefyRepository::getInstance();
        $playlist = $repo->getPlaylistById($id_playlist);

        $pisteP = $repo->getPistePlaylist($id_playlist);
        $pistes = [];

        foreach ($pisteP as $pi){
            $piste = new Piste($pi['titre'],$pi['auteur_podcast']?? 'inconu' , (int)$pi['duree'], $pi['filename']);
            $piste->setGenre($pi['genre']);
            $pistes[] = $piste;
        }


        $p = new Playlist($playlist['nom'], $pistes);
        $p->setID((string)$playlist['id']);

        $_SESSION['playlist'] = ['id' => $playlist['id'], 'nom' => $playlist['nom']];

        $renderer = new AudioListRenderer($p);
        $html = $renderer->render(Renderer::LONG);
        $html.= "<a href='?action=addPiste'>Ajouter une piste</a><br>
                <a href='?action=displayPlaylist'>Retour aux playlists</a>";

        return $html;
    }
}
