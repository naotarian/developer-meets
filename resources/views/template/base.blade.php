<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="keywords" content="@yield('meta_keyword')">
<meta name="description" content="@yield('meta_description')">
<meta name="Author" content="@yield('meta_Author')">
<meta name="Copyright" content="@yield('meta_Copyright')">
<meta property="og:image" content="@yield('meta_og_image')">
<meta property="og:title" content="@yield('meta_og_title')">
<meta property="og:site_name" content="@yield('meta_og_site_name')">
<meta property="og:url" content="@yield('meta_og_url')">
<meta property="og:description" content="@yield('meta_og_description')">
<meta property="og:type" content="@yield('meta_og_type')">
<meta name="robots" content="noindex">
<link rel="stylesheet" href="/css/common.css">
<link rel="stylesheet" href="/css/template/header.css">
<link rel="stylesheet" href="/css/template/btn.css">
<!--<link rel="stylesheet" href="/css/auth/login.css">-->
<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.12.0/css/mdb.min.css" rel="stylesheet">
<script
  src="https://code.jquery.com/jquery-3.6.0.js"
  integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
  crossorigin="anonymous"></script>
<meta name="robots" content="index,follow">
<meta name="robots" content="all">
@yield('individual_stylesheet')
<title>@yield('title')</title>
</head>
<body>
    @include('template.header')
    <div class="wrapper">
    @yield('contents')
    </div>
    @yield('reed_scripts')
</body>

<script>
    function toggleNav() {
  var body = document.body;
  var hamburger = document.getElementById('js-hamburger');
  var blackBg = document.getElementById('js-black-bg');

  hamburger.addEventListener('click', function() {
    body.classList.toggle('nav-open');
  });
  blackBg.addEventListener('click', function() {
    body.classList.remove('nav-open');
  });
}
toggleNav();
@yield('scripts')
</script>