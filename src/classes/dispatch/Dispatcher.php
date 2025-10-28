<?php
declare(strict_types=1);
namespace iutnc\deefy\dispatch;

use iutnc\deefy\action;

class Dispatcher {

    private string $action;
   
    public function __construct(string $action){
        
        $this->action = $action;
        
    }
    
    public function run() : void{
        switch ($this->action) {
            case 'addPlaylist':
                $html = (new action\AddPlaylistAction())->execute();
                break;
            case 'displayPlaylist':
                $html = (new action\DisplayPlaylistAction())->execute();
                break;
            case 'addPiste':
                $html = (new action\AddPisteAction())->execute();
                break;  
            case 'signin':
                $html = (new action\SigninAction())->execute();
                break;  
            case 'addUser':
                $html = (new action\addUserAction())->execute();
                break;
            case 'deco':
                $html = (new action\deconexion())->execute();
                break;
            case 'setPlaylist':
                $html = (new action\SetPlaylistAction())->execute();
                break;
            case 'displayCurrentP':
                $html = (new action\DisplayCurrentPlaylistAction())->execute();
                break;
            default:
                $html = (new action\DefaultAction())->execute();
                break;
        }
        $this->renderPage($html);
    }

    public function renderPage(string $html):void{

        if (isset($_SESSION['user'])) {
            $email = htmlspecialchars($_SESSION['user']['email']);
            $userContent = "<span>Connecté : $email</span> <a href='?action=deco'>Déconnexion</a>";
        } else {
            $userContent = "<a href='?action=signin'>Se connecter</a> <a href='?action=addUser'>S'inscrire</a>";
        }

        echo <<<fin
        <!DOCTYPE html>
            <html lang="fr">
                <head>
                    <meta charset="UTF-8">
                    <title>Deefy App</title>
                    <link rel="stylesheet" href="style.css">            
                </head>
                <div class="container">
                    
                    <div class="menu">
                        <div class="logo">
                            <h1>DEEFY</h1>
                            <a href='?action=default'>
                                  <img src="img/home.png" class="icon"> Accueil
                            </a>
                        </div>

                        <div class="playlist">
                            <h2>Playlist</h2>
                            <div class="playlist-creator">
                                <a href='?action=addPlaylist'>
                                    <img src="img/plus.png" class="icon">Creer playliste
                                </a>
                                <a href='?action=displayPlaylist'>
                                    <img src="img/play.png" class="icon">Mes playlistes
                                </a>
                                <a href='?action=addPiste'>
                                    <img src="img/plus.png" class="icon">Ajouter piste
                                </a>
                                <a href='?action=displayCurrentP'>
                                    <img src="img/plus.png" class="icon">Voir playliste courante
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <header class="top-bar">
                    <div class="user-actions">
                        $userContent
                    </div>
                </header>

                <main class="main-content">
                    $html
                </main>
            </html>
        
        fin;

    }
    
}