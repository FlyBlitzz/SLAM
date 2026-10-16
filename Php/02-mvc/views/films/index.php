<div class="films-header">
    <h2>Films enregistrés (<?= count($films) ?>)</h2>
    <a href="index.php?action=create" class="btn btn-primary">+ Ajouter un film</a>
</div>

<?php if ($films === []): ?>
    <div class="empty-state">
        <p>Aucun film enregistré pour le moment.</p>
        <a href="index.php?action=create" class="btn btn-primary">Créer le premier film</a>
    </div>
<?php else: ?>
    <div class="films-grid">
        <?php foreach ($films as $film): ?>
            <article class="film-card">
                <h3><?= htmlspecialchars($film['titre']) ?></h3>
                <p><strong>Réalisateur :</strong> <?= htmlspecialchars($film['realisateur']) ?></p>
                <form action="index.php?action=delete" method="POST">
                    <input type="hidden" name="id" value="<?= $film['id'] ?>">
                    <button type="submit" class="btn btn-danger"
                        onclick="return confirm('Êtes-vous sûr de vouloir supprimer ?');"> Supprimer </button>
                </form>
            </article>
        <?php endforeach; ?>
    </div>
<?php endif; ?>