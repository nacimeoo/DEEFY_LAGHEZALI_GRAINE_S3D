<?php
declare(strict_types=1);
namespace iutnc\deefy\action;

class deconexion extends Action {

    public function execute(): string {
        session_destroy();

        session_start();

        return "<p>Vous êtes maintenant déconnecté.</p>";
    }
}
