<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TaskProyek extends Model
{
    use HasFactory;
    protected $primaryKey = 'task_proyek_id';


    protected $fillable = [
        'task_id',
        'proyek_id',
    ];
    
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class, 'task_id', 'task_id');
    }

    public function proyek(): BelongsTo
    {
        return $this->belongsTo(Proyek::class, 'proyek_id', 'proyek_id');
    }
}
