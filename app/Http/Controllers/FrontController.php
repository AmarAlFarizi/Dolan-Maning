<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Seller;
use App\Models\Testimonial;
use App\Models\Ticket;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use App\Services\FrontService;


class FrontController extends Controller
{
    protected $frontService;

    public function __construct(FrontService $frontService)
    {
        $this->frontService = $frontService;
    }
    //konsep service repository pattern
    public function index()
    {

        $data = $this->frontService->getFrontPageData();
        // dd($data);
        return view('front.index', $data);
    }
    //model binding

    public function details(Ticket $ticket)
    {
        // dd($ticket);
        return view('front.details', compact('ticket'));
    }

    public function booking(Ticket $ticket)
    {
        return view('front.booking', compact('category'));
    }

    public function category(Category $category)
    {
        // dd($category);
        return view('front.category', compact('category'));
    }
    public function explore(Seller $seller)
    {
        // dd($category);
        return view('front.seller', compact('seller'));
    }

    public function testimoni()
    {
        $testimonials = $this->frontService->getTestimonials();
        return view('front.testimoni', compact('testimonials'));
    }

    // public function storeTestimonial(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:100',
    //         'origin' => 'nullable|string|max:100',
    //         'message' => 'required|string|max:1000',
    //         'rating' => 'nullable|integer|min:1|max:5',
    //     ]);

    //     $this->frontService->storeTestimonial($validated);

    //     return redirect()->back()->with('success', 'Ulasanmu berhasil dikirim. Menunggu persetujuan admin.');
    // }
    // public function storeTestimonial(Request $request)
    // {
    //     $validated = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'origin' => 'nullable|string|max:255',
    //         'message' => 'required|string',
    //         'rating' => 'nullable|integer|min:1|max:5',
    //     ]);

    //     try {
    //         Testimonial::create([
    //             'name' => $validated['name'],
    //             'origin' => $validated['origin'] ?? null,
    //             'message' => $validated['message'],
    //             'rating' => $validated['rating'] ?? null,
    //             'is_approved' => false,
    //         ]);

    //         return redirect()->route('front.testimoni')->with('success', 'Testimoni berhasil dikirim.');
    //     } catch (\Exception $e) {
    //         Log::error('Testimonial submission error: ' . $e->getMessage());
    //         return back()->withErrors(['error' => 'Gagal menyimpan testimoni. Silakan coba lagi.']);
    //     }
    // }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'origin' => 'nullable|string|max:255',
                'message' => 'required|string',
                'rating' => 'nullable|integer|min:1|max:5',
                'gender' => 'nullable|string|in:male,female',
            ]);

            Testimonial::create($validated);

            return redirect()->back()->with('success', 'Ulasan berhasil dikirim! Tunggu admin menyetujui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function support()
    {
        return view('front.support');
    }
}
