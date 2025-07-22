<?php

namespace App\Repositories;

use App\Models\Testimonial;
use App\Repositories\Contracts\TestimonialRepositoryInterface;

class TestimonialRepository implements TestimonialRepositoryInterface
{
    public function getApprovedTestimonials()
    {
        return Testimonial::where('is_approved', true)->latest()->get();
    }

    public function store(array $data)
    {
        return Testimonial::create($data);
    }
}
