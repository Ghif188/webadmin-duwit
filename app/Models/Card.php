<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    protected $table = 'cards';
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'cvv',
    ];

    /**
     * Relation table
     *
     */
    public function pocket()
    {
        return $this->belongsTo(Pocket::class, 'pocket_id');
    }

    public function cardPatner()
    {
        return $this->hasOne(CardPatner::class, 'card_id');
    }
     
    /**
     * Scope models
     *
     */
}
