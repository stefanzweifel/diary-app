<?php

namespace Diary\Api\Http\Controllers;

use App\Entry;
use App\Http\Controllers\Controller;
use App\Journal;
use Dingo\Api\Auth\Auth;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;

class JournalEntryController extends Controller
{
    use Helpers;

    /**
     * Store new Journal
     * @return Response
     */
    public function store($journalId)
    {
        $journal = Entry::create([
            'content' => "Should be a random quote",
            'journal_id' => $journalId,
            'user_id' => app(Auth::class)->user()->id
        ]);

        return $this->response->created("/entries/{$journal->id}");
    }

    public function update($journalId, $entryId)
    {
        $payload = app('request')->only('content');

        $validator = app('validator')->make($payload, [
            'content' => ['required']
        ]);

        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not update Entry.', $validator->errors());
        }

        $entry = Entry::findOrFail($entryId);

        $entry->update([
            'content' => app('request')->content
        ]);

        return $this->response->noContent();
    }
}
