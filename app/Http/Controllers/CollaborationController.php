<?php

namespace App\Http\Controllers;

use App\Models\CollaborationRequest;
use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CollaborationController extends Controller
{
    // NF5: Request collaboration access
    public function requestCollaboration($resourceId)
    {
        try {
            $resource = Resource::findOrFail($resourceId);

            // Pre-condition: Check if user is not the resource owner
            if ($resource->uploader_id === auth()->id()) {
                return redirect()->back()->with('error', 'You cannot request collaboration on your own resource.');
            }

            // AF1: Check if request already exists
            $existingRequest = CollaborationRequest::where('resource_id', $resourceId)
                ->where('requester_id', auth()->id())
                ->first();

            if ($existingRequest) {
                if ($existingRequest->isPending()) {
                    return redirect()->back()->with('warning', 'Collaboration request already sent.');
                } elseif ($existingRequest->isApproved()) {
                    return redirect()->back()->with('info', 'You are already a collaborator on this resource.');
                }
            }

            // NF6: Create collaboration request
            CollaborationRequest::create([
                'resource_id' => $resourceId,
                'requester_id' => auth()->id(),
                'status' => 'pending',
            ]);

            // NF7: Display confirmation message
            return redirect()->back()->with('success', 'Collaboration request sent successfully!');
        } catch (\Exception $e) {
            // EF1: Network/Database error
            return redirect()->back()->with('error', 'Unable to process collaboration request. Please try again later.');
        }
    }

    // NF8-9: View pending collaboration requests (for resource owner)
    public function viewRequests()
    {
        try {
            $requests = CollaborationRequest::with(['resource', 'requester'])
                ->whereHas('resource', function ($query) {
                    $query->where('uploader_id', auth()->id());
                })
                ->where('status', 'pending')
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('collaboration.requests', compact('requests'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Unable to load collaboration requests. Please try again later.');
        }
    }

    // NF11: Approve collaboration request
    public function approveRequest($requestId)
    {
        try {
            DB::beginTransaction();

            $request = CollaborationRequest::with('resource')->findOrFail($requestId);

            // Check if current user is the resource owner
            if ($request->resource->uploader_id !== auth()->id()) {
                return redirect()->back()->with('error', 'Unauthorized access.');
            }

            // Check if already processed
            if (!$request->isPending()) {
                return redirect()->back()->with('warning', 'This request has already been processed.');
            }

            // NF12: Grant collaboration access
            $request->resource->collaborators()->attach($request->requester_id);

            // Update request status
            $request->update([
                'status' => 'approved',
                'responded_at' => now()
            ]);

            DB::commit();

            // NF13: Display success message
            return redirect()->back()->with('success', 'Collaboration request approved successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            // EF1: Network error
            return redirect()->back()->with('error', 'Unable to process collaboration request. Please try again later.');
        }
    }

    // AF2: Reject collaboration request
    public function rejectRequest($requestId)
    {
        try {
            $request = CollaborationRequest::with('resource')->findOrFail($requestId);

            // Check if current user is the resource owner
            if ($request->resource->uploader_id !== auth()->id()) {
                return redirect()->back()->with('error', 'Unauthorized access.');
            }

            // Check if already processed
            if (!$request->isPending()) {
                return redirect()->back()->with('warning', 'This request has already been processed.');
            }

            // Update request status
            $request->update([
                'status' => 'rejected',
                'responded_at' => now()
            ]);

            return redirect()->back()->with('info', 'Collaboration request rejected.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Unable to process collaboration request. Please try again later.');
        }
    }

    // View all requests (for requester)
    public function myRequests()
    {
        try {
            $requests = CollaborationRequest::with(['resource'])
                ->where('requester_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->paginate(10);

            return view('collaboration.myRequests', compact('requests'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Unable to load your requests. Please try again later.');
        }
    }

    
}
