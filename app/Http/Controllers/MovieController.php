<?php

namespace App\Http\Controllers;

use App\Events\NewMovieEvent;
use App\Models\Movie;
use App\Models\MovieActor;
use Elasticsearch\ClientBuilder;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    protected $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()->build();
    }

    public function index()
    {
        $movies = Movie::with('movie_actors')->get();

        return view('movies.index', ['movies' => $movies]);
    }

    public function create()
    {
        return view('movies.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'description' => 'required',
            'rating' => 'required|max:5',
            'year' => 'required',
            'actors' => 'required',
            'image' => 'max:255'
        ]);

        $movie              = new Movie();
        $movie->name        = $validatedData['name'];
        $movie->description = $validatedData['description'];
        $movie->rating      = $validatedData['rating'];
        $movie->year        = $validatedData['year'];
        $movie->image       = $validatedData['image'];
        $movie->save();

        $actors = explode(PHP_EOL, $validatedData['actors']);
        $actors = array_filter($actors);

        foreach ($actors as $actor) {
            $newActor           = new MovieActor();
            $newActor->name     = $actor;
            $newActor->movie_id = $movie->id;
            $newActor->save();
        }

        // Trigger an event to index new movie in Elasticsearch
        event(new NewMovieEvent($movie));

        return redirect()->route('movies');
    }

    public function search(Request $request)
    {
        if($request->has('text') && $request->input('text')) {

            // Search for given text and return data
            $data = $this->searchMovies($request->input('text'));
            $moviesArray = [];

            // If there are any movies that match given search text "hits" fill their id's in array
            if($data['hits']['total'] > 0) {

                foreach ($data['hits']['hits'] as $hit) {
                    $moviesArray[] = $hit['_source']['id'];
                }
            }

            // Retrieve found movies from database
            $movies = Movie::with('movie_actors')
                           ->whereIn('id', $moviesArray)
                           ->get();

            // Return to view with data
            return view('movies.index', ['movies' => $movies]);
        } else {
            return redirect()->route('movies');
        }
    }

    private function searchMovies($text)
    {
        $params = [
            'index' => Movie::ELASTIC_INDEX,
            'type' => Movie::ELASTIC_TYPE,
            'body' => [
                'sort' => [
                    '_score'
                ],
                'query' => [
                    'bool' => [
                        'should' => [
                            ['match' => [
                                'name' => [
                                    'query'     => $text,
                                    'fuzziness' => '1'
                                ]
                            ]],
                            ['match' => [
                                'description' => [
                                    'query'     => $text,
                                    'fuzziness' => '0'
                                ]
                            ]],
                            ['match' => [
                                'actors' => [
                                    'query'     => $text,
                                    'fuzziness' => '0'
                                ]
                            ]]
                        ]
                    ],
                ],
            ]
        ];

        $data = $this->client->search($params);
        return $data;
    }
}
