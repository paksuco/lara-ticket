<?php

namespace Sdkcodes\LaraTicket\Traits;

use App\User;
use Sdkcodes\LaraTicket\Models\Ticket;

trait UserTicket
{
    public function isTicketAdmin()
    {
        return $this->hasRole("admin");
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class)->latest();
    }

    public function countTickets($status = "all")
    {
        if ($status === "all") {
            return $this->hasMany(Ticket::class)->count();
        }
        return $this->hasMany(Ticket::class)->where('status', $status)->count();
    }

    public function getTicketAdmins()
    {
        return User::role('admin')->get();
    }
}
