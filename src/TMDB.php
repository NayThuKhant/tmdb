<?php

namespace NayThuKhant\TMDB;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TMDB
{

    private string $token;

    public function __construct()
    {
        throw_if(!config('tmdb.token'),
            new \Exception('Please dont forget to register   NayThuKhant\TMDB\TMDBServiceProvider::class to app.php and add TMDB_TOKEN to .env'));

        $this->token = config("tmdb.token");
    }

    public function fetchMoviesAndGenres()
    {
        try {
            $popularMovies = $this->getPopularMovies();
            $nowPlayingMovies = $this->getNowPlayingMovies();
            $genres = $this->getGenres();

            return [$popularMovies, $nowPlayingMovies, $genres];
        } catch (\Exception $exception) {
            Log::error($exception);
            return [];
        }
    }

    public function getPopularMovies()
    {
        try {
            $url = config('tmdb.base_url') . '/3/movie/popular?api_key=' . $this->token ;
            return Http::get($url)->json()['results'];
        } catch (\Exception $exception) {
            Log::error($exception);
            return [];
        }
    }

    public function getNowPlayingMovies()
    {
        try {
            $url = config('tmdb.base_url') . '/3/movie/now_playing?api_key=' . $this->token;
            return Http::get($url)->json()['results'];
        } catch (\Exception $exception) {
            Log::error($exception);
            return [];
        }
    }

    public function getGenres()
    {
        try {
            $url = config('tmdb.base_url') . '/3/genre/movie/list?api_key=' . $this->token;
            $genresArray = Http::get($url)->json()['genres'];

            return collect($genresArray)->mapWithKeys(function ($genre) {
                return [$genre['id'] => $genre['name']];
            });

        } catch (\Exception $exception) {
            Log::error($exception);
            return collect([]);
        }
    }

    public function getSpecificMovie($movieId)
    {
        try {
            $url = config('tmdb.base_url') . '/3/movie/' . $movieId . '?append_to_response=credits,videos,images&api_key='. $this->token;
            return Http::get($url)
                ->json();
        } catch (\Exception $exception) {
            Log::error($exception);
            return null;
        }
    }
}
