<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChequeGarantie extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'contact_id',
        'cheque_echeance',
        'cheque_number',
        'amount',
        'cheque_status',
        'cheque_dateP',
        // Ajoutez d'autres colonnes que vous souhaitez permettre pour le mass-assignment
    ];

    public function client()
    {
        return $this->belongsTo(Contact::class, 'contact_id');
    }
}
