<?php

namespace App\Repositories\Contracts;

interface TestimonialRepositoryInterface
{
    public function getApprovedTestimonials();
    public function store(array $data);
}
