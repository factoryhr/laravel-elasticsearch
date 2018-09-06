@extends('layouts.main')

@section('head-data')
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection

@section('content')
    @if(count($movies) > 0)
        <form class="form-inline" method="post" action="{{ route('search-movie') }}">
            {{ csrf_field() }}
            <div class="form-group row">
                <label for="searchTerm" class="col-sm-4 col-form-label">Search term</label>
                <div class="col-sm-6">
                    <input name="text" class="form-control" id="searchTerm" placeholder="Batman">
                </div>
            </div>
            <div class="form-group row" style="margin-left: 10px">
                <button type="submit" id="searchButton" style="margin-left: 20%" class="btn btn-primary">Search</button>
            </div>
        </form>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Title</th>
                <th scope="col">Description</th>
                <th scope="col">Rating</th>
                <th scope="col">Year</th>
                <th scope="col">Actors</th>
                <th scope="col">Cover image</th>
            </tr>
            </thead>
            <tbody>
                <?php $i = 1 ?>
                @foreach($movies as $movie)
                    <tr>
                        <th scope="row">{{ $i }}</th>
                        <td>{{ $movie->name }}</td>
                        <td>{{ $movie->description }}</td>
                        <td>{{ $movie->rating }}</td>
                        <td>{{ $movie->year }}</td>

                        @if(count($movie->movie_actors) > 0)
                            <td>
                                <ul>
                                    @foreach($movie->movie_actors as $actor)
                                        <li>{{ $actor->name }}</li>
                                    @endforeach
                                </ul>
                            </td>
                        @endif

                        @if($movie->image !== null && $movie->image !== '')
                            <td><img src="{{ $movie->image }}" style="width: 90px; height: 150px"></td>
                        @else
                            <td>No image</td>
                        @endif
                    </tr>
                    <?php $i++ ?>
                @endforeach
            </tbody>
        </table>
    @else
        <h3>No movies in database</h3>
    @endif
@endsection