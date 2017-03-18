<?php

namespace Diary\Api\Http\Controllers;

use App\Entry;
use App\Http\Controllers\Controller;
use App\Journal;
use Dingo\Api\Auth\Auth;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EntryController extends Controller
{
    use Helpers;

    /**
     * Return single Entry Resource
     * @param  integer $entryId
     * @return Response
     */
    public function show($entryId)
    {
        $entry = app(Auth::class)->user()->entries()->where('id', $entryId)->first();

        if (is_null($entry)) {
            throw new NotFoundHttpException;
        }

        return $entry;
    }

    /**
     * Update an Entry
     * @param  integer $entryId
     * @return Response
     */
    public function update($entryId)
    {
        $payload = app('request')->all();

        $validator = app('validator')->make($payload, [
            'title' => ['required'],
            'content' => ['required']
        ]);

        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not update Entry.', $validator->errors());
        }

        $entry = Entry::findOrFail($entryId);

        $entry->update([
            'title' => app('request')->title,
            'content' => app('request')->content
        ]);

        return $this->response->noContent();
    }

    /**
     * Destroy an Entry
     * @param  integer $entryId
     * @return Response
     */
    public function destroy($entryId)
    {
        $journal = app(Auth::class)->user()->entries()->findOrFail($entryId);
        $journal->delete();

        return $this->response->noContent();
    }

}
