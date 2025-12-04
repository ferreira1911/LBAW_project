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

        $reports = Report::whereIn('status',['InReview','Pending'])
            ->where('auction_id',$request->query('auction_id'))
            ->where('user_id', Auth::user()->id)
            ->exists();
        // this will block any users that want to create another report on an auction that they already reported
        if($reports){
            return redirect()->back()->with('success','You already have a report for this Auction');
        }
        return view('pages.reports.create', [
            'auction_id' => $request->query('auction_id'),
            'reported_user_id' => $request->query('reported_user_id')
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

            
            return redirect()->route('auctions.show', $validated['auction_id'])
                ->with('success', 'Report submitted successfully.');
            
        } catch (QueryException $e) {
            

            $cleanMessage = 'An error occurred while submitting the report.';

            if (isset($e->errorInfo[2]) && preg_match('/ERROR:\s*(.*?)(?:\n|$)/', $e->errorInfo[2], $matches)) {
                $cleanMessage = $matches[1];
            }
            return back()->withInput()->withErrors(['description' => $cleanMessage]);
        }
    }

    public function viewReports()
    {
        $this->authorize('viewAny', Report::class);

        $reports = Report::where('status','Pending')
            ->orderBy('create_date','desc')
            ->paginate(10);

        return view('pages.reports.myReports', compact('reports'));
    }

    public function index()
    {
        $this->authorize('viewAny', Report::class);

        $reports = Report::with(['reporter', 'reportedUser', 'auction'])
            ->orderBy('create_date', 'desc')
            ->paginate(15);

        return view('pages.reports.index', compact('reports'));
    }

    /**
     * Assign the current admin to the report and update status.
     */
    public function assign(Request $request, Report $report)
    {
        // This policy check should ensure only Admins can perform this
        $this->authorize('assign', Report::class);

        $report->update([
            'admin_id' => Auth::id(),
            'status' => ReportStatus::InReview,
        ]);

        return back()->with('success', 'Report assigned to you successfully.');
    }

    public function dismiss(Request $request, Report $report)
    {
        // This policy check should ensure only Admins can perform this
        $this->authorize('dismiss', Report::class);

        $report->update([
            'status' => ReportStatus::Dismissed,
        ]);

        return back()->with('success', 'Report was Dismissed.');
    }

    public function finish(Request $request, Report $report)
    {
        // This policy check should ensure only Admins can perform this
        $this->authorize('assign', Report::class);

        $report->update([
            'status' => ReportStatus::Resolved,
        ]);

        return back()->with('success', 'Report was Resolved.');
    }


}