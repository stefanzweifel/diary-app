<?php

namespace Diary\Api\Http\Controllers;

use App\Entry;
use App\Http\Controllers\Controller;
use App\Journal;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EntryController extends Controller
{
    /**
     * Return single Entry Resource
     * @param  integer $entryId
     * @return Response
     */
    public function show($entryId, Request $request)
    {
        $entry = $request->user()->entries()->where('id', $entryId)->first();

        if (is_null($entry)) {
            throw new NotFoundHttpException;
        }

        return response(['entry' => $entry]);

        return $entry;
    }

    /**
     * Update an Entry
     * @param  integer $entryId
     * @return Response
     */
    public function update($entryId, Request $request)
    {
        $payload = $request->all();

        $validator = app('validator')->make($payload, [
            'title' => ['required'],
            'content' => ['required']
        ]);

        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not update Entry.', $validator->errors());
        }

        $entry = Entry::findOrFail($entryId);

        $entry->update([
            'title' => $request->title,
            'content' => $request->content
        ]);

        return response([]);
    }

    /**
     * Destroy an Entry
     * @param  integer $entryId
     * @return Response
     */
    public function destroy($entryId, Request $request)
    {
        $journal = $request->user()->entries()->findOrFail($entryId);
        $journal->delete();

        return response([], 204);
    }

}
