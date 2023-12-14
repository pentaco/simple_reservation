@section('head')
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<meta name="description" itemprop="description" content="@yield('description')">
<meta name="keywords" itemprop="keywords" content="@yield('keywords')">
<meta name="format-detection" content="telephone=no">
<!-- OGP設定 -->
<meta property="og:url" content="{{ config('app.url') }}">
<meta property="og:title" content="@yield('title')" />
<meta property="og:description" content="@yield('description')"/>
<meta property="og:site_name" content="{{ config('app.name') }}">
<meta property="og:type" content="product">
<meta property="og:image" content="{{ asset('/images/room/mouad-bouallayel-Y4pvI2pFkTY-unsplash.jpg') }}" />
<meta name="csrf-token" content="{{ csrf_token() }}">
@yield('noindex')
<title>@yield('title')</title>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.10.0/css/all.css">
<!-- Bulma Version 0.9.x-->
<link rel="stylesheet" href="https://unpkg.com/bulma@0.9.4/css/bulma.min.css" />
<link rel="stylesheet" href="{{ asset('/css/common.css') }}?{{ date("Y/m/d 00:00:00") }}">
<link rel="stylesheet" href="{{ asset('/css/style.css') }}">
@yield('css')
@endsection