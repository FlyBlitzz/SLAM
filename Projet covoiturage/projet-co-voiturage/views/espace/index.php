<section aria-labelledby="titre-espace">
    <h1 id="titre-espace">Mon espace</h1>
    <div class="alert alert-success">
        <p>Bienvenue <?= htmlspecialchars($utilisateur['prenom'], ENT_QUOTES, 'UTF-8') ?>
            <?= htmlspecialchars($utilisateur['nom'], ENT_QUOTES, 'UTF-8') ?>.
        </p>
    </div>
    <p>Connecté avec <?= htmlspecialchars($utilisateur['email'], ENT_QUOTES, 'UTF-8') ?>.</p>
</section>