<?php
declare(strict_types=1);

namespace iutnc\deefy\render;


use iutnc\deefy\audio\tracks\AudioTrack;

abstract class AudioTrackRenderer implements Renderer{

    private AudioTrack $track;

    public function __construct(AudioTrack $track){
        $this->track = $track;
    }

    final public function render(int $selector): string{
        return match ($selector) {
            Renderer::COMPACT => $this->renderCompact(),
            Renderer::LONG => $this->renderLong(),
            default => '',
        };
    }

    abstract protected function renderCompact(): string;
    abstract protected function renderLong(): string;
}