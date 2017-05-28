<?php

namespace Diary\Transformers;

use App\Journal;
use Diary\Transformers\EntryTransformer;
use League\Fractal\TransformerAbstract;

class JournalTransformer extends TransformerAbstract
{
    protected $availableIncludes = [
        'entries'
    ];

    protected $defaultIncludes = [
        'entries'
    ];

    public function transform(Journal $journal)
    {
        return [
            'id'      => $journal->id,
            'title'   => $journal->title,
            'links'   => [
                [
                    'rel' => 'self',
                    'uri' => '/journals/'.$journal->id,
                ]
            ],
        ];
    }

    public function includeEntries(Journal $journal)
    {
        $entries = $journal->entries;

        return $this->collection($entries, new EntryTransformer, 'entry');
    }

}