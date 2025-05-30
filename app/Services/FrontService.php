<?php
// app/Services/FrontService.php

namespace App\Services;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\TicketRepositoryInterface;

class FrontService
{
    protected $categoryRepository;
    protected $ticketRepository;
    protected $sellerRepository;

    public function __construct(TicketRepositoryInterface $ticketRepository,CategoryRepositoryInterface $categoryRepository, 
    SellerRepositoryInterface $sellerRepository)
    {
        $this->categoryRepository = $categoryRepository;
        $this->ticketRepository = $ticketRepository;
        $this->sellerRepository = $sellerRepository;
    }
    public function getFrontPageData()
    {
        $categories = $this->categoryRepository->GetAllCategories();
        $sellers = $this->sellerRepository->GetAllSellers();
        $popularTickets = $this->ticketRepository->getPopularTickets(4);
        $newTickets = $this->ticketRepository->getAllNewTickets();

        return compact('categories','sellers', 'popularTickets','newTickets');
    }
}