<?php

use App\Http\Middleware\MyFirstMiddleware;
use App\Http\Middleware\MySecondMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
  ->withRouting(
    web: __DIR__ . '/../routes/web.php',
    api: __DIR__ . '/../routes/api.php',
    commands: __DIR__ . '/../routes/console.php',
    health: '/up',
    apiPrefix: 'api/v1'
  )
  ->withMiddleware(function (Middleware $middleware) {
    // Alias név regisztrálása, hogy könnyebben hozzá lehessen adni útvonalakhoz/útvonal csoportokhoz a köztes réteget
    $middleware->alias([
      'some_key' => MyFirstMiddleware::class,
    ]);

    // Hozzáadás a rétegek végére egyesével
    $middleware->append(MyFirstMiddleware::class);

    // Beillesztések a meglévő rétegek elé
    $middleware->prepend([
      MyFirstMiddleware::class,
      MySecondMiddleware::class,
    ]);

    // Regisztrált réteg eltávolítása egyesével
    $middleware->remove(\Illuminate\Http\Middleware\ValidatePostSize::class);
    // Több regisztrált réteg eltávolítása
    $middleware->remove([
      \Illuminate\Http\Middleware\TrustProxies::class,
      \Illuminate\Http\Middleware\HandleCors::class,
    ]);

    // Egy konkrét réteg hozzáadása a web Middleware csoporthoz
    $middleware->appendToGroup('web', MyFirstMiddleware::class);

    // web-es Middleware csoporthoz való hozzáadás (append) így:
    $middleware->web([MyFirstMiddleware::class, MySecondMiddleware::class]);

    $middleware->redirectGuestsTo('/login');
  })
  ->withExceptions(function (Exceptions $exceptions) {
    //
  })->create();
