<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class HomeController extends Controller implements HasMiddleware
{
  public static function middleware(): array
  {
    return [
      // minden Controller action-höz rendelünk authentikációt
      'auth',
      // adott Controller action-ökhöz rendelünk authentikációt
      // new Middleware('auth', only: ['dashboard', 'profile']),
      // bizonyos Controller action-ökhöz nem rendelünk authentikációt, de a többihez igen
      // new Middleware('auth', except: ['teams']),
    ];
  }
}
