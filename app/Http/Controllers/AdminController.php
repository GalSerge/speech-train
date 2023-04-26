<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RecordService;
use App\Services\SectionService;
use App\Services\UserService;


class AdminController extends Controller
{
    protected $issue;
    protected $section;
    protected $editor;
    protected $user;

    public function __construct(SectionService $section, Recordservice $record, UserService $user)
    {
        $this->record = $record;
        $this->section = $section;
        $this->user = $user;
    }

    public function index()
    {
        return view('admin.main',
        [
            'title' => 'Добро пожаловать в панель администрирования'
        ]);
    }

    public function getAdmins()
    {
        $users = $this->user->getAllUsers();

        return view('admin.pages.admins', [
            'users' => $users,
            'title' => 'Администраторы'
        ]);
    }

    public function getTypeLangs()
    {
        $typelangs = $this->record->getAllTypeLangs();

        return view('admin.pages.typelangs', [
            'typelangs' => $typelangs,
            'title' => 'Языки перевода'
        ]);
    }

    public function addAdmin()
    {
        return view('admin.pages.editadmin', [
            'title' => 'Добавить администратора',
        ]);
    }

    public function addAdminAction(Request $request)
    {
        $msg = 'Новый администратор добавлен';

        //обработка checkbox-ов
        if (!isset($request['active']))
            $request['active'] = 0;

        try {
            $user_id = $this->user->createUser();
            $this->user->editUser($request, $user_id);
        } catch (\Exception $exception) {
            $msg = $exception->getMessage();
            return redirect()->back()->with('msg', $msg);
        }

        return redirect('/admin/edit-admin/'.$user_id)->with('msg', $msg)->withInput();
    }

    public function editAdmin($user_id)
    {
        $user = $this->user->getUserById($user_id);

        return view('admin.pages.editadmin', [
            'user' => $user,
            'title' => 'Редактировать информацию об администраторе',
        ]);
    }

    public function editAdminAction(Request $request, $user_id)
    {
        $msg = 'Данные успешно изменены';

        //обработка checkbox-ов
        if (!isset($request['active']))
            $request['active'] = 0;

        try {
            $this->user->editUser($request, $user_id);
        } catch (\Exception $exception) {
            $msg = $exception->getMessage();
            return back()->with('msg', $msg);
        }

       return redirect('/admin/edit-admin/'.$user_id)->with('msg', $msg);
    }

    public function getRecords()
    {
        $records = $this->record->getAllRecords();

        return view('admin.pages.records', [
            'records' => $records,
            'title' => 'Записи'
        ]);
    }

    public function addRecord()
    {
        $keywords = $this->record->getAllKeywords();
        $typelangs = $this->record->getAllTypeLangs();

        return view('admin.pages.editrecord', [
            'keywords' => $keywords,
            'title' => 'Добавить запись',
            'typelangs' => $typelangs
        ]);
    }

    public function addRecordAction(Request $request)
    {
        $msg = 'Новая запись добавлена';

        $data = $request->toArray();

        //обработка checkbox-ов
        if (!isset($data['record']['active']))
            $data['record']['active'] = 0;

        $data['record']['long_time'] = (int) $data['record']['long_time'];
        $record = $data['record'];

        try {
            $record_id = $this->record->createRecord();

            $this->record->editRecord(new Request($record), $record_id);
        } catch (\Exception $exception) {
            $msg = $exception->getMessage();
            return redirect()->back()->with('msg', $msg)->withInput();
        }

        return redirect('/admin/edit-record/'.$record_id)->with('msg', $msg)->withInput();
    }

    public function editRecord($record_id)
    {
        $record = $this->record->getRecord($record_id);
        $keywords = $this->record->getAllKeywords();
        $typelangs = $this->record->getAllTypeLangs();

        return view('admin.pages.editrecord', [
            'record' => $record,
            'keywords' => $keywords,
            'title' => 'Редактировать информацию о записи',
            'typelangs' => $typelangs
        ]);
    }

    public function editRecordAction(Request $request, $record_id)
    {
        $msg = 'Данные успешно изменены';

        $data = $request->toArray();

        //обработка checkbox-ов
        if (!isset($data['record']['active']))
            $data['record']['active'] = 0;

        $data['record']['long_time'] = (int) $data['record']['long_time'];
        $record = $data['record'];

        try {
            $this->record->editRecord(new Request($record), $record_id);
        } catch (\Exception $exception) {
            $msg = $exception->getMessage();
            return redirect()->back()->with('msg', $msg)->withInput();
        }

        return redirect()->back()->with('msg', $msg)->withInput();
    }

