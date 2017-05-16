<?php

namespace Diary\Api\Http\Controllers;

use App\Entry;
use App\Http\Controllers\Controller;
use App\Journal;
use Illuminate\Http\Request;

class JournalEntryController extends Controller
{
    public function index($journalId, Request $request)
    {
        $journal = $request->user()->journals()->where('id', $journalId)->firstOrFail();

        return ['entries' => $journal->entries()->latest()->get()];
    }

    /**
     * Store new Journal
     * @return Response
     */
    public function store($journalId, Request $request)
    {
        $journal = Entry::create([
            'content' => '',
            'title' => '',
            'journal_id' => $journalId,
            'user_id' => $request->user()->id
        ]);

        return response([], 201);
    }
}
