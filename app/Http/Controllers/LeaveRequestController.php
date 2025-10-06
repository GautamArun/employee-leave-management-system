<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeaveStoreRequest;
use App\Http\Requests\LeaveUpdateRequest;
use App\Http\Resources\LeaveRequestResource;
use App\Models\LeaveRequest;
use App\Services\LeaveRequestService;
use Illuminate\Http\Request;

class LeaveRequestController extends Controller
{
    public function __construct(private LeaveRequestService $service){}

    public function index(Request $request){
        $leaves = $this->service->filterLeaves($request->all());
        return LeaveRequestResource::collection($leaves);
    }

    public function store(LeaveStoreRequest $request){
        $leave = $this->service->createLeave($request->validated());
        return new LeaveRequestResource($leave);
    }

    public function update(LeaveUpdateRequest $request, int $id){
        $leave = $this->service->updateLeave($id, $request->validated());
        return new LeaveRequestResource($leave);
    }

    public function destroy(int $id){
        $this->service->deleteLeave($id);
        return response()->json(['message' => 'Leave deleted successfully']);
    }

    public function updateStatus(Request $request, int $id){
        $request->validate(['status' => 'required|in:approved,rejected']);
        $leave = $this->service->updateLeaveStatus($id, $request->status);
        return new LeaveRequestResource($leave);
    }


}
