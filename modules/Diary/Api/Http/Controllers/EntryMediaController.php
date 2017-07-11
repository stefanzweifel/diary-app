<?php

namespace Diary\Api\Http\Controllers;

use App\Entry;
use App\Http\Controllers\Controller;
use Diary\Transformers\EntryMediaTransformer;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\Media;

class EntryMediaController extends Controller
{
    public function index(Entry $entry)
    {
        return fractal()
            ->collection($entry->getMedia())
            ->transformWith(new EntryMediaTransformer())
            ->withResourceName('media')
            ->respond();
    }

    public function store(Entry $entry, Request $request)
    {
        $media = $entry->addMedia($request->file)->toMediaCollection();

        return fractal()
            ->item($media)
            ->transformWith(new EntryMediaTransformer())
            ->withResourceName('media')
            ->respond();

    }

    public function destroy(Entry $entry, Media $media)
    {
        $media->delete();

        return response([], 204);
    }

}