<?= loadPartial('head', ['title' => $title, 'css' => $css]) ?>
<?= loadPartial('navigation') ?>

<section class="d-flex flex-column justify-content-center align-items-center sign-section">
    <?php
    if (!empty($tokenErrors)) {
        $errorHeading = $tokenErrors['token-not-exist'] ?? $tokenErrors['token-expired'];
        echo <<<HTML
<h1 class="sign-h1 mt-4">{$errorHeading}</h1>
<p class="switch-paragraph px-5 mb-5">Kliknij <a class="switch-link" href="/odzyskiwanie-hasla">tutaj</a>, aby wysłać ponownie prośbę o zmiane hasła</p>
<img class="token-error-img" src="img/dog.min.png" alt="pies w stroju astronauty">
HTML;
    } else {
        $fixedToken = htmlspecialchars($token);
        echo <<<HTML
        <h1 class="sign-h1">Ustal nowe hasło</h1>
        <form class="sign-form" action="/user/reset-password" method="post">
        <input type="hidden" value="$fixedToken" name="token">
        <label for="new-password" class="form-label">Nowe hasło</label>
        <input type="password" class="form-control sign-input" name="new-password">
        HTML;
        if (isset($formErrors['new-password'])) {
          echo '<p class="error text-danger">' . $formErrors['new-password'] . '</p>';
      }
              echo <<<HTML
        <label for="new-password-confirm" class="form-label">Potwierdź hasło</label>
        <input type="password" class="form-control sign-input" name="new-password-confirm">
       HTML;
       if (isset($formErrors['new-password-confirm'])) {
        echo '<p class="error text-danger">' . $formErrors['new-password-confirm'] . '</p>';
    }
       echo <<<HTML
        <div class="d-flex justify-content-end">
                <button type="submit" class="sign-btn btn btn-warning text-white">Zatwierdź nowe hasło</button>
            </div>
    </form>
HTML;
    }
    ?>
</section>
<script src="js/sign-form.min.js"></script>
</body>

</html>