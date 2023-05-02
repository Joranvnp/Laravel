<?php
use Illuminate\Database\Eloquent\Model;

class Intervenant extends Model 
{
    protected $table = 'Intervenant';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = true;

    public function Conference()
    {
        return $this->belongsToMany(Conference::class, 'Animer', 
        'idInterv', 'idConf')->withPivot('nbHeures');
    }
}