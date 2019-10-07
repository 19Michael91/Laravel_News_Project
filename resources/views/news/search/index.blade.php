@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h1 class="page-name">Result of search by "{{ $search }}"</h1>
            <div class="row col-sm-12">
                <div class="col-sm-8">
                    @if ($news)
                        @foreach($news as $article)
                            <div class="news-block row col-sm-12">
                                <h3 class="news-title col-sm-12">
                                    <a href="{{ route('news.single', ['news_id' => $article->id]) }}">{{$article->title}}</a>
                                </h3>
                                <div class="news-text col-sm-12">
                                    {{Str::limit($article->text, 150, '...')}}
                                </div>
                                <div class="row col-sm-12">
                                    <div class="news-category col-sm-4">
                                        categoty: <a href="{{ route('news.category', ['id' => $article->category->id]) }}">{{$article->category->name}}</a>
                                    </div>
                                    <div class="news-visit-count col-sm-2">
                                        visited: {{$article->visit_count}}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <h1>Sorry, there is no News</h1>
                    @endif
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-12 search-block">
                        <form action="{{ route('news.search') }}" method="POST" class="col-sm-12 row">
                            @csrf
                            <input type="text" name="search" class="col-sm-8">
                            <button type="submit" class="btn btn-info search-button col-sm-4">Search</button>
                        </form>
                    </div>
                    <div class="col-sm-12">
                        @if ($categories)
                            <h2 class="category-title">Categories</h2>
                            <ul>
                                @foreach($categories as $category)
                                    <li><a href="{{ route('news.category', ['id' => $category->id]) }}">{{$category->name}}</a></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="col-sm-12">
                        @if( Auth::check() )
                            <h2 class="favourites-title"><a href="{{ Auth::user()->favorites->count() > 0 ? route('news.favourite') : '#'}}">Favourites ({{ Auth::user()->favorites->count() }})</a></h2>
                        @else
                            <h2 class="favourites-title"><a href="#">Favourites (0)</a></h2> <span class="red">*</span> to add news to your favourites you need login
                        @endif
                    </div>
                    <div class="col-sm-12 subscribe-block">
                        @if( Auth::check() )
                            @if (\App\User::SUBSCRIBE == Auth::user()->subscribe)
                                <a class="subscribe-button btn btn-success" href="{{ route('news.unsubscribe') }}">Unsubscribe</a>
                            @else
                                <a class="subscribe-button btn btn-info" href="{{ route('news.subscribe') }}">Subscribe</a>
                            @endif
                        @else
                            <button class="subscribe-button btn btn-info">Subscribe</button> <span class="red">*</span> to subscribe you need login
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
