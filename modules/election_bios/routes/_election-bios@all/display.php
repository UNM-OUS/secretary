<?php
use Digraph\Modules\election_bios\Election;

$package->cache_noStore();

$url = $cms->helper('urls')->parse('_controlpanel/add?type=election-bio-list');
if ($cms->helper('permissions')->checkUrl($url)) {
    echo "<p><a href='$url' class='cta-button'>Add new election</a></p>";
}

$elections = $cms->factory()->search();
$elections->where('${dso.type} = "election-bio-list"');
$elections->order('${dso.created.date} desc');

echo $cms->helper('paginator')->paginateSearch(
    $elections,
    $package,
    function (Election $result) use ($cms) {
        return [
            $result->link(),
            $cms->helper('strings')->datetimeHTML($result['dso.modified.date']),
        ];
    },
    [
        'Election',
        'Modified',
    ]
);
