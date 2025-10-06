<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    protected $table = 'leave_requests';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'leave_type',
        'start_date',
        'end_date',
        'reason',
        'status',
        'approved_by',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function approver(){
        return $this->belongsTo(User::class, 'approved_by');
    }
}
