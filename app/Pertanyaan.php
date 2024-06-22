<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pertanyaan extends Model
{
    protected $table = 'pertanyaans';
    protected $fillable = ['text_payload', 'label_type', 'text_input', 'user_id'];
}
