<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\TicketStatus;
use App\Models\TicketComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\AILog;
use App\Services\AIService;

class TicketController extends Controller
{
    public function index()
    {
        // Show board for all tickets
        return $this->board();
    }

    public function myTickets()
    {
        $statuses = TicketStatus::all();
        $ticketsByStatus = [];
        foreach ($statuses as $status) {
            $ticketsByStatus[$status->id] = Ticket::with(['user', 'assignedTo', 'category'])
                ->where('user_id', Auth::id())
                ->where('status_id', $status->id)
                ->orderBy('priority', 'desc')
                ->orderBy('created_at', 'asc')
                ->get();
        }
        return view('tickets.board', compact('statuses', 'ticketsByStatus'));
    }

    public function create()
    {
        $categories = TicketCategory::all();
        $statuses = TicketStatus::all();
        $users = User::all();
        return view('tickets.create', compact('categories', 'statuses', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'nullable|exists:ticket_categories,id',
            'priority' => 'required|string',
            'attachment' => 'nullable|file',
            'assigned_to' => 'nullable|exists:users,id',
        ]);
        $validated['user_id'] = Auth::id();
        $validated['status_id'] = TicketStatus::where('name', 'Open')->first()?->id;
        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }
        $ticket = Ticket::create($validated);
        activity()->causedBy(Auth::user())->performedOn($ticket)->log('created ticket');
        return redirect()->route('tickets.show', $ticket)->with('success', 'Ticket created successfully.');
    }

    public function show(Ticket $ticket)
    {
        $ticket->load(['user', 'category', 'status', 'comments.user', 'assignedTo']);
        // AI suggestion stub (replace with real AI call)
        $aiSuggestion = [
            'reply' => 'AI suggests: Thank you for your ticket. We are looking into your issue.',
            'solution' => 'AI suggests: Try restarting your device and checking your connection.',
            'next_action' => 'AI suggests: Assign to a senior agent for further review.',
        ];
        return view('tickets.show', compact('ticket', 'aiSuggestion'));
    }

    public function edit(Ticket $ticket)
    {
        $categories = TicketCategory::all();
        $statuses = TicketStatus::all();
        $users = User::all();
        return view('tickets.edit', compact('ticket', 'categories', 'statuses', 'users'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'nullable|exists:ticket_categories,id',
            'status_id' => 'nullable|exists:ticket_statuses,id',
            'priority' => 'required|string',
            'attachment' => 'nullable|file',
            'assigned_to' => 'nullable|exists:users,id',
        ]);
        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('attachments', 'public');
        }
        $ticket->update($validated);
        activity()->causedBy(Auth::user())->performedOn($ticket)->log('updated ticket');
        return redirect()->route('tickets.show', $ticket)->with('success', 'Ticket updated successfully.');
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        activity()->causedBy(Auth::user())->performedOn($ticket)->log('deleted ticket');
        return redirect()->route('tickets.index')->with('success', 'Ticket deleted successfully.');
    }

    public function board()
    {
        $statuses = TicketStatus::all();
        $ticketsByStatus = [];
        foreach ($statuses as $status) {
            $ticketsByStatus[$status->id] = Ticket::with(['user', 'assignedTo', 'category'])
                ->where('status_id', $status->id)
                ->orderBy('priority', 'desc')
                ->orderBy('created_at', 'asc')
                ->get();
        }
        return view('tickets.board', compact('statuses', 'ticketsByStatus'));
    }

    // AJAX endpoint: Generate description from title
    public function aiGenerateDescription(Request $request)
    {
        $request->validate(['title' => 'required|string']);
        $ai = new AIService();
        $description = $ai->suggestDescription($request->title);
        // Log
        AILog::create([
            'user_id' => $request->user()->id,
            'feature' => 'description',
            'action' => 'generate',
            'input' => $request->title,
            'output' => $description,
            'status' => 'success',
        ]);
        return response()->json(['description' => $description]);
    }

    // AJAX endpoint: Get AI suggestions for a ticket
    public function aiSuggestions(Request $request, Ticket $ticket)
    {
        $ai = new AIService();
        $suggestions = [
            'reply' => $ai->suggestReply($ticket),
            'solution' => $ai->suggestSolution($ticket),
            'next_action' => $ai->suggestNextAction($ticket),
        ];
        // Log
        foreach ($suggestions as $type => $output) {
            AILog::create([
                'user_id' => $request->user()->id,
                'feature' => $type,
                'action' => 'suggest',
                'input' => $ticket->description,
                'output' => $output,
                'related_id' => $ticket->id,
                'related_type' => Ticket::class,
                'status' => 'success',
            ]);
        }
        return response()->json($suggestions);
    }

    // AJAX endpoint: Log acceptance of AI suggestion
    public function aiAcceptSuggestion(Request $request, Ticket $ticket)
    {
        $request->validate(['feature' => 'required|string', 'output' => 'required|string']);
        AILog::create([
            'user_id' => $request->user()->id,
            'feature' => $request->feature,
            'action' => 'accept',
            'input' => $ticket->description,
            'output' => $request->output,
            'related_id' => $ticket->id,
            'related_type' => Ticket::class,
            'status' => 'accepted',
        ]);
        return response()->json(['success' => true]);
    }
}
