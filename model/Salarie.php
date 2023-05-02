<?php
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Salarie extends Model
{
    protected $table = 'Salarie';
    protected $primaryKey = 'idInterv';
    protected $keyType = 'int';
    public $timestamps = false;

    public $incrementing = false;

    public function Intervenant(): BelongsToMany
    {
        return $this->belongsToMany(Intervenant::class, "id", "idInterv");
    }
}