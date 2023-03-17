<?php

namespace App\Models;

use App\Models\Scopes\AllowedFilterSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    use HasFactory, AllowedFilterSearch;
    public $timestamps = false;
    protected $fillable = ['name', 'registration_number', 'is_registered'];

    public function parts(): HasMany{
        return $this->hasMany(Part::class);
    }
}
