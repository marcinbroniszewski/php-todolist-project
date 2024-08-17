<?= loadPartial('head', ['title' => $title, 'css' => $css]) ?>
<?= loadPartial('navigation') ?>

<body>
    <section class="d-flex flex-column justify-content-center align-items-center sign-section">
        <h1 class="sign-h1">Logowanie</h1>
        <form class="sign-form" action="../app/includes/login.inc.php" method="post">
            <label for="login-username" class="form-label">Nazwa użytkownika</label>
            <input type="text" class="form-control sign-input" name="username" id="login-username">


            <label for="login-password" class="form-label">Hasło</label>
            <input type="password" class="form-control sign-input" name="pwd" id="login-password">
            <div class="d-flex justify-content-end"><button type="submit" class="sign-btn btn btn-warning text-white">Zarejestruj się</button></div>
        </form>
        <p class="switch-paragraph">Nie posiadasz konta? <a class="switch-link" href="/rejestracja">Zarejestruj się</a></p>
    </section>

    <script src="js/sign-inputs.min.js"></script>

</body>

</html>