<?php

namespace App\Services;

use App\Mail\LeaveStatusChange;
use App\Models\LeaveRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class LeaveRequestService {

    public function createLeave(array $data){
        return LeaveRequest::create([
            'user_id' => Auth::id(),
            'leave_type' => $data['leave_type'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'reason' => $data['reason'],
            'status' => 'pending',
        ]); 
    }

    public function updateLeave(int $id, array $data){
        $updateLeave = LeaveRequest::findOrFail($id);
        $updateLeave->update($data);
        return $updateLeave;
    }

    public function deleteLeave(int $id){
        $leaveRequest = LeaveRequest::findOrFail($id);
        $leaveRequest->delete();
    }

    public function updateLeaveStatus(int $id, string $status){
        $changeLeaveStatus = LeaveRequest::findOrFail($id);

        $changeLeaveStatus->update([
            'status' => $status,
            'approved_by' => Auth::id(),
        ]);

        Mail::to($changeLeaveStatus->user->email)->send(new LeaveStatusChange($changeLeaveStatus));

        return $changeLeaveStatus;
    }

    public function filterLeaves($filters){
        $query = LeaveRequest::query();

        if(isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if(isset($filters['date'])) {
            $query
            ->whereDate('start_date', '<=', $filters['date'])
            ->whereDate('end_date', '>=', $filters['date']);
        }

        if(Auth::user()->roles === 'employee') {
            $query->where('user_id', Auth::id());
        }
        
        return $query->with('user', 'approver')->get();
    }
}

