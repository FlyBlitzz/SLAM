<?php

// Extract
$data = [
    "title" => "Liste des films",
    "films" => ["toto", "tutu"]
];

echo $data['title'];
echo PHP_EOL;
var_dump($data['films']);
echo PHP_EOL;

extract($data);
echo $title;
echo PHP_EOL;
var_dump($films);

// Mise en tampon

echo "Bonjour " . PHP_EOL;

ob_start(); // Démarrage de la mise en tampon de ce qui va venir
echo "Contenu mis en tampon" . PHP_EOL;
// Déverser le contenu du tampon dans la variable contenu
$contenu = ob_get_clean();
echo $contenu;

echo PHP_EOL;
?>

<?php
$prenom = "Nathanaël";
ob_start();
?>
<section>
    <h1>Bienvenue</h1>
    <p> Bonjour <?= $prenom ?></p>
</section>

<?php
$content = ob_get_clean();
echo $content;