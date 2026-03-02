<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SupportTicket;
use Illuminate\Http\Request;

class SupportTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tickets = SupportTicket::with('user')->latest()->paginate(10);
        return view('admin.tickets.index', compact('tickets'));
    }

    /**
     * Display the specified resource.
     */
    public function show(SupportTicket $ticket)
    {
        $ticket->load('messages.user', 'user');
        return view('admin.tickets.show', compact('ticket'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SupportTicket $ticket)
    {
        $validated = $request->validate([
            'status' => 'required|in:open,closed,answered,pending',
        ]);

        $ticket->update($validated);

        return back()->with('success', __('messages.ticket_status_updated'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SupportTicket $ticket)
    {
        $ticket->delete();
        return redirect()->route('admin.tickets.index')->with('success', __('messages.ticket_deleted'));
    }
}
