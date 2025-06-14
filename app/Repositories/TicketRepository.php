<?php

namespace App\Repositories;

use App\Models\Ticket;
use App\Repositories\Contracts\TicketRepositoryInterface;
use Illuminate\Suppor\Facades\DB;

class TicketRepository implements TicketRepositoryInterface
{
    public function getPopularTickets($limit = 4)
    {
        return Ticket::where('is_popular', true)
            ->orderBy('created_at', 'desc')
            ->take($limit)
            ->get();
    }

    public function getAllNewTickets()
    {
        return Ticket::latest()->get();
    }

    public function find($id)
    {
        return Ticket::find($id);
    }

    public function getPrice($ticketId)
    {
        $ticket = $this->find($ticketId);
        return $ticket ? $ticket->price : 0;
    }
}
