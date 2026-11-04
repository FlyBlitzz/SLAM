<!-- ENT_QUOTES transforme les caractères spéciaux en entités HTML -->
<section aria-labelledby="titre-connexion">
    <h1 id="titre-connexion">Se connecter</h1>

    <?php if ($message !== ''): ?>
        <div class="alert alert-error" role="alert">
            <p><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
        </div>
    <?php endif; ?>

    <?php if ($erreurs !== []): ?>
        <div class="alert alert-error" role="alert">
            <p>Vérifiez les champs signalés ci-dessous.</p>
        </div>
    <?php endif; ?>

    <form class="account-form" method="post" action="index.php?action=connexion" novalidate>
        <?php foreach ([
            'email' => ['Adresse électronique', 'email'],
            'mot_de_passe' => ['Mot de passe', 'password'],
        ] as $champ => [$libelle, $type]): ?>
            <div class="form-field">
                <label for="<?= htmlspecialchars($champ, ENT_QUOTES, 'UTF-8') ?>">
                    <?= htmlspecialchars($libelle, ENT_QUOTES, 'UTF-8') ?>
                    <span aria-hidden="true">*</span>
                </label>
                <input id="<?= htmlspecialchars($champ, ENT_QUOTES, 'UTF-8') ?>"
                    name="<?= htmlspecialchars($champ, ENT_QUOTES, 'UTF-8') ?>"
                    type="<?= htmlspecialchars($type, ENT_QUOTES, 'UTF-8') ?>"
                    placeholder="<?= htmlspecialchars($libelle, ENT_QUOTES, 'UTF-8') ?>" required <?= isset($erreurs[$champ])
                            ? 'aria-describedby="erreur-' . htmlspecialchars($champ, ENT_QUOTES, 'UTF-8') . '" aria-invalid="true"'
                            : '' ?>     <?php if ($champ === 'email'): ?> value="<?= htmlspecialchars($email, ENT_QUOTES, 'UTF-8') ?>"
                    <?php endif; ?>>
                <?php if (isset($erreurs[$champ])): ?>
                    <p id="erreur-<?= htmlspecialchars($champ, ENT_QUOTES, 'UTF-8') ?>" class="field-error">
                        <?= htmlspecialchars($erreurs[$champ], ENT_QUOTES, 'UTF-8') ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>

        <button class="btn btn-primary" type="submit">Se connecter</button>
        <p><span aria-hidden="true">*</span> Champ obligatoire.</p>
    </form>
</section>