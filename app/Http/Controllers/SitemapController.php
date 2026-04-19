<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function xml(): Response
    {
        $urls = [
            url('/'),
            route('login'),
            route('register'),
            route('terms'),
            route('privacy'),
            route('faq'),
            route('sitemap.page'),
            route('docs.api'),
        ];

        $xml = '<?xml version="1.0" encoding="UTF-8"?>'."\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">'."\n";

        foreach ($urls as $loc) {
            $xml .= '  <url><loc>'.htmlspecialchars((string) $loc, ENT_XML1 | ENT_QUOTES, 'UTF-8').'</loc>';
            $xml .= '<changefreq>weekly</changefreq><priority>0.8</priority></url>'."\n";
        }

        $xml .= '</urlset>';

        return response($xml, 200)->header('Content-Type', 'application/xml; charset=UTF-8');
    }
}
