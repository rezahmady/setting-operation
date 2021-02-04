<?php

namespace Rezahmady\App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class SettingOperation extends Model
{
    use HasFactory;
    use CrudTrait;

    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['key', 'fields'];
    protected $fakeColumns = ['fields'];
    public $casts = [
        'fields'       => 'object',
    ];
}