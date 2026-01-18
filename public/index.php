<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h3>DEBUG INFO</h3>";
echo "URL demandée : " . ($_GET['url'] ?? 'home/index') . "<br>";
echo "Chemin du projet : " . __DIR__ . "<br>";

require_once __DIR__ . '/../routes/web.php';
