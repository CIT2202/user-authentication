<?php
$hashOfhuddersfield = password_hash("huddersfield", PASSWORD_DEFAULT);
echo "<p>{$hashOfhuddersfield}</p>";

$hashOf123456 = password_hash("123456", PASSWORD_DEFAULT);
echo "<p>{$hashOf123456}</p>";

$hashOfqwerty = password_hash("qwerty", PASSWORD_DEFAULT);
echo "<p>{$hashOfqwerty}</p>";
?>
