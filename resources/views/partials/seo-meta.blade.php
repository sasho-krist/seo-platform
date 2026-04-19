<link rel="icon" href="{{ asset('images/logo.svg') }}" type="image/svg+xml" sizes="any">
<link rel="apple-touch-icon" href="{{ asset('images/logo.svg') }}">
<link rel="sitemap" type="application/xml" title="Sitemap" href="{{ url('/sitemap.xml') }}">
<meta name="description" content="@yield('meta_description', config('seo.description'))">
<meta name="keywords" content="@yield('meta_keywords', config('seo.keywords'))">
<meta name="author" content="{{ config('seo.author') }}">
<meta name="robots" content="{{ config('seo.robots') }}">
<link rel="canonical" href="{{ url()->current() }}">
<meta property="og:type" content="website">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="@hasSection('title')@yield('title') · {{ config('app.name') }}@else{{ config('app.name') }}@endif">
<meta property="og:description" content="@yield('meta_description', config('seo.description'))">
<meta name="twitter:card" content="summary">
<meta name="twitter:title" content="@hasSection('title')@yield('title') · {{ config('app.name') }}@else{{ config('app.name') }}@endif">
<meta name="twitter:description" content="@yield('meta_description', config('seo.description'))">
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'WebApplication',
    'name' => config('app.name'),
    'url' => config('app.url'),
    'description' => config('seo.description'),
    'author' => [
        '@type' => 'Person',
        'name' => 'sasho-dev',
        'url' => 'https://sasho-dev.com/portfolio/',
    ],
    'offers' => [
        '@type' => 'Offer',
        'category' => 'SEO & Content software',
    ],
], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}
</script>
