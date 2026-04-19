<!DOCTYPE html>
<html lang="{{ $post->language ?? 'bg' }}">
<head>
    <meta charset="utf-8">
    <title>{{ $post->title }}</title>
</head>
<body>
<article>
    <h1>{{ $post->title }}</h1>
    {!! $post->body !!}
</article>
</body>
</html>
