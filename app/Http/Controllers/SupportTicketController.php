<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\TicketMessage;
use App\Models\TicketAttachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SupportTicketController extends Controller
{
    public function index()
    {
        $tickets = auth()->user()->supportTickets()->latest()->get();
        return view('portal.tickets.index', compact('tickets'));
    }

    public function create()
    {
        return view('portal.tickets.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'priority' => 'nullable|in:low,medium,high',
            'category' => 'nullable|string|max:100',
            'attachments.*' => 'nullable|file|mimetypes:image/*,video/*',
            'links.*' => 'nullable|url|max:2048',
        ]);

        $user = auth()->user();
        $isPremium = $user->isPremium();
        $priority = $validated['priority'] ?? ($isPremium ? 'high' : 'low');
        $sla = $isPremium ? now()->addHours(2) : now()->addHours(24);

        $ticket = $user->supportTickets()->create([
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'priority' => $priority,
            'category' => $validated['category'] ?? null,
            'sla_due_at' => $sla,
            'status' => 'open',
        ]);

        // Store uploaded attachments (no app-level size limit; server PHP limits may still apply)
        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                if (!$file) {
                    continue;
                }
                $path = $file->store('tickets', 'public');
                $mime = $file->getMimeType();
                $type = str_starts_with($mime, 'image/') ? 'image' : (str_starts_with($mime, 'video/') ? 'video' : 'file');
                $ticket->attachments()->create([
                    'user_id' => $user->id,
                    'type' => $type,
                    'path' => $path,
                    'url' => null,
                    'original_name' => $file->getClientOriginalName(),
                    'mime' => $mime,
                    'size' => $file->getSize(),
                ]);
            }
        }

        // Store external links
        if (!empty($validated['links'])) {
            foreach ($validated['links'] as $url) {
                if (!$url) {
                    continue;
                }
                $ticket->attachments()->create([
                    'user_id' => $user->id,
                    'type' => 'link',
                    'path' => null,
                    'url' => $url,
                    'original_name' => null,
                    'mime' => null,
                    'size' => null,
                ]);
            }
        }

        return redirect()->route('tickets.show', $ticket);
    }

    public function show(SupportTicket $ticket)
    {
        if ($ticket->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }
        $ticket->load('messages.user');
        return view('portal.tickets.show', compact('ticket'));
    }

    public function reply(Request $request, SupportTicket $ticket)
    {
        if ($ticket->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        $validated = $request->validate([
            'message' => 'required|string',
        ]);

        $ticket->messages()->create([
            'user_id' => auth()->id(),
            'message' => $validated['message'],
        ]);
        
        if (auth()->user()->isAdmin()) {
             $ticket->update(['status' => 'answered']);
        }

        return back();
    }
}
