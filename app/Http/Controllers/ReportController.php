<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Enums\ReportStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;

class ReportController extends Controller
{
    public function create(Request $request)
    {
        $this->authorize('create',Report::class);

        $userId = Auth::id();
        $auctionId = $request->query('auction_id');
        $reportedUserId = $request->query('reported_user_id');

        $query = Report::whereIn('status', ['InReview', 'Pending'])
                   ->where('user_id', $userId);
        
        if ($auctionId) {
            $query->where('auction_id', $auctionId);
        }else if ($reportedUserId) {
            $query->where('reported_user_id', $reportedUserId);
        }

        if($query->exists()){
            return redirect()->back()->with('success','You already have a report for this Auction/User');
        }
        
        return view('pages.reports.create', [
            'auction_id' => $auctionId,
            'reported_user_id' => $reportedUserId
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Report::class);

        $validated = $request->validate([
            'description' => ['required', 'string', 'max:1000'],
            'auction_id' => ['nullable', 'integer', 'exists:auction,id'],
            'reported_user_id' => ['nullable', 'integer', 'exists:users,id'],
        ]);

        $validated['user_id'] = Auth::id();
        $validated['status'] = ReportStatus::Pending;

        try {
            
            Report::create($validated);

            
            if (!empty($validated['auction_id'])) {
                return redirect()->route('auctions.show', $validated['auction_id'])
                    ->with('success', 'Report submitted successfully.');
            } else {
                return redirect()->route('users.show', $validated['reported_user_id'])
                    ->with('success', 'Report submitted successfully.');
            }
            
        } catch (QueryException $e) {
            

            $cleanMessage = 'An error occurred while submitting the report.';

            if (isset($e->errorInfo[2]) && preg_match('/ERROR:\s*(.*?)(?:\n|$)/', $e->errorInfo[2], $matches)) {
                $cleanMessage = $matches[1];
            }
            return back()->withInput()->withErrors(['description' => $cleanMessage]);
        }
    }

    public function index()
    {
        $this->authorize('viewAny', Report::class);

        $reports = Report::with(['reporter', 'reportedUser', 'auction'])
            ->orderBy('create_date', 'desc')
            ->paginate(15);

        return view('pages.reports.index', compact('reports'));
    }

    public function indexAssigned()
    {
        $this->authorize('viewAny', Report::class);

        $reports = Report::with(['reporter', 'reportedUser', 'auction'])
            ->where('admin_id', Auth::id())
            ->orderBy('create_date', 'desc')
            ->paginate(15);

        return view('pages.reports.myReports', compact('reports'));
    }

    /**
     * Assign the current admin to the report and update status.
     */
    public function assign(Request $request, Report $report)
    {
        // This policy check should ensure only Admins can perform this
        $this->authorize('assign', $report);

        $report->update([
            'admin_id' => Auth::id(),
            'status' => ReportStatus::InReview,
        ]);

        return redirect()->route('admin.myReports')
            ->with('success', 'Report assigned to you successfully.');
    }

    public function dismiss(Request $request, Report $report)
    {
        // This policy check should ensure only Admins can perform this
        $this->authorize('dismiss', $report);

        $report->update([
            'status' => ReportStatus::Dismissed,
        ]);

        return back()->with('success', 'Report was Dismissed.');
    }

    public function resolve(Request $request, Report $report)
    {
        // This policy check should ensure only Admins can perform this
        $this->authorize('resolve', $report);

        $report->update([
            'status' => ReportStatus::Resolved,
        ]);

        return back()->with('success', 'Report was Resolved.');
    }

    function show(Report $report) {
        $this->authorize('view', $report);

        $report = Report::with(['reporter', 'reportedUser', 'auction', 'admin'])
            ->find($report->id);

        return view('pages.reports.show', compact('report'));
    }


}