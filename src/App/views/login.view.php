<?= loadPartial('head', ['title' => $title, 'css' => $css]) ?>
<?= loadPartial('navigation') ?>

<body>
    <section class="d-flex flex-column justify-content-center align-items-center sign-section">
        <h1 class="sign-h1">Logowanie</h1>
        <form class="sign-form" action="/logowanie" method="post">
            <label for="email" class="form-label">Adres e-mail</label>
            <input type="email" class="form-control sign-input" name="email" id="email" value="<?php echo $oldValues['email'] ?? '' ?>">
            <?php if (isset($errors['email'])) : ?>
                <p class="error text-danger"><?= $errors['email'] ?></p>
            <?php endif ?>


            <label for="password" class="form-label">Hasło</label>
            <input type="password" class="form-control sign-input" name="pwd" id="password">
            <?php if (isset($errors['pwd'])) : ?>
                <p class="error text-danger"><?= $errors['pwd'] ?></p>
            <?php endif ?>

            <div class="d-flex justify-content-end"><button type="submit" class="sign-btn btn btn-warning text-white">Zarejestruj się</button></div>
        </form>
        <p class="switch-paragraph">Nie posiadasz konta? <a class="switch-link" href="/rejestracja">Zarejestruj się</a></p>
    </section>

    <script src="js/sign-form.min.js"></script>

</body>

</html>