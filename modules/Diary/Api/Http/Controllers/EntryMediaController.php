<?php

namespace Diary\Api\Http\Controllers;

use App\Entry;
use App\Http\Controllers\Controller;
use App\Media;
use Diary\Transformers\EntryMediaTransformer;
use Illuminate\Http\Request;

class EntryMediaController extends Controller
{

    public function index(Entry $entry)
    {
        return fractal()
           ->collection($entry->media)
           ->transformWith(new EntryMediaTransformer())
           ->withResourceName('media')
           ->respond();

    }

    public function store(Entry $entry, Request $request)
    {
        $result = $entry->media()->create([
            'blob' => $request->file
        ]);

        return fractal()
           ->item($result)
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