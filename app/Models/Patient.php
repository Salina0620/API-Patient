<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = ['age', 'gender', 'address', 'phone_no', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
