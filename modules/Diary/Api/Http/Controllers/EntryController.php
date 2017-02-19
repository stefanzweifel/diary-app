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
     * List all Journals for authenticated user
     * @return Response
     */
    // public function index()
    // {
    //     return app(Auth::class)->user()->entries()->latest()->get();
    // }

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
    // public function update($entryId)
    // {
    //     $payload = app('request')->only('content');

    //     $validator = app('validator')->make($payload, [
    //         'content' => ['required']
    //     ]);

    //     if ($validator->fails()) {
    //         throw new UpdateResourceFailedException('Could not update journal.', $validator->errors());
    //     }

    //     $journal = app(Auth::class)->user()->entries()->findOrFail($entryId);

    //     $journal = $journal->update([
    //         'content' => app('request')->content
    //     ]);

    //     return $this->response->created("/entries/{$journal->id}");
    // }

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
