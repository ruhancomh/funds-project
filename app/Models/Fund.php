<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fund extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'start_year', 'fund_manager_id'];

    public function fundManager(): BelongsTo
    {
        return $this->belongsTo(FundManager::class);
    }
}
