<?php

namespace Diary\Api\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Journal;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class JournalController extends Controller
{
    /**
     * List all Journals for authenticated user
     * @return Response
     */
    public function index(Request $request)
    {
        return response([
            'journals' => $request->user()->journals()->latest()->get()
        ]);
    }

    /**
     * Store new Journal
     * @return Response
     */
    public function store(Request $request)
    {
        $payload = $request->only('title');

        $validator = app('validator')->make($payload, [
            'title' => ['required']
        ]);

        // if ($validator->fails()) {
        //     throw new StoreResourceFailedException('Could not create new journal.', $validator->errors());
        // }

        $journal = Journal::create([
            'title' => $request->title,
            'user_id' => $request->user()->id
        ]);

        return response([], 201);
    }

    /**
     * Show Details about a Journal
     * @param  integer $journalId
     * @return Response
     */
    public function show($journalId, Request $request)
    {
        $journal = $request->user()->journals()->where('id', $journalId)->first();

        if (is_null($journal)) {
            throw new NotFoundHttpException;
        }

        return response(compact('journal'), 200);
    }

    /**
     * Update a Journal
     * @param  integer $journalId
     * @return Response
     */
    public function update($journalId, Request $request)
    {
        $validator = app('validator')->make(
            app('request')->only('title'),
            ['title' => ['required']]
        );

        if ($validator->fails()) {
            throw new UpdateResourceFailedException('Could not update journal.', $validator->errors());
        }

        $journal = $request->user()->journals()->findOrFail($journalId);

        $journal = $journal->update([
            'title' => app('request')->title
        ]);

        return response([], 201);
    }

    /**
     * Destroy a Journal
     * @param  integer $journalId
     * @return Response
     */
    public function destroy($journalId, Request $request)
    {
        $journal = $request->user()->journals()->where('id', $journalId)->first();

        if (is_null($journal)) {
            throw new NotFoundHttpException;
        }

        $journal->delete();

        return response([], 204);
    }

}
