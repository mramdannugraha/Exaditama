<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Recordgames extends Model
{
    public $timestamps = false;
    protected $table='recordgames';
    protected $fillable=['clubhomename','clubawayname','score'];
}
