<article class="reveal rounded-lg border border-sky-100 bg-white p-6 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-sky-300 hover:shadow-xl hover:shadow-sky-100" data-aos="fade-up" data-aos-duration="800">
    <div class="text-sm font-bold text-amber-500">5/5 stars</div>
    <p class="mt-4 leading-7 text-slate-700">"{{ $testimonial->quote }}"</p>
    <div class="mt-5">
        <p class="font-bold text-blue-950">{{ $testimonial->name }}</p>
        <p class="text-sm text-sky-700">{{ $testimonial->location }}</p>
    </div>
</article>
