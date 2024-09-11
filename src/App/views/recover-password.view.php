<?= loadPartial('head', ['title' => $title, 'css' => $css]) ?>
<?= loadPartial('navigation') ?>

<section class="d-flex flex-column justify-content-center align-items-center sign-section">
    <h1 class="sign-h1">Zmień hasło</h1>
    <p class="px-3 text-center fs-4 text-secondary">Wystarczy, że podasz swój e-mail, a my pomożemy Ci ustawić nowe hasło.</p>
    <form class="sign-form" action="/user/recover-password" method="post">
        <label for="email" class="form-label">Adres email</label>
        <input type="email" class="form-control sign-input" name="email" id="email" value="<?php echo $oldValues['email'] ?? '' ?>">
        <?php if (isset($errors['email'])) : ?>
                <p class="error text-danger"><?= $errors['email'] ?></p>
            <?php endif ?>
        <div class="d-flex justify-content-end"><button type="submit" class="sign-btn btn btn-warning text-white">Zmień hasło</button></div>
    </form>
</section>

<script src="js/sign-form.min.js"></script>
</body>

</html>