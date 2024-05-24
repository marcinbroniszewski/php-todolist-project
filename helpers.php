<?php

declare(strict_types=1);

function basePath(string $path = ''): string
{
    return __DIR__ . '/' . $path;
}

function loadView(string $name, array $data = []): void
{
    $viewPath =  basePath("App/views/{$name}.view.php");

    if (file_exists($viewPath)) {
        extract($data, EXTR_SKIP);

        require $viewPath;
    } else {
        echo "View '{$name} not found!'";
    }
}

function loadPartial(string $name): void
{
    $partialPath =  basePath("App/views/partials/{$name}.php");

    if (file_exists($partialPath)) {
        require $partialPath;
    } else {
        echo "Partial '{$name} not found!'";
    }
}

 function dd(mixed $value): void {
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
    die();
 }
