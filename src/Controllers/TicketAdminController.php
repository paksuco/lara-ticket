<?php

namespace Sdkcodes\LaraTicket\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Sdkcodes\LaraTicket\Events\TicketClosed;
use Sdkcodes\LaraTicket\Events\TicketDeleted;
use Sdkcodes\LaraTicket\Events\TicketReplied;
use Sdkcodes\LaraTicket\Models\Ticket;
use Sdkcodes\LaraTicket\Models\TicketComment;

class TicketAdminController extends Controller
{
    protected $perPage = "";

    public function __construct()
    {
        $this->perPage = config('laraticket.per_page');
    }

    public function index($status = "open")
    {
        $tickets = Ticket::where('status', $status)->latest()->paginate($this->perPage);
        $data['title'] = $data['breadcrumb'] = "Tickets";
        $data['tickets'] = $tickets;
        $data['open_count'] = Ticket::countTickets("open");
        $data['closed_count'] = Ticket::countTickets("closed");
        return view('laraticket::admin.tickets', $data);
    }

    public function show($slug)
    {
        $ticket = Ticket::where('slug', $slug)->firstOrFail();
        $data['title'] = $ticket->title;
        $data['breadcrumb'] = "View Ticket";
        $data['ticket'] = $ticket;
        return view('laraticket::admin.view', $data);
    }

    public function reply(Request $request, $id)
    {
        /** @var \App\User $user */
        $user = Auth::user();
        $this->validate($request, ['content' => 'required']);
        $ticket = Ticket::findOrFail($id);
        if ($user->isTicketAdmin()) {
            $comment = new TicketComment;
            $comment->user_id = $user->id();
            $comment->ticket_id = $id;
            $comment->body = $request->content;
            $comment->save();
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

        $this->validate($request, [
            'action' => 'required']); //set array rule to check if action is correct

        $ticket = Ticket::findOrFail($id);
        $action = $request->action;

        if ($user->isTicketAdmin()) {
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
        if ($user->isTicketAdmin()) {
            event(new TicketDeleted($ticket));
            $ticket->delete();
            return redirect(url('tickets'))->with(['status' => 'info', 'message' => 'Ticket deleted']);
        } else {
            return redirect(url('tickets'))->with(['status' => 'info', "message" => "You do not have permission to delete this ticket"]);
        }
    }
}
