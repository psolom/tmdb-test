<?php

namespace TmApi\Model;

use TmApi\Image;

/**
 * Class Movie
 *
 * @property integer $id
 * @property boolean $adult
 * @property string $backdrop_path
 * @property object $belongs_to_collection
 * @property integer $budget
 * @property array $genres
 * @property string $homepage
 * @property string $imdb_id
 * @property string $original_language
 * @property string $original_title
 * @property string $overview
 * @property float $popularity
 * @property string $poster_path
 * @property array $production_companies
 * @property array $production_countries
 * @property string $release_date
 * @property integer $revenue
 * @property integer $runtime
 * @property array $spoken_languages
 * @property string $status
 * @property string $tagline
 * @property string $title
 * @property boolean $video
 * @property float $vote_average
 * @property integer $vote_count
 */
class Movie extends BaseModel
{
    /**
     * @return \TmApi\Image
     */
    public function getPoster()
    {
        return new Image($this->getClient(), $this->poster_path);
    }
}