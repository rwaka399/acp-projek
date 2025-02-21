<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';
    protected $primaryKey = 'task_id';



    protected $fillable = [
        'task_name',
        'status',
        'priority',
        'proses',
        'due_date',
        'end_time',
        'created_by',
    ];


    public function userTask(): HasMany
    {
        return $this->hasMany(UserTask::class, 'task_id', 'task_id');
    }

    public function taskProyek(): HasMany
    {
        return $this->hasMany(TaskProyek::class, 'task_id', 'task_id');
    }

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'user_id');
    // }

    public function proyek()
    {
        return $this->belongsToMany(Proyek::class, 'task_proyeks', 'task_id', 'proyek_id');
    }

    
}
