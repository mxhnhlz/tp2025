@extends('layouts.app')

@section('title', 'Добавить вопрос')

@section('content')
    <h1>Добавить вопрос</h1>

    <form action="{{ route('questions.store') }}" method="POST">
        @csrf

        <!-- Выбор задания -->
        <div class="mb-3">
            <label>Задание</label>
            <select name="task_id" class="form-control" required>
                @foreach($tasks as $task)
                    <option value="{{ $task->id }}">{{ $task->title }}</option>
                @endforeach
            </select>
        </div>

        <!-- Текст вопроса -->
        <div class="mb-3">
            <label>Вопрос</label>
            <textarea name="content" class="form-control" required></textarea>
        </div>

        <!-- Тип вопроса -->
        <div class="mb-3">
            <label>Тип вопроса</label>
            <select name="type" id="questionType" class="form-control" required>
                <option value="single_choice">Один правильный ответ</option>
                <option value="multiple_choice">Несколько правильных ответов</option>
                <option value="text">Текстовый ответ</option>
            </select>
        </div>

        <!-- Подсказка -->
        <div class="mb-3" id="hintContainer">
            <label>Подсказка (для текстового ответа)</label>
            <input type="text" name="hint" class="form-control">
        </div>

        <!-- Варианты ответов -->
        <div class="mb-3" id="answersContainer">
            <label>Варианты ответов</label>
            <div id="answersList"></div>
            <button type="button" class="btn btn-secondary mt-2" id="addAnswerBtn">Добавить вариант</button>
        </div>

        <!-- Порядок -->
        <div class="mb-3">
            <label>Порядок отображения</label>
            <input type="number" name="order" class="form-control" value="1" min="1" required>
        </div>

        <button type="submit" class="btn btn-primary">Сохранить</button>
    </form>

    <script>
        const answersContainer = document.getElementById('answersList');
        const addAnswerBtn = document.getElementById('addAnswerBtn');
        const questionType = document.getElementById('questionType');
        const hintContainer = document.getElementById('hintContainer');

        let answerCount = 0;

        // Функция добавления нового варианта
        function addAnswer() {
            answerCount++;
            const type = questionType.value;
            const isCheckbox = type === 'multiple_choice';
            const isRadio = type === 'single_choice';

            const div = document.createElement('div');
            div.classList.add('mb-2');

            div.innerHTML = `
                <input type="${isCheckbox ? 'checkbox' : (isRadio ? 'radio' : 'hidden')}" name="correct[]" value="${answerCount}">
                <input type="text" name="answers[]" class="form-control d-inline-block w-75" placeholder="Текст ответа" required>
                <button type="button" class="btn btn-danger btn-sm removeAnswer">Удалить</button>
            `;
            answersContainer.appendChild(div);

            div.querySelector('.removeAnswer').addEventListener('click', () => {
                div.remove();
            });
        }

        // Добавление первого варианта при загрузке
        addAnswer();

        // Кнопка добавления варианта
        addAnswerBtn.addEventListener('click', addAnswer);

        // Показ подсказки и вариантов в зависимости от типа вопроса
        questionType.addEventListener('change', function() {
            if(this.value === 'text') {
                hintContainer.style.display = 'block';
                answersContainer.parentElement.style.display = 'none';
            } else {
                hintContainer.style.display = 'none';
                answersContainer.parentElement.style.display = 'block';
            }
        });
    </script>
@endsection
