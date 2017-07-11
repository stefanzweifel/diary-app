<?php

namespace Diary\Transformers;

use App\Media;
use League\Fractal\TransformerAbstract;

class EntryMediaTransformer extends TransformerAbstract
{
    public function transform(Media $media)
    {
        return [
            'id' => $media->id,
            'blob' => $media->blob,
            'created_at' => $media->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $media->updated_at->format('Y-m-d H:i:s'),
            'links' => [
                [
                    'rel' => 'self',
                    'uri' => "/entries/{$media->entry->id}/media/{$media->id}",
                ]
            ],
        ];
    }
}