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
        'task_description',
        'status',
        'priority',
        'proses',
        'due_date',
        'end_time',
    ];


    public function userTask(): HasMany 
    {
        return $this->hasMany(UserTask::class, 'task_id', 'task_id');
    }

    public function taskProyek(): HasMany 
    {
        return $this->hasMany(TaskProyek::class, 'task_id', 'task_id');
    }


}
