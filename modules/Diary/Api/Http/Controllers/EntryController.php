<?php

namespace Diary\Api\Http\Controllers;

use App\Entry;
use App\Http\Controllers\Controller;
use App\Journal;
use Dingo\Api\Auth\Auth;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;

class EntryController extends Controller
{
    use Helpers;

    /**
     * List all Journals for authenticated user
     * @return Response
     */
    public function index()
    {
        return app(Auth::class)->user()->entries()->latest()->get();
    }

    /**
     * Show Details about a Journal
     * @param  integer $journalId
     * @return Response
     */
    public function show($journalId)
    {
        return app(Auth::class)->user()->entries()->findOrFail($journalId);
    }

    /**
     * Update a Journal
     * @param  integer $journalId
     * @return Response
     */
    public function update($journalId)
    {
        $payload = app('request')->only('content');

        $validator = app('validator')->make($payload, [
            'content' => ['required']
        ]);

        if ($validator->fails()) {
            throw new UpdateResourceFailedException('Could not update journal.', $validator->errors());
        }

        $journal = app(Auth::class)->user()->entries()->findOrFail($journalId);

        $journal = $journal->update([
            'content' => app('request')->content
        ]);

        return $this->response->created("/entries/{$journal->id}");
    }

    /**
     * Destroy a Journal
     * @param  integer $journalId
     * @return Response
     */
    public function destroy($journalId)
    {
        $journal = app(Auth::class)->user()->entries()->findOrFail($journalId);
        $journal->delete();

        return $this->response->noContent();
    }

}
