<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Section;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;

class AdminSectionController extends Controller
{
    //показать список всех разделов

    public function index()
    {
        $sections = Section::all();
        return view('admin.sections.index', compact('sections'));
    }

    public function preview(int $sectionId)
    {
        $section = Section::query()
            ->with([
                'tasks' => function (HasMany $query) {
                    $query
                        ->withSum('questions', 'points')   // сумма баллов по вопросам
                        ->with('theory')                   // теория для задания
                        ->with(['questions.textAnswers']); // текстовые ответы для вопросов
                }
            ])
            ->findOrFail($sectionId);
        return view('admin.sections.preview', compact('section'));
    }

    //показать форму создания раздела

    public function create()
    {
        return view('admin.sections.create');
    }

    //сохранить новый раздел в бд

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        Section::create($validated);
        return redirect()->route('admin.sections.index')->with('success', 'Раздел успешно создан!');

    }

    //обновить раздел в БД

    public function update(Request $request, Section $section)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string'
        ]);

        $section->update($validated);

        return redirect()->route('admin.sections.index')
            ->with('success', 'Раздел обновлён!');
    }

    //удалить раздел

    public function destroy(Section $section)
    {
        $section->delete();

        return redirect()->route('admin.sections.index')
            ->with('success', 'Раздел удалён!');
    }

    // Показать форму редактирования
    public function edit(Section $section)
    {
        return view('admin.sections.edit', compact('section'));
    }

    public function show($id)
    {
        $section = Section::findOrFail($id);
        return view('admin.sections.show', compact('section'));
    }

}
