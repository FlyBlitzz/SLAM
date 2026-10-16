<h2>Ajouter un nouveau film</h2>

<?php if ($errors !== []): ?>
    <div class="alert alert-error">
        <strong>Veuillez corriger les erreurs suivantes :</strong>
        <ul>
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form method="POST" action="index.php?action=create" class="card-form">
    <div class="form-group">
        <label for="titre">Titre du film</label>
        <input type="text" id="titre" name="titre" value="<?= htmlspecialchars($titre) ?>" placeholder="Ex : Inception"
            required>
    </div>

    <div class="form-group">
        <label for="realisateur">Réalisateur</label>
        <input type="text" id="realisateur" name="realisateur" value="<?= htmlspecialchars($realisateur) ?>"
            placeholder="Ex : Christopher Nolan" required>
    </div>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Enregistrer le film</button>
        <a href="index.php?action=list" class="btn btn-outline">Annuler / Retour à la liste</a>
    </div>
</form>