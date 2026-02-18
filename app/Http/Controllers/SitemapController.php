<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\CaseStudy;
use App\Models\Service;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $urls = collect();

        // Static pages
        $staticPages = ['home', 'services', 'case-studies', 'about', 'contact', 'blog', 'faq'];
        foreach ($staticPages as $page) {
            $urls->push([
                'loc' => route($page),
                'lastmod' => now()->toW3cString(),
                'changefreq' => 'weekly',
                'priority' => $page === 'home' ? '1.0' : '0.8',
            ]);
        }

        // Blog posts
        $posts = BlogPost::published()->latest('published_at')->get();
        foreach ($posts as $post) {
            $urls->push([
                'loc' => route('blog.post', $post->slug),
                'lastmod' => $post->updated_at->toW3cString(),
                'changefreq' => 'monthly',
                'priority' => '0.6',
            ]);
        }

        $xml = '<?xml version="1.0" encoding="UTF-8"?>';
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

        foreach ($urls as $url) {
            $xml .= '<url>';
            $xml .= '<loc>' . htmlspecialchars($url['loc']) . '</loc>';
            $xml .= '<lastmod>' . $url['lastmod'] . '</lastmod>';
            $xml .= '<changefreq>' . $url['changefreq'] . '</changefreq>';
            $xml .= '<priority>' . $url['priority'] . '</priority>';
            $xml .= '</url>';
        }

        $xml .= '</urlset>';

        return response($xml, 200, ['Content-Type' => 'application/xml']);
    }
}
