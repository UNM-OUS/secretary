<?php
$groups = array();
$netid = strtolower($_GET['netid']);

if ($netid) {
    $groups = $groups + groupsFromFilesByGroup(__DIR__.'/../AuthGroups/*.txt', $netid);
    $groups = $groups + groupsFromFilesByGroup(__DIR__.'/*.group.txt', $netid);
    // $groups = $groups + groupsFromFilesByGroup(__DIR__.'/*.user.txt', $netid);
}

$groups = array_unique($groups);
natcasesort($groups);
echo json_encode(array_values($groups));

function groupsFromFilesByGroup($glob, $netid)
{
    $groups = array();
    $files = glob($glob);
    foreach ($files as $file) {
        if ($fh = fopen($file, 'r')) {
            while (!feof($fh)) {
                $line = trim(fgets($fh));
                if ($line == $netid) {
                    $groups[] = preg_replace('/^(.*\/)(.+?)(\..+)?$/', '$2', $file);
                }
            }
            fclose($fh);
        }
    }
    return $groups;
}
