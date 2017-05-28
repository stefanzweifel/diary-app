<?php

namespace Diary\Api\Http\Controllers;

use App\Entry;
use App\Http\Controllers\Controller;
use App\Journal;
use Diary\Api\Http\Requests\CreateEntryRequest;
use Diary\Api\Http\Requests\JournalRequest;
use Diary\Transformers\EntryTransformer;

class JournalEntryController extends Controller
{
    public function index(Journal $journal, JournalRequest $request)
    {
        return fractal()
           ->collection($journal->entries()->latest()->get())
           ->transformWith(new EntryTransformer())
           ->withResourceName('entry')
           ->respond();

    }

    /**
     * Store new Entry for a Journal
     * @return Response
     */
    public function store(Journal $journal, CreateEntryRequest $request)
    {
        $journal = Entry::create([
            'content' => '',
            'title' => '',
            'journal_id' => $journal->id,
            'user_id' => $request->user()->id
        ]);

        return response([], 201);
    }
}
