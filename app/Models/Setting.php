<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $table = 'settings';
    protected $fillable = ['no_whatsapp'];
    public $timestamps = false; // Karena tabel settings tidak punya kolom created_at & updated_at
}