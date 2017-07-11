<?php

namespace Diary\Api\Http\Controllers;

use App\Entry;
use App\Http\Controllers\Controller;
use Diary\Api\Http\Requests\EntryRequest;
use Diary\Api\Http\Requests\UpdateEntryRequest;
use Diary\Transformers\EntryTransformer;

class EntryController extends Controller
{
    /**
     * Return single Entry Resource
     * @param  Entry $entry
     * @return Response
     */
    public function show(Entry $entry, EntryRequest $request)
    {
        abort_if(is_null($entry), 404);

        return fractal()
           ->item($entry)
           ->transformWith(new EntryTransformer())
           ->withResourceName('entry')
           ->respond();
    }

    /**
     * Update an Entry
     * @param  Entry $entry
     * @return Response
     */
    public function update(Entry $entry, UpdateEntryRequest $request)
    {
        $entry->update([
            'title' => $request->title,
            'content' => $request->content
        ]);

        return response([], 200);
    }

    /**
     * Destroy an Entry
     * @param  Entry $entry
     * @return Response
     */
    public function destroy(Entry $entry, EntryRequest $request)
    {
        $entry->delete();

        return response([], 204);
    }

}
