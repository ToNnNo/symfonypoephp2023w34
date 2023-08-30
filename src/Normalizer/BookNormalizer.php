<?php

namespace App\Normalizer;

use App\Entity\Genre;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;

class BookNormalizer
{

    public function getNormalizeContext(): array
    {
        $callback = function($object) {
            return $object != null ? $object->getId() : null;
        };

        $callbackGenre = function($array) {
            $genres = [];
            if(!empty($array) && is_array($array)) {
                foreach ($array as $genre) {
                    if( $genre instanceof Genre) {
                        $genres[] = $genre->getId();
                    }
                }
            }

            return $genres;
        };

        return [
            AbstractNormalizer::CALLBACKS => [
                'author' => $callback,
                'genre' => $callback
            ]
        ];
    }
}
