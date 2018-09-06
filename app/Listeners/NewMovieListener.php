<?php

namespace App\Listeners;

use App\Events\NewMovieEvent;
use App\Models\Movie;
use Elasticsearch\ClientBuilder;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewMovieListener
{
    protected $client;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->client = ClientBuilder::create()->build();
    }

    /**
     * Handle the event.
     *
     * @param  NewMovieEvent  $event
     * @return void
     */
    public function handle(NewMovieEvent $event)
    {
        $this->addMovieToElasticSearch($event->movie);
    }

    private function addMovieToElasticSearch(Movie $movie)
    {
        // Fill array with movie data
        $data = [
            'body' => [
                'id'            => $movie->id,
                'name'          => $movie->name,
                'year'          => $movie->year,
                'description'   => $movie->description,
                'rating'        => $movie->rating,
                'actors'        => implode(',', $movie->movie_actors->pluck('name')->toArray())
            ],
            'index' => Movie::ELASTIC_INDEX,
            'type'  => Movie::ELASTIC_TYPE,
        ];

        // Send request to index new movie
        $response = $this->client->index($data);

        return $response;
    }
}
