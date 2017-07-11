<?php

namespace Diary\Transformers;

use League\Fractal\TransformerAbstract;
use Spatie\MediaLibrary\Media;

class EntryMediaTransformer extends TransformerAbstract
{
    public function transform(Media $media)
    {
        return [
            'id' => $media->id,
            'name' => $media->name,
            'file_name' => $media->file_name,
            'mime_type' => $media->mime_type,
            'disk' => $media->disk,
            'size' => $media->size,
            'created_at' => $media->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $media->updated_at->format('Y-m-d H:i:s'),
            'links' => [
                [
                    'rel' => 'self',
                    // 'uri' => "/entries/{$media->model->id}/media/{$media->id}",
                ]
            ],
        ];
    }
}