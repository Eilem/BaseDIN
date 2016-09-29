<!doctype html>

<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />

        <title>{{ Meta::meta('title') }}</title>
        <meta name="description" content="{{ Meta::meta('description') }}">
        <meta name="author" content="{!! getenv('APPLICATION_NAME') !!}">
        <meta name="robots" content="index, nofollow">
        
        {{--  TOKEN para envio de formulários --}}
        <meta name="csrf-token" content="{{ csrf_token() }}"> 

        <link rel="shortcut icon" href="/favicon.ico">

        {!! Meta::tagMetaProperty('site_name', getenv('APPLICATION_NAME')) !!}
        {!! Meta::tagMetaProperty('url', Request::url())!!}
        {!! Meta::tagMetaProperty('locale', 'pt-br')!!}
        {!! Meta::tagMetaProperty('og:locale', 'pt-br')!!}
        {!! Meta::tagMetaProperty('og:url', Request::url())!!}
        {!! Meta::tagMetaProperty('og:site_name', getenv('APPLICATION_NAME'))!!}
        {!! Meta::tagMetaProperty('og:type', 'website')!!}

        {!! Meta::tag('title') !!}
        {!! Meta::tag('description') !!}
        {!! Meta::tag('image') !!}

        {!! Meta::tagMetaName('robots') !!}

        @section('css')
        @show

        <script type="text/javascript" src="/assets/js/modernizr.js"></script>

        <!--[if lt IE 9]>
                <script src="//cdnjs.cloudflare.com/ajax/libs/selectivizr/1.0.2/selectivizr-min.js"></script>
                <script src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv-printshiv.min.js"></script>
                <script src="//cdnjs.cloudflare.com/ajax/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>

    <body itemscope itemtype="http://schema.org/WebPage">

        <section id="dd-wrapper" class="dd-normal">
            @include('includes.header')

            <div class="dd-wrapper">
                @yield('content')
            </div>

            @include('includes.footer')
        </section>

        {{-- Google Analytcs --}}
        @if(isset($settings->google_analytcs))
            {!! $settings->google_analytcs !!}
        @endif

        @section('js')
        @show

    </body>
</html>
