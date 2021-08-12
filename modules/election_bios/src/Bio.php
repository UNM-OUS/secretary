<?php
namespace Digraph\Modules\election_bios;

use Digraph\DSO\Noun;

class Bio extends Noun
{
    const FILESTORE = true;
    const FILESTORE_PATH = 'photo';
    const SLUG_ENABLED = false;

    public function name($verb = null): string
    {
        return parent::name() . ', ' . $this['title'];
    }

    public function infoCard()
    {
        $card = "<article class='digraph-card type-" . $this['dso.type'] . "'>";
        if ($photo = $this->photo()) {
            $photo = $photo->imageUrl('election-bio-portrait-thumb');
            $photo = '<figure style="float:right;max-width:25%;margin-left:0.5rem;padding:0;margin-top:0;"><img alt="' . $this->name() . '" src="' . $photo . '"></figure>';
        } else {
            $photo = '';
        }
        $card .= "<h1><a href='" . $this->url() . "'>" . $photo . parent::name() . "</a></h1>";
        if ($this['title']) {
            $card .= '<p class="deck"><strong>' . $this['title'] . '</strong></p>';
        }
        $card .= "<a href='" . $this->url() . "'>read full biography/statement</a>";
        $card .= '<div style="clear:both;"></div>';
        $card .= "</article>";
        return $card;
    }

    public function parentEdgeType($parent)
    {
        if ($parent['dso.type'] == 'election-bio-list') {
            return 'election-bio';
        }
        return null;
    }

    public function lastName(): string
    {
        $name = preg_split('/ +/', trim(parent::name()));
        return end($name);
    }

    public function body()
    {
        $body = '';
        if ($this['title']) {
            $body .= '<p class="deck"><strong>' . $this['title'] . '</strong></p>';
        }
        if ($photo = $this->photo()) {
            $photo = $photo->imageUrl('election-bio-portrait');
            $body .= '<figure style="float:right;max-width:50%;margin-left:0.5rem;padding:0.5em;margin-top:0;"><img alt="' . $this->name() . '" src="' . $photo . '"></figure>';
        }
        $body .= parent::body();
        return $body;
    }

    public function photo()
    {
        if ($files = $this->factory->cms()->helper('filestore')->list($this, static::FILESTORE_PATH)) {
            return array_pop($files);
        }
        return null;
    }

    public function formMap(string $action): array
    {
        $map = parent::formMap($action);
        $map['digraph_name']['label'] = 'Name';
        $map['digraph_title'] = [
            'label' => 'Title',
            'class' => 'Formward\\Fields\\Input',
            'required' => false,
            'field' => 'title',
        ];
        $map['photo'] = [
            'label' => 'Portrait photo',
            'class' => 'Digraph\\Forms\\Fields\\FileStoreFieldSingle',
            'required' => false,
            'weight' => 103,
            'extraConstructArgs' => [
                static::FILESTORE_PATH,
                ['jpg', 'jpeg', 'png', 'gif', 'bmp'],
            ],
        ];
        $map['files'] = [
            'label' => 'Additional files',
            'class' => 'Digraph\\Forms\\Fields\\FileStoreFieldMulti',
            'required' => false,
            'weight' => 200,
            'extraConstructArgs' => [
                'files'
            ],
        ];
        return $map;
    }
}
