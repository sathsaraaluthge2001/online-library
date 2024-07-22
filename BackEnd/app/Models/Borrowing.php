<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    
    protected $table = 'borrowings';

    // Define the primary key if it's not 'id'
    protected $primaryKey = 'id';

    // Specify which attributes should be mass assignable
    protected $fillable = [
        'bookid',
        'useremail',
        'booktitle',
    ];

    // If you want to disable the timestamps feature
    public $timestamps = true;

    
}
