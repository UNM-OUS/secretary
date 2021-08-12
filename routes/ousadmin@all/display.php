<ul>
    <li><a href="https://facgov.unm.edu/_user/signin" target="_blank">Faculty Governance</a></li>
    <li><a href="https://handbook.unm.edu/_user/signin" target="_blank">Faculty Handbook</a></li>
    <li><a href="https://rac.unm.edu/_rac/chair" target="_blank">RAC admin dashboard</a></li>
    <li><a href="https://secretary.unm.edu/_user/signin" target="_blank">Main Secretary site</a></li>
    <li><a href="https://graduation.unm.edu/_user/signin" target="_blank">Commencement</a></li>
    <li><a href="https://freshmanconvocation.unm.edu/_user/signin" target="_blank">Freshman Convocation</a></li>
    <li><a href="https://gradapp.unm.edu/events/admin" target="_blank">Event/RSVP management</a></li>
<?php
$actions = $cms->helper('actions')->other('ousadmin');
foreach ($actions as $url) {
    if ($url = $cms->helper('urls')->parse($url)) {
        echo "<li>".$url->html()."</li>";
    }
}
 ?>
</ul>
