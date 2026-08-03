<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Landmark;
use App\Models\News;
use App\Models\Place;
use App\Models\PlaceCategory;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $xml = Cache::remember('sitemap', 3600, function () {
            $url = request()->getSchemeAndHttpHost();
            $xml = '<?xml version="1.0" encoding="UTF-8"?>';
            $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

            // Static pages
            $staticPages = ['/', '/news', '/events', '/places', '/city', '/transport', '/services', '/contacts'];
            foreach ($staticPages as $page) {
                $xml .= '<url>';
                $xml .= '<loc>'.$url.$page.'</loc>';
                $xml .= '<changefreq>weekly</changefreq>';
                $xml .= '<priority>'.($page === '/' ? '1.0' : '0.8').'</priority>';
                $xml .= '</url>';
            }

            // Place Categories
            foreach (PlaceCategory::select('key', 'updated_at')->get() as $c) {
                $xml .= '<url>';
                $xml .= '<loc>'.$url.'/places/category/'.$c->key.'</loc>';
                if ($c->updated_at) {
                    $xml .= '<lastmod>'.$c->updated_at->format('Y-m-d').'</lastmod>';
                }
                $xml .= '<changefreq>weekly</changefreq>';
                $xml .= '<priority>0.8</priority>';
                $xml .= '</url>';
            }

            // News
            foreach (News::where('is_published', true)->select('slug', 'updated_at')->get() as $n) {
                $xml .= '<url>';
                $xml .= '<loc>'.$url.'/news/'.$n->slug.'</loc>';
                $xml .= '<lastmod>'.$n->updated_at->format('Y-m-d').'</lastmod>';
                $xml .= '<changefreq>weekly</changefreq>';
                $xml .= '<priority>0.8</priority>';
                $xml .= '</url>';
            }

            // Events
            foreach (Event::where('is_published', true)->select('slug', 'updated_at')->get() as $e) {
                $xml .= '<url>';
                $xml .= '<loc>'.$url.'/events/'.$e->slug.'</loc>';
                $xml .= '<lastmod>'.$e->updated_at->format('Y-m-d').'</lastmod>';
                $xml .= '<changefreq>weekly</changefreq>';
                $xml .= '<priority>0.8</priority>';
                $xml .= '</url>';
            }

            // Places
            foreach (Place::where('is_published', true)->select('slug', 'updated_at')->get() as $p) {
                $xml .= '<url>';
                $xml .= '<loc>'.$url.'/places/'.$p->slug.'</loc>';
                $xml .= '<lastmod>'.$p->updated_at->format('Y-m-d').'</lastmod>';
                $xml .= '<changefreq>monthly</changefreq>';
                $xml .= '<priority>0.7</priority>';
                $xml .= '</url>';
            }

            // Landmarks
            foreach (Landmark::select('slug', 'updated_at')->get() as $l) {
                $xml .= '<url>';
                $xml .= '<loc>'.$url.'/city/'.$l->slug.'</loc>';
                $xml .= '<lastmod>'.$l->updated_at->format('Y-m-d').'</lastmod>';
                $xml .= '<changefreq>monthly</changefreq>';
                $xml .= '<priority>0.6</priority>';
                $xml .= '</url>';
            }

            $xml .= '</urlset>';

            return $xml;
        });

        return response($xml, 200)->header('Content-Type', 'application/xml');
    }
}
