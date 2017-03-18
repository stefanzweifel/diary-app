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

    public function index($journalId)
    {
        $journal = app(Auth::class)->user()->journals()->where('id', $journalId)->firstOrFail();

        return $journal->entries()->latest()->get();
    }

    /**
     * Store new Journal
     * @return Response
     */
    public function store($journalId)
    {
        $journal = Entry::create([
            'content' => '',
            'title' => '',
            'journal_id' => $journalId,
            'user_id' => app(Auth::class)->user()->id
        ]);

        return $this->response->created("/entries/{$journal->id}");
    }
}
