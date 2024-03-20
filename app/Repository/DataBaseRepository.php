<?php

namespace App\Repository;

use Illuminate\Support\Facades\DB;


class DataBaseRepository
{
  public function makeTransaction(callable $callable)
  {
    DB::transaction(function () use ($callable) {
      $callable();
    });
  }
}
