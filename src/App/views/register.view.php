<?= loadPartial('head', ['title' => $title, 'css' => $css]) ?>
<?= loadPartial('navigation') ?>
<?php
session_start();
if (isset($_SESSION['signup-errors'])) {
    $errors = $_SESSION['signup-errors'];
}

if (isset($_SESSION['signup-values'])) {
    $signupValues = $_SESSION['signup-values'];
}
?>


<body>
    <section class="d-flex flex-column justify-content-center align-items-center sign-section">
        <h1 class="sign-h1">Rejestracja</h1>
        <form class="sign-form" action="/rejestracja" method="post">
            <label for="firstname" class="form-label">Imię</label>
            <input type="text" class="form-control sign-input" name="firstname" id="first-name" value="<?php echo $signupValues['firstname'] ?? '' ?>">
            <?php if (isset($errors['firstname'])) : ?>
                <p class="error text-danger"><?= $errors['firstname'] ?></p>
            <?php endif ?>

            <p class="error text-danger"></p>
            <label for="lastname" class="form-label">Nazwisko</label>
            <input type="text" class="form-control sign-input" name="lastname" id="last-name" value="<?php echo $signupValues['lastname'] ?? '' ?>">
            <?php if (isset($errors['lastname'])) : ?>
                <p class="error text-danger"><?= $errors['lastname'] ?></p>
            <?php endif ?>

            <label for="email" class="form-label">Adres e-mail</label>
            <input type="email" class="form-control sign-input" name="email" id="email" value="<?php echo $signupValues['email'] ?? '' ?>">
            <?php if (isset($errors['email'])) : ?>
                <p class="error text-danger"><?= $errors['email'] ?></p>
            <?php endif ?>

            <label for="password" class="form-label">Hasło</label>
            <input type="password" class="form-control sign-input" name="pwd" id="password">
            <?php if (isset($errors['pwd'])) : ?>
                <p class="error text-danger"><?= $errors['pwd'] ?></p>
            <?php endif ?>

            <label for="confirm-password" class="form-label">Powtórz hasło</label>
            <input type="password" class="form-control sign-input" name="confirm-pwd" id="confirm-password">
            <?php if (isset($errors['confirmPwd'])) : ?>
                <p class="error text-danger"><?= $errors['confirmPwd'] ?></p>
            <?php endif ?>

            <div class="d-flex justify-content-end"><button type="submit" class="sign-btn btn btn-warning text-white">Zarejestruj się</button></div>
        </form>
        <p class="switch-paragraph">Posiadasz już konto? <a class="switch-link" href="/logowanie">Zaloguj się</a></p>
        <div class="info mt-5 text-danger fs-2 border border-danger">
            <p>Uwaga! Adres email musi być prawdziwy, ponieważ zostanie na niego wysłany link aktywacyjny.
            </p>
        </div>
    </section>

    <?php
    unset($_SESSION['signup-errors']);
    unset($_SESSION['signup-values']);
    ?>

    <script src="js/sign-form.min.js"></script>

</body>

</html>