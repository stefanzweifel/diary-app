<?php

namespace Diary\Api\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Journal;
use Dingo\Api\Auth\Auth;
use Dingo\Api\Exception\StoreResourceFailedException;
use Dingo\Api\Routing\Helpers;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class JournalController extends Controller
{
    use Helpers;

    /**
     * List all Journals for authenticated user
     * @return Response
     */
    public function index()
    {
        return app(Auth::class)->user()->journals()->latest()->get();
    }

    /**
     * Store new Journal
     * @return Response
     */
    public function store()
    {
        $payload = app('request')->only('title');

        $validator = app('validator')->make($payload, [
            'title' => ['required']
        ]);

        if ($validator->fails()) {
            throw new StoreResourceFailedException('Could not create new journal.', $validator->errors());
        }

        $journal = Journal::create([
            'title' => app('request')->title,
            'user_id' => app(Auth::class)->user()->id
        ]);

        return $this->response->created("/journals/{$journal->id}");
    }

    /**
     * Show Details about a Journal
     * @param  integer $journalId
     * @return Response
     */
    public function show($journalId)
    {
        $journal = app(Auth::class)->user()->journals()->where('id', $journalId)->first();

        if (is_null($journal)) {
            throw new NotFoundHttpException;
        }

        return $journal;
    }

    /**
     * Update a Journal
     * @param  integer $journalId
     * @return Response
     */
    public function update($journalId)
    {
        $validator = app('validator')->make(
            app('request')->only('title'),
            ['title' => ['required']]
        );

        if ($validator->fails()) {
            throw new UpdateResourceFailedException('Could not update journal.', $validator->errors());
        }

        $journal = app(Auth::class)->user()->journals()->findOrFail($journalId);

        $journal = $journal->update([
            'title' => app('request')->title
        ]);

        return $this->response->created("/journals/{$journal->id}");
    }

    /**
     * Destroy a Journal
     * @param  integer $journalId
     * @return Response
     */
    public function destroy($journalId)
    {
        $journal = app(Auth::class)->user()->journals()->where('id', $journalId)->first();

        if (is_null($journal)) {
            throw new NotFoundHttpException;
        }

        $journal->delete();

        return $this->response->noContent();
    }

}
