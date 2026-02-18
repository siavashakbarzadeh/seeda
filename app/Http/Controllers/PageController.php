<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\CaseStudy;
use App\Models\ContactMessage;
use App\Models\Service;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function home()
    {
        return view('pages.home', [
            'services' => Service::active()->take(3)->get(),
            'featuredStudy' => CaseStudy::active()->featured()->first()
                ?? CaseStudy::active()->first(),
            'testimonials' => Testimonial::featured()->orderBy('sort_order')->take(3)->get(),
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
            'services' => Service::active()->get(),
        ]);
    }

    public function caseStudies(Request $request)
    {
        $category = $request->query('category');
        $categories = CaseStudy::active()
            ->distinct()
            ->pluck('category')
            ->sort()
            ->values();

        $studies = CaseStudy::active()
            ->when($category, fn($q) => $q->byCategory($category))
            ->get();

        return view('pages.case-studies', [
            'studies' => $studies,
            'categories' => $categories,
            'active' => $category,
        ]);
    }

    public function about()
    {
        return view('pages.about', [
            'team' => TeamMember::active()->get(),
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
        $faqs = \App\Models\Faq::published()->orderBy('sort_order')->get();
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

