@extends('admin.index')
@section('admin-content')


    <div class="col-sm-12">
        <div class="col-sm-9"><h1>News</h1></div>
        <div class="col-sm-3"><a class="btn btn-info add-news" href="{{ route('admin.create') }}">Add News</a></div>
    </div>

    <div class="col-sm-12">
        @if($news)
            <table border="1">
                <thead>
                <tr class="tr-table">
                    <td class="col-sm-1">#</td>
                    <td class="col-sm-1">Title</td>
                    <td class="col-sm-8">Text</td>
                    <td class="col-sm-1">Visit Count</td>
                    <td class="col-sm-1">Category</td>
                    <td class="col-sm-1">Delete</td>
                </tr>
                </thead>
                <tbody class="table-body">
                @foreach($news as $article)
                    <tr>
                        <td>{{ $article->id }}</td>
                        <td>{{ $article->title }}</td>
                        <td class="td-text">{{ $article->text }}</td>
                        <td>{{ $article->visit_count }}</td>
                        <td>{{ $article->category->name }}</td>
                        <td><a class="btn btn-danger add-news" href="{{ route('admin.destroy', ['news_id' => $article->id]) }}">Delete</a></td>
                    </tr>
                @endforeach

                </tbody>
            </table>
            <div>{{ $news->links() }}</div>
         @else
            <h1>Sorry, there is no News</h1>
         @endif
    </div>


@endsection
