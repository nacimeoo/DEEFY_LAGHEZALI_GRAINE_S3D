<?php
declare(strict_types=1);

namespace iutnc\deefy\repository;
use iutnc\deefy\audio\lists\Playlist;

class DeefyRepository{
    private \PDO $pdo;
    private static ?DeefyRepository $instance = null;
    private static array $config = [ ];

    private function __construct(array $conf) {
        $this->pdo = new \PDO($conf['dsn'], $conf['user'], $conf['pass'],
        [\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION]);
    }

    public static function getInstance(){
        if (is_null(self::$instance)) {
            self::$instance = new DeefyRepository(self::$config);
        }
        return self::$instance;
    }

    public static function setConfig(string $file) {
        $conf = parse_ini_file($file);
        if ($conf === false) {
            throw new \Exception("Error reading configuration file");
        }

        $driver     = $conf['driver'];
        $host       = $conf['host'];
        $database   = $conf['database'];

        self::$config = [  
            'dsn'  => "$driver:host=$host;dbname=$database",
            'user'=> $conf['username'],
            'pass'=> $conf['password'] 
            ];
    }


    public function addPlaylist(Playlist $pl): Playlist {
        $query = "INSERT INTO playlist (nom) VALUES (:nom)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute(['nom' => $pl->nom]);
        $pl->setID($this->pdo->lastInsertId());
        return $pl;

    }

    public function getUserByEmail(string $email): array|false {
        $stmt = $this->pdo->prepare('SELECT * FROM User WHERE email = :email');
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function insertUser(string $email, string $hashedPassword, int $role = 1): void {
        $stmt = $this->pdo->prepare(
            "INSERT INTO User (email, passwd, role) VALUES (:email, :passwd, :role)"
        );
        $stmt->execute(['email' => $email, 'passwd' => $hashedPassword, 'role' => $role]);
    }

    public function getPlaylistsByUser(int $id): array {
        $stmt = $this->pdo->prepare('SELECT * FROM playlist INNER JOIN user2playlist user2playlist ON playlist.id = user2playlist.id_pl WHERE user2playlist.id_user = :userid');
        $stmt->execute(['userid' => $id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getPlaylistById(int $id): array {
        $stmt = $this->pdo->prepare("SELECT * FROM playlist WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function addPlaylistUser(int $playlistId, int $userId): void {
        $stmt = $this->pdo->prepare("INSERT INTO user2playlist (id_pl, id_user) VALUES (:id_pl, :id_user)");
        $stmt->execute(['id_pl' => $playlistId, 'id_user' => $userId]);
    }

    public function addPistePlaylist(int $playlistId, array $array): void{
        $stmt = $this->pdo->prepare(
            "INSERT INTO track (titre, genre, duree, filename, auteur_podcast) VALUES (:titre, :genre, :duree, :filename, :auteur)");
        $stmt->execute(['titre' => $array['titre'], 'genre' => $array['genre'], 'duree' => $array['duree'], 'filename' => $array['filename'], 'auteur' => $array['auteur']]);

        $pisteId = $this->pdo->lastInsertId();

        $stmt = $this->pdo->prepare("SELECT COALESCE(MAX(no_piste_dans_liste), 0) + 1 as numsuivant FROM playlist2track WHERE id_pl = :id_pl");
        $stmt->execute(['id_pl' => $playlistId]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        $numsuivant = $result['numsuivant'];

        $stmt = $this->pdo->prepare("INSERT INTO playlist2track (id_pl, id_track, no_piste_dans_liste) VALUES (:id_pl, :id_track, :no_piste)");
        $stmt->execute(['id_pl' => $playlistId, 'id_track' => $pisteId, 'no_piste' => $numsuivant]);
    }

    public function getPistePlaylist(int $id_playlist): array {
        $stmt = $this->pdo->prepare("SELECT track.* FROM track INNER JOIN playlist2track ON track.id = playlist2track.id_track WHERE playlist2track.id_pl = :id_pl");
        $stmt->execute(['id_pl' => $id_playlist]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}