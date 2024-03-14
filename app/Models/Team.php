<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Team extends Model
{
  protected $fillable = [
    'title',
    'description',
  ];
  public function users(): HasMany
  {
      return $this->hasMany(User::class, 'foreign-key');
  }
}
