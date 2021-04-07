<?php

namespace Sdkcodes\LaraTicket\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Sdkcodes\LaraTicket\Events\TicketClosed;
use Sdkcodes\LaraTicket\Events\TicketDeleted;
use Sdkcodes\LaraTicket\Events\TicketReplied;
use Sdkcodes\LaraTicket\Events\TicketSubmitted;
use Sdkcodes\LaraTicket\Models\Ticket;
use Sdkcodes\LaraTicket\Models\TicketComment;
use Sdkcodes\LaraTicket\Models\TicketOption;

class TicketController extends Controller
{
    protected $perPage = "";

    public function __construct()
    {
        $this->perPage = config('laraticket.per_page');
    }

    public function index($status = "open")
    {
        /** @var \App\User $user */
        $user = Auth::user();

        $tickets = $user->tickets()->where('status', $status)->paginate($this->perPage);
        $data['title'] = $data['breadcrumb'] = "Tickets";
        $data['tickets'] = $tickets;
        $data['open_count'] = $user->countTickets("open");
        $data['closed_count'] = $user->countTickets("closed");
        return view('laraticket::user_tickets', $data);
    }

    public function show($slug)
    {
        $ticket = Ticket::where('slug', $slug)->firstOrFail();
        $data['title'] = $ticket->title;
        $data['breadcrumb'] = "View Ticket";
        $data['ticket'] = $ticket;
        return view('laraticket::view', $data);
    }

    public function create()
    {
        $ticket_options = new TicketOption;
        $data['categories'] = $ticket_options->getCategories();
        $data['priorities'] = $ticket_options->getPriorities();
        $data['breadcrumb'] = $data['title'] = "Create new ticket";

        return view('laraticket::create', $data);
    }
    public function store(Request $request)
    {
        /** @var \App\User $user */
        $user = Auth::user();

        $request->validate(
            [
                'title' => 'required|string|max:255',
                'body' => 'required',
                'priority' => 'required|string|max:30',
                'category' => 'required|string|max:30',
            ]
        );
        $ticket = new Ticket;
        $ticket->user_id = $user->id;
        $ticket->user_name = $user->name;
        $ticket->title = $request->title;
        $ticket->slug = Str::slug($request->title) . Str::random(4);
        $ticket->body = $request->body;
        $ticket->priority = $request->priority;
        $ticket->category = $request->category;
        $ticket->status = "open";
        $ticket->save();
        $notification_data = ['message' => $user->name . " submitted a ticket", "url" => url("tickets/show/$ticket->slug")];
        // Notification::send( (new User)->getTicketAdmins(), new TicketNotification($ticket, $notification_data));
        event(new TicketSubmitted($ticket));
        return redirect(url('tickets'))->with(['status' => 'success', 'message' => 'Ticket created, you will be notified when there\'s a reply']);
    }

    public function reply(Request $request, $id)
    {
        /** @var \App\User $user */
        $user = Auth::user();

        $request->validate(['content' => 'required']);

        $ticket = Ticket::findOrFail($id);

        if ($ticket->user_id === $user->id) {
            $comment = new TicketComment;
            $comment->user_id = $user->id;
            $comment->ticket_id = $id;
            $comment->body = $request->content;
            $comment->save();
            $ticket->touch();
            event(new TicketReplied($comment));
            return back()->with(['status' => 'success', 'message' => "Comment submitted successfully"]);
        } else {
            return back()->with(['status' => 'info', 'message' => "You do not have permission to update this ticket"]);
        }
    }

    public function changeStatus(Request $request, $id)
    {
        /** @var \App\User $user */
        $user = Auth::user();

        $request->validate([
            'action' => 'required']); //set array rule to check if action is correct
        $ticket = Ticket::findOrFail($id);
        $action = $request->action;

        if ($ticket->user_id === $user->id) {
            switch ($action) {
                case 'open':
                    $ticket->status = "open";
                    break;
                case 'close':
                    $ticket->status = "closed";
                    $ticket->date_closed = Carbon::now();
                    break;
                default:
                    $ticket->status = "close";
                    $ticket->date_closed = Carbon::now();
                    break;
            }
            $ticket->save();
            event(new TicketClosed($ticket));
            return back()->with(['status' => 'success', 'message' => "Ticket status updated successfully"]);
        } else {
            return back()->with(['status' => 'success', 'message' => "You do not have permission to update this ticket"]);
        }
    }

    public function delete($ticket)
    {
        /** @var \App\User $user */
        $user = Auth::user();

        $ticket = Ticket::findOrFail($ticket);
        if ($ticket->user_id === $user->id) {
            event(new TicketDeleted($ticket));
            $ticket->delete();
            return redirect(url('tickets'))->with(['status' => 'info', 'message' => 'Ticket deleted']);
        } else {
            return redirect(url('tickets'))->with(['status' => 'info', "message" => "You do not have permission to delete this ticket"]);
        }
    }
}
