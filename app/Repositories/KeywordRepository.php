<?php
namespace App\Repositories;

use App\Models\Keyword;
use App\Models\KeywordsRecord;


class KeywordRepository
{
    protected $keyword;
    protected $keyword_record;

    /**
     * @param Keyword $keyword
     * @param RecordKeyword $keyword_record
     */
    public function __construct(Keyword $keyword, KeywordsRecord $keyword_record)
    {
        $this->keyword = $keyword;
        $this->keyword_record = $keyword_record;
    }

    public function add(array $keyword)
    {
        return $this->keyword->insertGetId($keyword);
    }

   public function removeRecordKeywords(int $record_id)
   {
       $this->keyword_record->where('record_id', $record_id)->delete();
   }

    public function insertRecordKeywords(array $data)
    {
        $this->keyword_record->insert($data);
    }

    public function getAll()
    {
        return $this->keyword->select('keywords.*')
            ->orderBy('keyword_id', 'DESC')
            ->get();
    }

    public function getRecordKeywords(int $record_id)
    {
        return $this->keyword->join('keywords_records', 'keywords_records.keyword_id', '=', 'keywords.keyword_id')
            ->join('records', 'keywords_records.record_id', '=', 'records.record_id')
            ->select('keywords.*')
            ->where('records.record_id', $record_id)
            ->get();
    }
}