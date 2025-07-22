<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dolan Maning - Testimoni</title>
    <link href="{{ asset('output.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <!-- <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script> -->
    <style>
        .testimonial-slider-wrapper {
            overflow-x: hidden;
            padding: 0 1rem;
        }

        .testimonial-slider {
            scroll-behavior: smooth;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

        .testimonial-slider::-webkit-scrollbar {
            display: none;
        }

        .slide-item {
            min-width: 280px;
            max-width: 320px;
        }

        @media (max-width: 400px) {
            .slide-item {
                min-width: 260px;
                max-width: 280px;
            }
        }

        .slider-indicator {
            transition: all 0.3s ease;
        }

        .slider-indicator.active {
            background-color: #F97316;
            width: 24px;
        }
    </style>
</head>

<body>
    <div class="relative flex flex-col w-full min-h-screen max-w-[640px] mx-auto bg-white">
        {{-- Top Navigation --}}
        <div class="flex items-center justify-between w-full px-4 mt-[20px]">
            <a href="{{route('front.index')}}">
                <img src="{{ asset('assets/images/logos/logo-hitam.png') }}" alt="Logo" class="h-10 w-auto">
            </a>
            <a href="#">
                <img src="{{ asset('assets/images/icons/heart-fill.svg') }}" class="w-12 h-12" alt="icon">
            </a>
        </div>

        <main class="flex-1 flex flex-col gap-5 mt-5 px-4 overflow-y-auto pb-40">
            <!-- flash message -->
            @if (session('success'))
            <div class="bg-green-100 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
            @endif

            @if (session('error'))
            <div class="bg-red-100 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
            @endif

            <section id="Testimonials" class="flex flex-col gap-4" x-data="testimonialSlider()">
                <div class="flex items-center justify-between">
                    <h2 class="font-bold text-xl">Apa Kata Mereka?</h2>
                    <div class="flex items-center gap-2">
                        <button @click="prevSlide()" class="p-2 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </button>
                        <button @click="nextSlide()" class="p-2 rounded-full bg-gray-100 hover:bg-gray-200 transition-colors">
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Testimonial Slider -->
                <div class="relative testimonial-slider-wrapper">
                    <div
                        x-ref="slider"
                        class="testimonial-slider flex gap-4 overflow-x-auto px-1"
                        @scroll="updateIndicators()"
                        @touchstart="startTouch($event)"
                        @touchmove="moveTouch($event)"
                        @touchend="endTouch($event)">

                        @foreach($testimonials as $testimonial)
                        @php
                        $avatarNumber = $loop->iteration % 3 + 1;
                        @endphp
                        <div class="slide-item flex flex-col gap-2 p-4 rounded-2xl bg-[#F8F8F9] shadow-sm flex-shrink-0">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-full bg-gray-300 overflow-hidden">
                                    <img src="{{ asset('assets/images/backgrounds/avatar-'.$avatarNumber.'.webp') }}" alt="avatar" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h3 class="font-semibold text-sm">{{ $testimonial->name }}</h3>
                                    <p class="text-xs text-gray-500">{{ $testimonial->origin ?? '-' }}</p>
                                </div>
                            </div>
                            <p class="text-sm text-gray-700 leading-relaxed mt-1">"{{ $testimonial->message }}"</p>
                            @if($testimonial->rating)
                            <div class="flex items-center gap-1 mt-2">
                                @for ($i = 0; $i < $testimonial->rating; $i++)
                                    <img src="{{ asset('assets/images/icons/Star 1.svg') }}" class="w-4 h-4" alt="star">
                                    @endfor
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    <!-- Slider Indicators -->
                    <div class="flex justify-center gap-2 mt-4">
                        <template x-for="(indicator, index) in indicators" :key="index">
                            <button
                                @click="goToSlide(index)"
                                class="slider-indicator h-2 bg-gray-300 rounded-full cursor-pointer"
                                :class="indicator.active ? 'active w-6' : 'w-2'"></button>
                        </template>
                    </div>
                </div>
            </section>

            <section class="flex flex-col mt-8 border-t pt-6 pb-40">
                <h3 class="text-lg font-bold mb-3">Tulis Ulasanmu</h3>
                <form method="POST" action="{{ route('testimonial.store') }}" class="flex flex-col gap-3" x-data="{ selectedGender: 'male' }">
                    @csrf
                    <input type="text" name="name" placeholder="Nama" required class="rounded-xl border px-3 py-2 text-sm">
                    <input type="text" name="origin" placeholder="Asal (opsional)" class="rounded-xl border px-3 py-2 text-sm">
                    <div class="flex items-center gap-4 text-sm">
                        <label class="flex items-center gap-1">
                            <input type="radio" name="gender" value="male" class="gender-radio" checked>
                            Laki-laki
                        </label>
                        <label class="flex items-center gap-1">
                            <input type="radio" name="gender" value="female" class="gender-radio">
                            Perempuan
                        </label>
                    </div>
                    <textarea name="message" placeholder="Pesan" required rows="3" class="rounded-xl border px-3 py-2 text-sm"></textarea>
                    <select name="rating" class="rounded-xl border px-3 py-2 text-sm">
                        <option value="">Pilih Rating (opsional)</option>
                        @for ($i = 1; $i <= 5; $i++)
                            <option value="{{ $i }}">{{ $i }} ⭐️</option>
                            @endfor
                    </select>
                    <button type="submit"
                        class="w-full rounded-full p-[14px_20px] text-white text-center bg-[#F97316] font-bold">
                        Kirim Testimoni
                    </button>
                </form>
            </section>
        </main>
        <nav id="Bottom-Nav" class="fixed bottom-0 w-full max-w-[640px] bg-white px-4 py-5 z-30">
            <ul class="flex justify-evenly max-[400px]:justify-between">
                <li class=" text-[#F97316]">
                    <a href="{{route('front.index')}}" class="menu">
                        <div class="group flex flex-col items-center text-center gap-[10px]">
                            <div class="w-6 h-6 flex shrink-0">
                                <svg class="transition-all duration-300 group-hover:fill-[#F97316]  fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4" d="M7.65 20.91C7.62 20.91 7.58 20.93 7.55 20.93C5.61 19.97 4.03 18.38 3.06 16.44C3.06 16.41 3.08 16.37 3.08 16.34C4.3 16.7 5.56 16.97 6.81 17.18C7.03 18.44 7.29 19.69 7.65 20.91Z" />
                                    <path opacity="0.4" d="M20.94 16.45C19.95 18.44 18.3 20.05 16.29 21.02C16.67 19.75 16.99 18.47 17.2 17.18C18.46 16.97 19.7 16.7 20.92 16.34C20.91 16.38 20.94 16.42 20.94 16.45Z" />
                                    <path opacity="0.4" d="M21.02 7.70998C19.76 7.32998 18.49 7.01998 17.2 6.79998C16.99 5.50998 16.68 4.22998 16.29 2.97998C18.36 3.96998 20.03 5.63998 21.02 7.70998Z" />
                                    <path opacity="0.4" d="M7.64998 3.09C7.28998 4.31 7.02998 5.55 6.81998 6.81C5.52998 7.01 4.24998 7.33 2.97998 7.71C3.94998 5.7 5.55998 4.05 7.54998 3.06C7.57998 3.06 7.61998 3.09 7.64998 3.09Z" />
                                    <path d="M15.49 6.59C13.17 6.33 10.83 6.33 8.51001 6.59C8.76001 5.22 9.08001 3.85 9.53001 2.53C9.55001 2.45 9.54001 2.39 9.55001 2.31C10.34 2.12 11.15 2 12 2C12.84 2 13.66 2.12 14.44 2.31C14.45 2.39 14.45 2.45 14.47 2.53C14.92 3.86 15.24 5.22 15.49 6.59Z" />
                                    <path d="M6.59 15.49C5.21 15.24 3.85 14.92 2.53 14.47C2.45 14.45 2.39 14.46 2.31 14.45C2.12 13.66 2 12.85 2 12C2 11.16 2.12 10.34 2.31 9.56001C2.39 9.55001 2.45 9.55001 2.53 9.53001C3.86 9.09001 5.21 8.76001 6.59 8.51001C6.34 10.83 6.34 13.17 6.59 15.49Z" />
                                    <path d="M22 12C22 12.85 21.88 13.66 21.69 14.45C21.61 14.46 21.55 14.45 21.47 14.47C20.14 14.91 18.78 15.24 17.41 15.49C17.67 13.17 17.67 10.83 17.41 8.51001C18.78 8.76001 20.15 9.08001 21.47 9.53001C21.55 9.55001 21.61 9.56001 21.69 9.56001C21.88 10.35 22 11.16 22 12Z" />
                                    <path d="M15.49 17.41C15.24 18.79 14.92 20.15 14.47 21.47C14.45 21.55 14.45 21.61 14.44 21.69C13.66 21.88 12.84 22 12 22C11.15 22 10.34 21.88 9.55001 21.69C9.54001 21.61 9.55001 21.55 9.53001 21.47C9.09001 20.14 8.76001 18.79 8.51001 17.41C9.67001 17.54 10.83 17.63 12 17.63C13.17 17.63 14.34 17.54 15.49 17.41Z" />
                                    <path d="M15.7633 15.7633C13.2622 16.0789 10.7378 16.0789 8.23667 15.7633C7.92111 13.2622 7.92111 10.7378 8.23667 8.23667C10.7378 7.92111 13.2622 7.92111 15.7633 8.23667C16.0789 10.7378 16.0789 13.2622 15.7633 15.7633Z" />
                                </svg>
                            </div>
                            <p class="font-semibold text-sm leading-[21px] transition-all duration-300 group-hover:text-[#F97316] text-current">Beranda</p>
                        </div>
                    </a>
                </li>
                <li class=" text-[#13181D]">
                    <a href="{{route('front.check_booking')}}" class="menu">
                        <div class="group flex flex-col items-center text-center gap-[10px]">
                            <div class="w-6 h-6 flex shrink-0">
                                <svg class="transition-all duration-300 group-hover:fill-[#F97316]  fill-current" width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22.5 6V8.42C22.5 10 21.5 11 19.92 11H16.5V4.01C16.5 2.9 17.41 2 18.52 2C19.61 2.01 20.61 2.45 21.33 3.17C22.05 3.9 22.5 4.9 22.5 6Z" />
                                    <path opacity="0.4" d="M2.5 7V21C2.5 21.83 3.44001 22.3 4.10001 21.8L5.81 20.52C6.21 20.22 6.77 20.26 7.13 20.62L8.78999 22.29C9.17999 22.68 9.82001 22.68 10.21 22.29L11.89 20.61C12.24 20.26 12.8 20.22 13.19 20.52L14.9 21.8C15.56 22.29 16.5 21.82 16.5 21V4C16.5 2.9 17.4 2 18.5 2H7.5H6.5C3.5 2 2.5 3.79 2.5 6V7Z" />
                                    <path d="M12.5 9.75H6.5C6.09 9.75 5.75 9.41 5.75 9C5.75 8.59 6.09 8.25 6.5 8.25H12.5C12.91 8.25 13.25 8.59 13.25 9C13.25 9.41 12.91 9.75 12.5 9.75Z" />
                                    <path d="M11.75 13.75H7.25C6.84 13.75 6.5 13.41 6.5 13C6.5 12.59 6.84 12.25 7.25 12.25H11.75C12.16 12.25 12.5 12.59 12.5 13C12.5 13.41 12.16 13.75 11.75 13.75Z" />
                                </svg>
                            </div>
                            <p class="font-semibold text-sm leading-[21px] transition-all duration-300 group-hover:text-[#F97316] text-current">Booking</p>
                        </div>
                    </a>
                </li>
                <li class=" text-[#13181D]">
                    <a href="{{route('front.testimoni')}}" class="menu">
                        <div class="group flex flex-col items-center text-center gap-[10px]">
                            <div class="w-6 h-6 flex shrink-0">
                                <svg class="transition-all duration-300 group-hover:fill-[#F97316]  fill-current" width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4" d="M20.47 10V18C20.47 21 19.47 22 16.47 22H8.47C5.47 22 4.47 21 4.47 18V10H20.47Z" />
                                    <path d="M22 7V8C22 9.1 21.47 10 20 10H5C3.47 10 3 9.1 3 8V7C3 5.9 3.47 5 5 5H20C21.47 5 22 5.9 22 7Z" />
                                    <path opacity="0.4" d="M12.14 5H6.62C6.28 4.63 6.29 4.06 6.65 3.7L8.07 2.28C8.44 1.91 9.05 1.91 9.42 2.28L12.14 5Z" />
                                    <path opacity="0.4" d="M18.37 5H12.85L15.57 2.28C15.94 1.91 16.55 1.91 16.92 2.28L18.34 3.7C18.7 4.06 18.71 4.63 18.37 5Z" />
                                    <path opacity="0.6" d="M9.44 10V15.14C9.44 15.94 10.32 16.41 10.99 15.98L11.93 15.36C12.27 15.14 12.7 15.14 13.03 15.36L13.92 15.96C14.58 16.4 15.47 15.93 15.47 15.13V10H9.44Z" />
                                </svg>
                            </div>
                            <p class="font-semibold text-sm leading-[21px] transition-all duration-300 group-hover:text-[#F97316] text-current">Testimoni</p>
                        </div>
                    </a>
                </li>
                <li class=" text-[#13181D]">
                    <a href="{{route('front.support')}}" class="menu">
                        <div class="group flex flex-col items-center text-center gap-[10px]">
                            <div class="w-6 h-6 flex shrink-0">
                                <svg class="transition-all duration-300 group-hover:fill-[#F97316]  fill-current" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.4" d="M18 18.86H17.24C16.44 18.86 15.68 19.17 15.12 19.73L13.41 21.42C12.63 22.19 11.36 22.19 10.58 21.42L8.87 19.73C8.31 19.17 7.54 18.86 6.75 18.86H6C4.34 18.86 3 17.53 3 15.89V4.97998C3 3.33998 4.34 2.01001 6 2.01001H18C19.66 2.01001 21 3.33998 21 4.97998V15.89C21 17.52 19.66 18.86 18 18.86Z" />
                                    <path d="M10.38 14.51H7.69998C7.25998 14.51 6.84998 14.3 6.58998 13.94C6.33998 13.6 6.27998 13.18 6.39998 12.78C6.74998 11.71 7.60998 11.13 8.36998 10.61C9.16998 10.07 9.61998 9.73002 9.61998 9.15002C9.61998 8.63002 9.19998 8.21002 8.67998 8.21002C8.15998 8.21002 7.73999 8.63002 7.73999 9.15002C7.73999 9.56002 7.39999 9.90002 6.98999 9.90002C6.57999 9.90002 6.23999 9.56002 6.23999 9.15002C6.23999 7.81002 7.32998 6.71002 8.67998 6.71002C10.03 6.71002 11.12 7.80002 11.12 9.15002C11.12 10.56 10.06 11.28 9.20999 11.86C8.67999 12.22 8.17998 12.56 7.92998 13.01H10.37C10.78 13.01 11.12 13.35 11.12 13.76C11.12 14.17 10.79 14.51 10.38 14.51Z" />
                                    <path d="M16.04 14.51C15.63 14.51 15.29 14.17 15.29 13.76V13.07H13.33C13.33 13.07 13.33 13.07 13.32 13.07C12.83 13.07 12.38 12.81 12.13 12.39C11.88 11.96 11.88 11.43 12.13 11.01C12.81 9.84001 13.6 8.50997 14.32 7.34997C14.64 6.83997 15.25 6.61002 15.82 6.77002C16.39 6.94002 16.79 7.45999 16.78 8.05999V11.58H17C17.41 11.58 17.75 11.92 17.75 12.33C17.75 12.74 17.41 13.08 17 13.08H16.79V13.77C16.79 14.18 16.46 14.51 16.04 14.51ZM15.29 8.64001C14.7 9.60001 14.09 10.63 13.54 11.57H15.29V8.64001Z" />
                                </svg>
                            </div>
                            <p class="font-semibold text-sm leading-[21px] transition-all duration-300 group-hover:text-[#F97316] text-current">Support</p>
                        </div>
                    </a>
                </li>
            </ul>
        </nav>

    </div>

    <script>
        function testimonialSlider() {
            return {
                currentSlide: 0,
                totalSlides: 0,
                indicators: [],
                touchStartX: 0,
                touchEndX: 0,

                init() {
                    this.totalSlides = this.$refs.slider.children.length;
                    this.initIndicators();
                    this.updateIndicators();
                },

                initIndicators() {
                    const slidesPerView = this.getSlidesPerView();
                    const totalIndicators = Math.ceil(this.totalSlides / slidesPerView);

                    this.indicators = Array.from({
                        length: totalIndicators
                    }, (_, index) => ({
                        active: index === 0
                    }));
                },

                getSlidesPerView() {
                    const containerWidth = this.$refs.slider.offsetWidth;
                    const slideWidth = 300; // approximate slide width including gap
                    return Math.floor(containerWidth / slideWidth) || 1;
                },

                updateIndicators() {
                    const slider = this.$refs.slider;
                    const slideWidth = slider.children[0].offsetWidth + 16; // slide width + gap
                    const slidesPerView = this.getSlidesPerView();

                    this.currentSlide = Math.round(slider.scrollLeft / slideWidth);
                    const currentIndicator = Math.floor(this.currentSlide / slidesPerView);

                    this.indicators = this.indicators.map((indicator, index) => ({
                        ...indicator,
                        active: index === currentIndicator
                    }));
                },

                nextSlide() {
                    const slider = this.$refs.slider;
                    const slideWidth = slider.children[0].offsetWidth + 16;
                    const maxScroll = slider.scrollWidth - slider.offsetWidth;
                    const nextScroll = Math.min(slider.scrollLeft + slideWidth, maxScroll);

                    slider.scrollTo({
                        left: nextScroll,
                        behavior: 'smooth'
                    });
                },

                prevSlide() {
                    const slider = this.$refs.slider;
                    const slideWidth = slider.children[0].offsetWidth + 16;
                    const prevScroll = Math.max(slider.scrollLeft - slideWidth, 0);

                    slider.scrollTo({
                        left: prevScroll,
                        behavior: 'smooth'
                    });
                },

                goToSlide(indicatorIndex) {
                    const slider = this.$refs.slider;
                    const slideWidth = slider.children[0].offsetWidth + 16;
                    const slidesPerView = this.getSlidesPerView();
                    const targetSlide = indicatorIndex * slidesPerView;
                    const targetScroll = targetSlide * slideWidth;

                    slider.scrollTo({
                        left: targetScroll,
                        behavior: 'smooth'
                    });
                },

                startTouch(e) {
                    this.touchStartX = e.changedTouches[0].screenX;
                },

                moveTouch(e) {
                    this.touchEndX = e.changedTouches[0].screenX;
                },

                endTouch() {
                    const touchDiff = this.touchStartX - this.touchEndX;
                    const minSwipeDistance = 50;

                    if (Math.abs(touchDiff) > minSwipeDistance) {
                        if (touchDiff > 0) {
                            this.nextSlide();
                        } else {
                            this.prevSlide();
                        }
                    }
                }
            }
        }
    </script>
</body>

</html>