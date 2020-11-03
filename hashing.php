<?php

//using md5
$md5huddersfield = md5("huddersfield");
echo "<p>md5 hash of 'huddersfield' = {$md5huddersfield}</p>";
//the two hashes will be identical
$md5huddersfield = md5("huddersfield");
echo "<p>md5 hash of 'huddersfield' = {$md5huddersfield}</p>";

//using bcrypt
$hashOfhuddersfield = password_hash("huddersfield", PASSWORD_DEFAULT);
echo "<p>brcypt hash of 'huddersfield' = {$hashOfhuddersfield}</p>";
//the two hashes will be different the password_hash() algorithm adds a salt
$hashOfhuddersfield = password_hash("huddersfield", PASSWORD_DEFAULT);
echo "<p>brcypt hash of 'huddersfield' = {$hashOfhuddersfield}</p>";
var_dump(password_verify('huddersfield','$2y$10$em6X15KQt4prqPeJ0g9Dg.2zLzhC/WKPrKpRfdHDw0VNUkH/FR9lK'));
echo "hello"
;?>
