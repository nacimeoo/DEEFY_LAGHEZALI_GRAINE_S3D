<?php
declare(strict_types=1);
namespace iutnc\deefy\audio\lists;


class AudioList {
    protected string $nom;
    protected int $nombrePistes;
    protected int $dureeTotale;
    protected array $pistes; 
    private string $id;

    public function __construct(string $nom, array $pistes = []) {
        $this->nom = $nom;
        $this->pistes = $pistes;
        $this->nombrePistes = count($pistes);
        $this->dureeTotale = $this->calculerDureeTotale();
    } 

    private function calculerDureeTotale(): int {
        $total = 0;
        foreach ($this->pistes as $piste) {
            $total += $piste->duree ?? 0;
        }
        return $total;
    }

    public function __get(string $name) {
        if (property_exists($this, $name)) {
            return $this->$name;
        }
        throw new InvalidPropertyNameException("invalid property : $name");
    }

    public function setID(string $id): void {
        $this->id = $id;
    }
}
