@extends('admin.index')
@section('admin-content')
    <div class="col-sm-12">
        <h1>Create News</h1>
        <p></p>
        <form action="{{ route('admin.store') }}" method="POST">
            @if($errors->any())
                @foreach ($errors->all() as $error)
                    <p class="error text-center alert alert-danger">{{ $error }}</p>
                @endforeach
            @endif
            @csrf
            <div class="col-sm-12 create-input">
                <label class="col-sm-1" for="title">Title</label>
                <input class="col-sm-6" type="text" name="title" value="" id="title">
            </div>
            <div class="col-sm-12 create-input">
                <label class="col-sm-1" for="text">Text</label>
                <textarea class="col-sm-6" name="text" value="" id="text" ></textarea>
            </div>
            <div class="col-sm-12 create-input">
                <label class="col-sm-1" for="category">Category</label>
                <select class="col-sm-6" name="category" id="category">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-7 create-input">
                <button type="submit" class="btn btn-success save-news col-sm-2">Save</button>
            </div>
        </form>
    </div>

@endsection
