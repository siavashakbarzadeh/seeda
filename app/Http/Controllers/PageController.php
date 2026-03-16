<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\CaseStudy;
use App\Models\ContactMessage;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home', [
            'services' => Cache::remember('home.services', 3600, fn() => Service::active()->take(3)->get()),
            'featuredStudy' => Cache::remember('home.featured_study', 3600, fn() => CaseStudy::active()->featured()->first() ?? CaseStudy::active()->first()),
            'testimonials' => Cache::remember('home.testimonials', 3600, fn() => Testimonial::featured()->orderBy('sort_order')->take(3)->get()),
            'portfolioStudies' => Cache::remember('home.portfolio', 3600, fn() => CaseStudy::active()->featured()->take(4)->get()),
            'stats' => [
                ['value' => '50+', 'label' => 'Projects Delivered'],
                ['value' => '98%', 'label' => 'Client Satisfaction'],
                ['value' => '8+', 'label' => 'Years Experience'],
            ],
        ]);
    }

    public function services()
    {
        return view('pages.services', [
            'services' => Cache::remember('page.services', 3600, fn() => Service::active()->get()),
        ]);
    }

    public function caseStudies(Request $request)
    {
        $category = $request->query('category');
        $cacheKey = 'page.case_studies.' . ($category ?? 'all');

        $data = Cache::remember($cacheKey, 3600, function () use ($category) {
            $categories = CaseStudy::active()
                ->distinct()
                ->pluck('category')
                ->sort()
                ->values();

            $studies = CaseStudy::active()
                ->when($category, fn($q) => $q->byCategory($category))
                ->get();

            return compact('categories', 'studies');
        });

        return view('pages.case-studies', array_merge($data, ['active' => $category]));
    }

    public function about()
    {
        return view('pages.about', [
            'team' => Cache::remember('page.about.team', 3600, fn() => TeamMember::active()->get()),
        ]);
    }

    public function blog()
    {
        return view('pages.blog', [
            'posts' => BlogPost::published()->latest('published_at')->paginate(9),
        ]);
    }

    public function blogPost($slug)
    {
        $post = BlogPost::published()->where('slug', $slug)->firstOrFail();
        $related = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->where('category', $post->category)
            ->take(3)->get();

        return view('pages.blog-post', compact('post', 'related'));
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function contactSubmit(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'company' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        ContactMessage::create($validated);

        return back()->with('success', 'Thank you! We\'ll get back to you within 24 hours.');
    }

    public function faq()
    {
        $faqs = Cache::remember('page.faq', 3600, fn() => \App\Models\Faq::published()->orderBy('sort_order')->get());
        $categories = $faqs->pluck('category')->unique()->filter()->values();

        return view('pages.faq', compact('faqs', 'categories'));
    }

    public function newsletterSubscribe(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:newsletter_subscribers,email',
            'name' => 'nullable|string|max:255',
        ]);

        \App\Models\NewsletterSubscriber::create(array_merge($validated, [
            'subscribed_at' => now(),
        ]));

        return back()->with('success', 'Thanks for subscribing to our newsletter!');
    }
}
