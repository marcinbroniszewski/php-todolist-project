<?= loadPartial('head', ['title' => $title, 'css' => $css]) ?>
<?= loadPartial('navigation') ?>

<body>
    <main class="d-flex flex-column justify-content-center align-items-center sign-section text-center">
        <h1 class="sign-h1 mt-5 mb-3 px-4">Link do zmiany hasła został wysłany</h1>
        <p class="switch-paragraph mb-5 fs-3">Sprawdź pocztę email</p>
        <p class="text-danger fs-3">Jeśli nie widzisz maila z linkiem aktywacyjnym - sprawdź zakładkę spam</p>
        <img class="token-error-img" src="img/dog.min.png" alt="pies w stroju astronauty">
    </main>
</body>
</html>