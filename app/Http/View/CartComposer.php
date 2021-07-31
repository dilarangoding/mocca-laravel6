<?php

namespace App\Http\View;

use Illuminate\View\View;

class CartComposer
{

  public function compose(View $view)
  {
    $carts = json_decode(request()->cookie('mocca-carts'), true);
    $carts = collect($carts)->count(function ($i) {
      return $i;
    });

    $view->with('carts', $carts);
  }
}
