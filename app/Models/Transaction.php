<?php

namespace App\Models;

use App\Traits\MakeUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;


class Transaction extends Model
{
    use HasFactory, Notifiable, SoftDeletes, MakeUuid;


    protected $table = 'transactions';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'transaction_date',
        'amount',
        'investment_id',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
        'transaction_date'
    ];

    protected $hidden = [
        'updated_at',
        'created_at',
        'deleted_at'
    ];

    public function investment(){
        return $this->hasOne(Investment::class, 'id', 'investment_id');
    }
}
