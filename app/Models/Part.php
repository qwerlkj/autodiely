<?php

namespace App\Models;

use App\Models\Scopes\AllowedFilterSearch;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory, AllowedFilterSearch;
    public $timestamps = false;
    protected $fillable = ['name', 'serialnumber', 'car_id'];

    public function car(){
        return $this->belongsTo(Car::class);
    }
}
