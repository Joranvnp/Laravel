<?php
use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    protected $table = 'Conference';
    protected $primaryKey = 'id';
    public $timestamps = false;
    public $incrementing = true;

    public function Intervenant()
    {
        return $this->belongsToMany(Intervenant::class, 'Animer', 
        'idConf', 'idInterv')->withPivot('nbHeures');
    }

}