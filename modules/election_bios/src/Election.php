<?php
namespace Digraph\Modules\election_bios;

use Digraph\DSO\Noun;

class Election extends Noun
{
    public function body()
    {
        $body = parent::body();
        $bios = $this->bios();
        if (!$bios) {
            $body .= '<p><em>No bios have been added</em></p>';
        }
        foreach ($bios as $bio) {
            $body .= $bio->infoCard();
        }
        return $body;
    }

    public function bios(): array
    {
        $bios = $this->cms()->helper('graph')
            ->children($this['dso.id'], 'election-bio');
        usort($bios, function ($a, $b) {
            return strcasecmp(
                $a->lastName(),
                $b->lastName()
            );
        });
        return $bios;
    }
}
