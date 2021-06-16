<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Protocol extends Model
{
    use HasFactory;

    protected $fillable = [
        'review_id',
        'protocol_type_id',
        'question',
        'answer',
    ];


    public function type(){
        return $this->belongsTo(ProtocolType::class);
    }

    public static function build(Protocol $protocol){
        return array(
        'type'=>$protocol->type,
        'question'=>$protocol->question,
        'answer'=>$protocol->answer,
        );
    }
}
