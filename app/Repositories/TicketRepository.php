<?php
namespace App\Repositories;

use App\Models\Ticket;
use App\Repositories\Contracts\TicketRepositoryInterface;
use Illuminate\Suppor\Facades\DB;

class TicketRepository implements TicketRepositoryInterface 
{
    public function getPopularTickets($limit = 4)
    {
        return Ticket::where('is_popular',true)->take($limit)->get();
    }    

    public function getAllNewTickets()
    {
        return Ticket::lates()->get();
    }

    public function find($id)
    {
        return Ticket::find($id);
    }  

    public function getPrice()
    {
        $ticket = $this-> find($ticketid);
        return $ticket ? $ticket->price : 0;
    }    

       
}