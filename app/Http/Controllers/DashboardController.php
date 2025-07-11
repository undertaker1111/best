<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketStatus;

class DashboardController extends Controller
{
    public function index()
    {
        // Get status IDs
        $openStatus = TicketStatus::where('name', 'Open')->first();
        $closedStatus = TicketStatus::where('name', 'Closed')->first();
        $pendingStatus = TicketStatus::where('name', 'Pending')->first();

        $openTickets = $openStatus ? Ticket::where('status_id', $openStatus->id)->count() : 0;
        $closedTickets = $closedStatus ? Ticket::where('status_id', $closedStatus->id)->count() : 0;
        $pendingTickets = $pendingStatus ? Ticket::where('status_id', $pendingStatus->id)->count() : 0;
        $totalTickets = Ticket::count();

        return view('pages/dashboard/dashboard', compact(
            'openTickets', 'closedTickets', 'pendingTickets', 'totalTickets'
        ));
    }

    /**
     * Displays the analytics screen
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function analytics()
    {
        return view('pages/dashboard/analytics');
    }

    /**
     * Displays the fintech screen
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function fintech()
    {
        return view('pages/dashboard/fintech');
    }

    public function jsonDataFeed(Request $request)
    {
        $datatype = $request->input('datatype');
        if ($datatype == 1) { // Tickets over time (last 12 months)
            $labels = collect(range(0, 11))->map(function($i) {
                return now()->subMonths(11 - $i)->format('Y-m');
            });
            $data = $labels->map(function($label) {
                return \App\Models\Ticket::whereYear('created_at', substr($label, 0, 4))
                    ->whereMonth('created_at', substr($label, 5, 2))
                    ->count();
            });
            return response()->json([
                'labels' => $labels,
                'data' => $data,
            ]);
        } elseif ($datatype == 2) { // Tickets by status
            $statuses = \App\Models\TicketStatus::pluck('name', 'id');
            $data = $statuses->map(function($name, $id) {
                return \App\Models\Ticket::where('status_id', $id)->count();
            });
            return response()->json([
                'labels' => $statuses->values(),
                'data' => $data->values(),
            ]);
        } elseif ($datatype == 3) { // Tickets by category
            $categories = \App\Models\TicketCategory::pluck('name', 'id');
            $data = $categories->map(function($name, $id) {
                return \App\Models\Ticket::where('category_id', $id)->count();
            });
            return response()->json([
                'labels' => $categories->values(),
                'data' => $data->values(),
            ]);
        }
        return response()->json(['labels' => [], 'data' => []]);
    }
}
