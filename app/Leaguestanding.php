<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Leaguestanding extends Model
{
    public $timestamps = false;
    protected $table = 'leaguestandings';
    protected $fillable = ['clubname','points'];

}
