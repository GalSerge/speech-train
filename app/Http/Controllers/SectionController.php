<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RecordService;
use App\Services\SectionService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\App;

class SectionController extends Controller
{
    protected $section;
    protected $record;

    public function __construct(SectionService $section, RecordService $record)
    {
        $this->section = $section;
        $this->record = $record;
    }

    public function test()
    {
//        config('app.url').'/',
//    'root'         => public_path('/'),
        dd(public_path('app.url'), config('app.url'));
    }

    /**
     * Собирает все необходимы для отображения страницы компоненты и отправляет их в полученный шаблон
     * @param string $template название шаблона
     * @param array $page_params дополнительные параметры для конкретного раздела
     * @return mixed
     */
    protected function viewDefaultPage(string $template, array $page_params=array())
    {
//        $sections = $this->section->getSectionsForMenu();
//        $current_issue = $this->issue->getCurrentIssue();
//
//        //список страниц для генерации меню
//        $page_params['pages'] = $sections;
//
        //если вызвана главная страница, то необходимо содержание текущего выпуска
        //оно в getCurrentIssue() отсутствует
        if ($template == 'main')
        {
            $keywords = $this->record->getAllKeywords();
            $page_params['keywords'] = $keywords;

            $records = $this->record->getLastRecords();
            $page_params['records'] = $records;
            $page_params['title'] = 'latest_title';
        }

        return view($template, $page_params);
    }

    public function openMain()
    {
        return $this->viewDefaultPage('main');
    }

    public function getRecords(Request $request)
    {
        $records = $this->record->getRecordsByCond($request);

        if (count($records) == 0)
            $title = 'no_results_title';
        else
            $title = 'results_title';

        $returnHTML = view('components.recordslist')->with(['records' => $records, 'title' => $title])->render();
        return response()->json(['list' => $returnHTML]);
    }

    /*
     * Все функции ниже работают по одному принципу
     * Они обращаются к сервису соответствующего раздела, получают данные именно этого раздела
     * и отдают их в viewDefaultPage()
     */
    public function openSection($address)
    {
        $section = $this->section->getSection($address);
        return $this->viewDefaultPage('pages.section', ['section' => $section]);
    }

    public function openRecord($record_id)
    {
        $record = $this->record->getRecord($record_id);
        return $this->viewDefaultPage('pages.record', ['record' => $record]);
    }
}
