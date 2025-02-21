<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proyek extends Model
{
    use HasFactory;

    protected $primaryKey = 'proyek_id';

    protected $fillable = [
        'proyek_name',
        'proyek_description',
        'created_by',
        'updated_by',
    ];

    public function taskProyek()
    {
        return $this->hasMany(TaskProyek::class, 'proyek_id', 'proyek_id');
    }
}
