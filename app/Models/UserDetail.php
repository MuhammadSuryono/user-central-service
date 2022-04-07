<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserDetail extends \Illuminate\Database\Eloquent\Model
{
    use HasFactory;

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo('App\Models\User');
    }

    public function division()
    {
        return $this->belongsTo('App\Models\Division', 'division_id');
    }

    public function position()
    {
        return $this->belongsTo('App\Models\Position', 'position_id');
    }

    public function level()
    {
        return $this->belongsTo('App\Models\Level', 'level_id');
    }
}
