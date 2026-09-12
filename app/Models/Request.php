<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_id',
        'requester_name',
        'contact_number',
        'document_id',
        'copies',
        'fee',
        'reason',
        'pickup_date',
        'valid_id_path',
        'status',
    ];

    protected $casts = [
        'pickup_date' => 'date',
        'copies' => 'integer',
    ];

    public function document()
    {
        return $this->belongsTo(Document::class, 'document_id', 'document_id');
    }
}