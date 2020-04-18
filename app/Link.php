<?php

namespace App;

use App\Events\LinkCreatingEvent;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'redirect_to', 'user_id', 'undead', 'dead_time'
    ];


    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'creating' => LinkCreatingEvent::class,
    ];

    public function history()
    {
        return $this->hasMany(History::class, 'link_id', 'id')->orderBy('created_at', 'desc');
    }

}
