@php
    $siteName = 'zynx1';
    $siteUrl = config('app.url');
    $pageTitle = ($title ?? 'Software, AI, Data & Automation') . ' — ' . $siteName;
    $pageDescription = $description ?? 'Custom software, apps and websites for growing businesses. Data, AI and automation built around how you work.';
    $canonical = $canonical ?? url()->current();
    $ogImage = $ogImage ?? $siteUrl . '/og-image.png';
@endphp

<title>{{ $pageTitle }}</title>
<meta name="description" content="{{ $pageDescription }}" />
<link rel="canonical" href="{{ $canonical }}" />
<meta name="robots" content="index, follow" />
<meta name="author" content="Zynx" />

<meta property="og:type" content="website" />
<meta property="og:site_name" content="{{ $siteName }}" />
<meta property="og:title" content="{{ $pageTitle }}" />
<meta property="og:description" content="{{ $pageDescription }}" />
<meta property="og:url" content="{{ $canonical }}" />
<meta property="og:locale" content="en_GB" />

<meta name="twitter:card" content="summary_large_image" />
<meta name="twitter:title" content="{{ $pageTitle }}" />
<meta name="twitter:description" content="{{ $pageDescription }}" />

<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'ProfessionalService',
    'name' => 'Zynx',
    'alternateName' => 'zynx1',
    'url' => $siteUrl,
    'description' => $pageDescription,
    'areaServed' => 'GB',
    'serviceType' => ['Custom Software Development', 'Data & AI', 'Automation & Integration'],
    'knowsAbout' => ['Software Engineering', 'Artificial Intelligence', 'Business Automation', 'Data Analytics'],
], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
</script>
