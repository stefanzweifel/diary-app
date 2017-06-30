<?php

namespace Diary\Api\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Journal;
use Diary\Api\Http\Requests\CreateJournalRequest;
use Diary\Api\Http\Requests\JournalRequest;
use Diary\Api\Http\Requests\UpdateJournalRequest;
use Diary\Transformers\JournalTransformer;
use Illuminate\Http\Request;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class JournalController extends Controller
{
    /**
     * List all Journals for authenticated user
     * @return Response
     */
    public function index(Request $request)
    {
        $paginator = $request->user()->journals()->latest()->paginate(25);
        $journals = $paginator->getCollection();

        return fractal()
           ->collection($journals)
           ->transformWith(new JournalTransformer())
           ->paginateWith(new IlluminatePaginatorAdapter($paginator))
           ->withResourceName('journal')
           ->respond();
    }

    /**
     * Store new Journal
     * @return Response
     */
    public function store(CreateJournalRequest $request)
    {
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
    public function show($journal, JournalRequest $request)
    {
        return fractal()
           ->item($journal)
           ->transformWith(new JournalTransformer())
           ->withResourceName('journal')
           ->respond();
    }

    /**
     * Update a Journal
     * @param  integer $journalId
     * @return Response
     */
    public function update($journal, UpdateJournalRequest $request)
    {
        $journal = $journal->update([
            'title' => $request->title
        ]);

        return response([], 200);
    }

    /**
     * Destroy a Journal
     * @param  integer $journalId
     * @return Response
     */
    public function destroy($journal, JournalRequest $request)
    {
        $journal->entries()->delete();
        $journal->delete();

        return response([], 204);
    }

}