    public function getSections()
    {
        $sections = $this->section->getAllSections();

        return view('admin.pages.sections', [
            'sections' => $sections,
            'title' => 'Страницы'
        ]);
    }

    public function addSection()
    {
        $parents_rus = $this->section->getParents('ru');
        $parents_eng = $this->section->getParents('en');

        return view('admin.pages.editsection', [
            'parents_eng' => $parents_eng,
            'parents_rus' => $parents_rus,
            'title' => 'Добавить страницу',
        ]);
    }

    public function addSectionAction(Request $request)
    {
        $msg = 'Новая страница добавлена';

        $data = $request->toArray();

        //обработка checkbox-ов
        if (!isset($data['is_module']))
            $data['is_module'] = 0;

        if (!isset($data['section_rus']['active']))
            $data['section_rus']['active'] = 0;

        if (!isset($data['section_eng']['active']))
            $data['section_eng']['active'] = 0;

        if (!isset($data['section_rus']['show_in_menu']))
            $data['section_rus']['show_in_menu'] = 0;

        if (!isset($data['section_eng']['show_in_menu']))
            $data['section_eng']['show_in_menu'] = 0;

        $section_rus = $data['section_rus'];
        $section_rus['address'] = $data['address'];
        $section_rus['is_module'] = $data['is_module'];

        $section_eng = $data['section_eng'];
        $section_eng['address'] = $data['address'];
        $section_eng['is_module'] = $data['is_module'];

        try {
            $section_id = $this->section->createSection();

            $this->section->editSection(new Request($section_rus), $section_id);
            $this->section->editSection(new Request($section_eng), $section_id);
        } catch (\Exception $exception) {
            $msg = $exception->getMessage();
            return redirect()->back()->with('msg', $msg)->withInput();
        }

        return redirect('/admin/edit-section/'.$section_id)->with('msg', $msg)->withInput();
    }

    public function editSection($section_id)
    {
        $section_eng = $this->section->getSectionById($section_id, 'en');
        $section_rus = $this->section->getSectionById($section_id, 'ru');

        $parents_rus = $this->section->getParents('ru');
        $parents_eng = $this->section->getParents('en');

        return view('admin.pages.editsection', [
            'section_rus' => $section_rus,
            'section_eng' => $section_eng,
            'parents_eng' => $parents_eng,
            'parents_rus' => $parents_rus,
            'title' => 'Редактировать информацию о странице'
        ]);
    }

    public function editSectionAction(Request $request, $section_id)
    {
        $msg = 'Данные успешно изменены';

        $data = $request->toArray();

        //обработка checkbox-ов
        if (!isset($data['is_module']))
            $data['is_module'] = 0;

        if (!isset($data['section_rus']['active']))
            $data['section_rus']['active'] = 0;

        if (!isset($data['section_eng']['active']))
            $data['section_eng']['active'] = 0;

        if (!isset($data['section_rus']['show_in_menu']))
            $data['section_rus']['show_in_menu'] = 0;

        if (!isset($data['section_eng']['show_in_menu']))
            $data['section_eng']['show_in_menu'] = 0;

        $section_rus = $data['section_rus'];
        $section_rus['address'] = $data['address'];
        $section_rus['is_module'] = $data['is_module'];
//        $section_rus['lang_id'] = 1;

        $section_eng = $data['section_eng'];
        $section_eng['address'] = $data['address'];
        $section_eng['is_module'] = $data['is_module'];
//        $section_eng['lang_id'] = 2;

        try {
            $this->section->editSection(new Request($section_rus), $section_id);
            $this->section->editSection(new Request($section_eng), $section_id);
        } catch (\Exception $exception) {
            $msg = $exception->getMessage();
            return redirect()->back()->with('msg', $msg)->withInput();
        }

        return redirect()->back()->with('msg', $msg)->withInput();
    }

    public function addNewKeyword(Request $request)
    {
        $tag_id = $this->record->addNewKeyword($request->input('text'));

        return response()->json(array('tag_id'=> $tag_id), 200);
    }

}
