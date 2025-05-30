<?php
namespace App\Repositories\Contracts;

Interface TicketRepositoryInterface
{
    public function getPopularTickets($limit);
    public function getAllNewTickets();
    public function find($id);
    public function getPrice($ticketId);

}