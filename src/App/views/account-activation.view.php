<?= loadPartial('head', ['title' => $title, 'css' => $css]) ?>
<?= loadPartial('navigation') ?>

<body>
    <main class="d-flex flex-column justify-content-center align-items-center sign-section text-center">
        <?php
        if (!empty($errors)) {
            $errorHeading = $errors['token-not-exist'] ?? $errors['token-expired'];
            echo <<<HTML
         <h1 class="sign-h1 mt-5 mb-3 px-4">{$errorHeading}</h1>
         <p class="switch-paragraph px-5 mb-5 fs-3">Kliknij <a class="switch-link" href="/rejestracja">tutaj</a>, ponownie się zarejestrować</p>
         <img class="token-error-img" src="img/dog.min.png" alt="pies w stroju astronauty">
       HTML;
        } else {
            echo <<<HTML
            <h1 class="sign-h1 mt-5 mb-3 px-4">Twoje konto zostało aktywowane</h1>
            <p class="switch-paragraph px-5 mb-5 fs-3">Kliknij <a class="switch-link" href="/logowanie">tutaj</a>, aby się zalogować</p>
            <img class="token-error-img" src="img/dog.min.png" alt="pies w stroju astronauty">
            HTML;
        }
        ?>
    </main>
</body>

</html>