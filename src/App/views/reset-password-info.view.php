<?= loadPartial('head', ['title' => $title, 'css' => $css]) ?>
<?= loadPartial('navigation') ?>

<body>
    <main class="d-flex flex-column justify-content-center align-items-center sign-section text-center">
        <h1 class="sign-h1 mt-5 mb-3 px-4">Hasło zostało pomyślnie zmienione</h1>
        <p class="switch-paragraph px-5 mb-5 fs-3">Kliknij <a class="switch-link" href="/logowanie">tutaj</a>, aby się zalogować</p>
        <img class="token-error-img" src="img/dog.min.png" alt="pies w stroju astronauty">
    </main>
</body>
</html>