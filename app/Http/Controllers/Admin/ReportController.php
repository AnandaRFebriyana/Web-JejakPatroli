<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        $query = Report::with('guardRelation')->orderBy('created_at', 'desc');

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                // Search by guard name
                $q->whereHas('guardRelation', function($q) use ($search) {
                    $q->where('name', 'like', '%' . $search . '%');
                });
                
                // Search by date
                $dateFormats = [
                    'd/m/Y', 'd-m-Y', 'Y-m-d', 'Y/m/d',
                    'd M Y', 'd F Y', 'M d Y', 'F d Y'
                ];
                
                foreach ($dateFormats as $format) {
                    try {
                        $searchDate = Carbon::createFromFormat($format, $search);
                        if ($searchDate) {
                            $q->orWhereDate('created_at', $searchDate->format('Y-m-d'));
                            break;
                        }
                    } catch (\Exception $e) {
                        continue;
                    }
                }
            });
        }

        return view('pages.report.report', [
            'title'=> 'Laporan',
            'reports' => $query->paginate(6)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report) {
        $report = Report::findOrFail($report->id);
        
        return view('pages.report.show', [
            'title' => 'Laporan',
            'report' => $report,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        //
    }
}
