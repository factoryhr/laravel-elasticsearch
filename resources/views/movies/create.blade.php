@extends('layouts.main')

@section('content')
        <form method="post" action="{{ route('store-movie') }}">
            <h3 class="text-center">Add new movie</h3><br>
            {{ csrf_field() }}
            <div class="form-group row">
                <label for="movieName" class="col-sm-2 col-form-label">Name*</label>
                <div class="col-sm-10">
                    <input name="name" type="text" id="movieName" class="form-control" placeholder="Movie name...">
                </div>
            </div>
            <div class="form-group row">
                <label for="movieDescription" class="col-sm-4 col-form-label">Description*</label>
                <div class="col-sm-12">
                    <textarea name="description" class="form-control" id="movieDescription" placeholder="Short description of movie"></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label for="movieYear" class="col-sm-2 col-form-label">Year*</label>
                <div class="col-sm-10">
                    <input name="year" class="form-control" id="movieYear" placeholder="Year of publishing">
                </div>
            </div>
            <div class="form-group row">
                <label for="movieRating" class="col-sm-2 col-form-label">Rating*</label>
                <div class="col-sm-10">
                    <input name="rating" class="form-control" id="movieRating" placeholder="Movie rating (max 5)">
                </div>
            </div>
            <div class="form-group row">
                <label for="movieImage" class="col-sm-2 col-form-label">Image</label>
                <div class="col-sm-10">
                    <input name="image" class="form-control" id="movieImage" placeholder="Link to image">
                </div>
            </div>
            <div class="form-group row">
                <label for="movieActors" class="col-sm-4 col-form-label">Actors</label>
                <div class="col-sm-12">
                    <textarea name="actors" class="form-control" id="movieActors" placeholder="Movie actors (enter one actor per line)"></textarea>
                </div>
            </div>
            <div class="text-center">
                <small>Fields marked with * are required</small><br><br>
                <button type="submit" class="btn btn-success">Add</button>
            </div>
        </form>
@endsection