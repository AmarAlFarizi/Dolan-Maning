<?php
// app/Services/FrontService.php

namespace App\Services;

use App\Repositories\Contracts\CategoryRepositoryInterface;
use App\Repositories\Contracts\TicketRepositoryInterface;
use App\Repositories\Contracts\SellerRepositoryInterface;
use App\Repositories\Contracts\TestimonialRepositoryInterface;



class FrontService
{
    protected $categoryRepository;
    protected $ticketRepository;
    protected $sellerRepository;
    protected $testimonialRepository;


    public function __construct(
        TicketRepositoryInterface $ticketRepository,
        CategoryRepositoryInterface $categoryRepository,
        SellerRepositoryInterface $sellerRepository,
        TestimonialRepositoryInterface $testimonialRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->ticketRepository = $ticketRepository;
        $this->sellerRepository = $sellerRepository;
        $this->testimonialRepository = $testimonialRepository;
    }
    public function getFrontPageData()
    {
        $categories = $this->categoryRepository->GetAllCategories();
        foreach ($categories as $category) {
            if (!empty($category->image)) {
                $category->image = '/storage/' . ltrim($category->image, '/');
            }
        }

        $sellers = $this->sellerRepository->GetAllSellers();
        foreach ($sellers as $seller) {
            if (!empty($seller->photo)) {
                $seller->photo = '/storage/' . ltrim($seller->photo, '/');
            }
        }

        $popularTickets = $this->ticketRepository->getPopularTickets(4);
        foreach ($popularTickets as $ticket) {
            if (!empty($ticket->thumbnail)) {
                $ticket->thumbnail = '/storage/' . ltrim($ticket->thumbnail, '/');
            }
        }

        $newTickets = $this->ticketRepository->getAllNewTickets();
        foreach ($newTickets as $ticket) {
            if (!empty($ticket->thumbnail)) {
                $ticket->thumbnail = '/storage/' . ltrim($ticket->thumbnail, '/');
            }
        }

        return compact('categories', 'sellers', 'popularTickets', 'newTickets');
    }

    public function getTestimonials()
    {
        return $this->testimonialRepository->getApprovedTestimonials();
    }


    public function storeTestimonial(array $data)
    {
        return $this->testimonialRepository->store($data);
    }
}
