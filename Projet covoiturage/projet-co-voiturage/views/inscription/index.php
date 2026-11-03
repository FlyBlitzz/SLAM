<!-- ENT_QUOTES transforme les caractères spéciaux en entités HTML -->
<section aria-labelledby="titre-inscription">
    <h1 id="titre-inscription">Créer un compte</h1>

    <?php if ($inscriptionReussie): ?>
        <div class="alert alert-success" role="status">
            <p>Votre compte a été créé. Vous pouvez maintenant vous connecter.</p>
        </div>
        <p><a href="index.php?action=connexion">Se connecter</a></p>
    <?php else: ?>
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

        <form class="account-form" method="post" action="index.php?action=inscription" novalidate>
            <?php
            $champs = [
                'nom' => ['Nom', 'text', 'Ex. : Dupont'],
                'prenom' => ['Prénom', 'text', 'Ex. : Marie'],
                'email' => ['Adresse électronique académique', 'email', 'Ex. : prenom.nom@ac-besancon.fr'],
                'telephone' => ['Numéro de téléphone', 'tel', 'Ex. : 06 12 34 56 78'],
                'mot_de_passe' => ['Mot de passe', 'password', 'Choisissez votre mot de passe'],
                'code_inscription' => ['Code d’inscription', 'text', 'Saisissez le code fourni par le lycée'],
            ];
            ?>
            <?php foreach ($champs as $champ => [$libelle, $type, $placeholder]): ?>
                <div class="form-field">
                    <label for="<?= htmlspecialchars($champ, ENT_QUOTES, 'UTF-8') ?>">
                        <?= htmlspecialchars($libelle, ENT_QUOTES, 'UTF-8') ?>
                        <span aria-hidden="true">*</span>
                    </label>
                    <input id="<?= htmlspecialchars($champ, ENT_QUOTES, 'UTF-8') ?>"
                        name="<?= htmlspecialchars($champ, ENT_QUOTES, 'UTF-8') ?>"
                        type="<?= htmlspecialchars($type, ENT_QUOTES, 'UTF-8') ?>"
                        placeholder="<?= htmlspecialchars($placeholder, ENT_QUOTES, 'UTF-8') ?>" required
                        <?= isset($erreurs[$champ])
                            ? 'aria-describedby="erreur-' . htmlspecialchars($champ, ENT_QUOTES, 'UTF-8') . '" aria-invalid="true"'
                            : '' ?>         <?php if (isset($valeurs[$champ])): ?>
                            value="<?= htmlspecialchars($valeurs[$champ], ENT_QUOTES, 'UTF-8') ?>" <?php endif; ?>>
                    <?php if (isset($erreurs[$champ])): ?>
                        <p id="erreur-<?= htmlspecialchars($champ, ENT_QUOTES, 'UTF-8') ?>" class="field-error">
                            <?= htmlspecialchars($erreurs[$champ], ENT_QUOTES, 'UTF-8') ?>
                        </p>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <button class="btn btn-primary" type="submit">Créer mon compte</button>
            <p class="form-legend"><span aria-hidden="true">*</span> Champ obligatoire.</p>
        </form>
    <?php endif; ?>
</section>