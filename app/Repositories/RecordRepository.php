<?php
namespace App\Repositories;

use App\Models\Records;
use App\Models\TypeLang;

class RecordRepository
{
    protected $record;

    public function __construct(Records $record, TypeLang $typelang)
    {
        $this->record = $record;
        $this->typelang = $typelang;
    }

    public function create(int $record_id)
    {
        return $this->record->create([
            'record_id' => $record_id]);
    }

    public function editRecord(array $data, int $record_id)
    {
        $this->record->where('record_id', $record_id)
            ->update($data);
    }

    public function getNextRecordId()
    {
        $last_record = $this->record->select('record_id')
            ->latest('record_id')
            ->first();

        if (!$last_record)
            return 1;
        else
            return ++$last_record->record_id;
    }

    public function getAll()
    {
        return $this->record->select('records.*')
            ->orderBy('record_id', 'DESC')
            ->get();
    }

    public function getById($record_id)
    {
        return $this->record->selectRaw('records.*, type_langs.title as type_lang_title')
            ->join('type_langs', 'type_langs.typelang_id', '=', 'records.typelang_id')
            ->where('record_id', $record_id)
            ->firstOrFail();
    }

    public function getByCond($typelang_id, $type_translate, $number_speech, $keywords)
    {
        $query = $this->record->selectRaw('records.*, type_langs.title as type_lang_title')
            ->join('type_langs', 'type_langs.typelang_id', '=', 'records.typelang_id');

        if ($number_speech != '')
            return $query->where('number_speech', $number_speech)->get();

        if (count($keywords) != 0)
            $query = $this->record->join('keywords_records', 'keywords_records.record_id', '=', 'records.record_id')
                ->join('keywords', 'keywords_records.keyword_id', '=', 'keywords.keyword_id')
                ->selectRaw('records.*, count(*) as num, type_langs.title as type_lang_title')
                ->whereIn('keywords_records.keyword_id', $keywords);

        if ($typelang_id != 0)
            $query->where('records.typelang_id', $typelang_id);

        if ($type_translate != 0)
            $query->where('records.type_translate', $type_translate);

        $query->where('active', 1);

        if (count($keywords) != 0)
        {
            $query->groupBy('records.record_id');
            $query->orderBy('num', 'DESC');
        }

        return $query->get();
    }

    public function getLastRecords()
    {
        return $this->record->selectRaw('records.*, type_langs.title as type_lang_title')
            ->join('type_langs', 'type_langs.typelang_id', '=', 'records.typelang_id')
            ->where('active', 1)
            ->orderBy('created_at', 'DESC')
            ->get();
    }


    public function getAllTypeLangs()
    {
        return $this->typelang->select('type_langs.*')
            ->orderBy('typelang_id', 'ASC')
            ->get();
    }
}