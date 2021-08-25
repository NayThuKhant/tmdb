<?php

namespace NayThuKhant\TMDB;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TMDB
{
    public function __construct()
    {
        throw_if(!config('tmdb.token'),
            new \Exception('Please dont forget to register   NayThuKhant\TMDB\TMDBServiceProvider::class to app.php and add TMDB_TOKEN to .env'));
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
            $url = config('tmdb.base_url') . '/3/movie/popular';
            return Http::withToken(config('tmdb.token'))
                ->get($url)->json()['results'];
        } catch (\Exception $exception) {
            Log::error($exception);
            return [];
        }
    }

    public function getNowPlayingMovies()
    {
        try {
            $url = config('tmdb.base_url') . '/3/movie/now_playing';
            return Http::withToken(config('tmdb.token'))
                ->get($url)->json()['results'];
        } catch (\Exception $exception) {
            Log::error($exception);
            return [];
        }
    }

    public function getGenres()
    {
        try {
            $url = config('tmdb.base_url') . '/3/genre/movie/list';
            $genresArray = Http::withToken(config('tmdb.token'))
                ->get($url)->json()['genres'];

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
            $url = config('tmdb.base_url') . '/3/movie/' . $movieId . '?append_to_response=credits,videos,images';
            return Http::withToken(config('tmdb.token'))
                ->get($url)
                ->json();
        } catch (\Exception $exception) {
            Log::error($exception);
            return null;
        }
    }
}
