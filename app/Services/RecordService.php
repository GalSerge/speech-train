<?php

namespace App\Services;

use App\Repositories\RecordRepository;
use App\Repositories\KeywordRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;


class RecordService
{
    protected $recordRepository;
    protected $keywordRepository;

    /**
     * editorService constructor.
     * @param RecordRepository $recordRepository
     * @param KeywordRepository $keywordRepository
     */
    public function __construct(RecordRepository $recordRepository, KeywordRepository $keywordRepository)
    {
        $this->recordRepository = $recordRepository;
        $this->keywordRepository = $keywordRepository;
    }

    public function createRecord()
    {
        $record_id = $this->recordRepository->getNextRecordId();
        $this->recordRepository->create($record_id);

        return $record_id;
    }

    public function editRecord(Request $request, int $record_id)
    {
        $validate_data = $request->validate([
            'title' => '',
            'description' => '',
            'video' => '',
            'number_speech' => '',
            'long_time' => 'numeric',
            'type_translate' => 'numeric',
            'typelang_id' => 'numeric',
            'active' => ''
        ]);

        $user = session()->get('user');
        if (empty($user))
            return redirect()->route('loginForm');

        preg_match('/embed\/([^"]+)/', $validate_data['video'], $matches);
        if (isset($matches[1]))
            $validate_data['video_code'] = $matches[1];

        $this->recordRepository->editRecord($validate_data, $record_id);

        $keywords_data = array();
        foreach ($request['keywords'] as $keyword)
        {
            $keywords_data[] = [
                'record_id' => $record_id,
                'keyword_id' => $keyword];
        }

        $this->addRecordKeywords($keywords_data, $record_id);
    }

    public function addRecordKeywords($data, $record_id)
    {
        $this->keywordRepository->removeRecordKeywords($record_id);
        $this->keywordRepository->insertRecordKeywords($data);
    }

    public function getAllRecords()
    {
        return $this->recordRepository->getAll();
    }

    public function getAllKeywords()
    {
        return $this->keywordRepository->getAll();
    }

    public function getRecord($record_id)
    {
        $result = $this->recordRepository->getById($record_id)->toArray();
        $result['keywords'] = $this->keywordRepository->getRecordKeywords($record_id)->toArray();
        $result['keywords_ids'] = array_column($result['keywords'], 'keyword_id');

        return $result;
    }

    public function addNewKeyword(string $text)
    {
        return $this->keywordRepository->add([
            'word' => $text]);
    }

    public function getRecordsByCond($request)
    {
        $typelang_id = (int) $request->input('typelang_id');
        $type_translate = (int) $request->input('type_translate');
        $number_speech = (string)$request->input('number_speech');
        $keywords = (array)$request->input('keywords');

        $records = $this->recordRepository->getByCond($typelang_id, $type_translate, $number_speech, $keywords)->toArray();

        foreach ($records as $i => $record)
            $records[$i]['keywords'] = $this->keywordRepository->getRecordKeywords($record['record_id'])->toArray();

        return $records;
    }

    function getLastRecords() {
        $records = $this->recordRepository->getLastRecords()->toArray();

        foreach ($records as $i => $record)
            $records[$i]['keywords'] = $this->keywordRepository->getRecordKeywords($record['record_id'])->toArray();

        return $records;
    }

    function getAllTypeLangs()
    {
        return $this->recordRepository->getAllTypeLangs();
    }
}