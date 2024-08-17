<?= loadPartial('head', ['title' => $title, 'css' => $css]) ?>
<?= loadPartial('navigation') ?>

<body>
<section class="d-flex flex-column justify-content-center align-items-center sign-section">
        <h1 class="sign-h1">Rejestracja</h1>
        <form class="sign-form" action="../app/includes/signup.inc.php" method="post">
        <label for="signup-first-name" class="form-label">Imię</label>
    <input type="text" class="form-control sign-input" name="first-name" id="signup-first-name">

 <label for="signup-last-name" class="form-label">Nazwisko</label>
    <input type="text" class="form-control sign-input" name="last-name" id="signup-last-name">



<label for="signup-email" class="form-label">Adres email</label>
    <input type="email" class="form-control sign-input" name="email" id="signup-email">

    <label for="signup-username" class="form-label">Nazwa użytkownika</label>
<input type="text" class="form-control sign-input"  name="username" id="signup-username">


<label for="signup-password" class="form-label">Hasło</label>
<input type="password" class="form-control sign-input"  name="pwd" id="signup-password">
            <div class="d-flex justify-content-end"><button type="submit" class="sign-btn btn btn-warning text-white">Zarejestruj się</button></div>
        </form>
        <p class="switch-paragraph">Posiadasz już konto? <a class="switch-link" href="/logowanie">Zaloguj się</a></p>
        <div class="info mt-5 text-danger fs-2 border border-danger"><p>Uwaga! Adres email musi być prawdziwy, ponieważ zostanie na niego wysłany link aktywacyjny.    
        </p></div>
    </section>

    <script src="js/sign-inputs.min.js"></script>

    </body>

</html>
