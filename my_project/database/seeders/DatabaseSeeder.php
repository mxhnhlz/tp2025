<?php

namespace Database\Seeders;

use App\Models\Question;
use App\Models\QuestionOption;
use App\Models\QuestionTextAnswer;
use App\Models\Section;
use App\Models\Task;
use App\Models\Theory;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin2@mail.com',
            'password' => bcrypt('111'),
            'role' => 'admin',
        ]);

        $this->runMain();
    }

    public function runMain(): void
    {
        /*
        |--------------------------------------------------------------------------
        | 1. SECTION: "Безопасность и пароли"
        |--------------------------------------------------------------------------
        */
        $section = Section::create([
            'title' => 'Безопасность и пароли',
            'description' => 'Раздел посвящён созданию, хранению и защите паролей.',
        ]);

        $this->runTestTask();

        /*
        |--------------------------------------------------------------------------
        | 2. TASKS
        |--------------------------------------------------------------------------
        */
        $task2 = Task::create([
            'section_id' => $section->id,
            'title' => 'Методы взлома паролей',
            'slug' => 'password-attacks',
            'description' => 'Популярные способы получения паролей злоумышленниками.',
            'difficulty' => 'medium',
            'points' => 10,
            'order' => 2
        ]);

        $task3 = Task::create([
            'section_id' => $section->id,
            'title' => 'Безопасное хранение паролей',
            'slug' => 'password-storage',
            'description' => 'Хеширование, соль, перец и алгоритмы защиты.',
            'difficulty' => 'hard',
            'points' => 20,
            'order' => 3
        ]);

        /*
        |--------------------------------------------------------------------------
        | 3. THEORIES
        |--------------------------------------------------------------------------
        */
        Theory::create([
            'task_id' => $task2->id,
            'content' => '
<section>
    <h1>Менеджеры паролей</h1>
    <p>Менеджеры паролей помогают хранить, генерировать и защищать сложные пароли. Они позволяют не запоминать каждый пароль вручную и обеспечивают дополнительный уровень безопасности.</p>

    <h2>Преимущества использования менеджеров</h2>
    <ul>
        <li>Создают уникальные и сложные пароли автоматически</li>
        <li>Хранят пароли в зашифрованной форме</li>
        <li>Автозаполнение форм позволяет экономить время</li>
        <li>Некоторые поддерживают двухфакторную аутентификацию (2FA)</li>
    </ul>

    <h1>Популярные менеджеры паролей:</h1>
    <ol>
        <li>Bitwarden — бесплатный и с открытым исходным кодом</li>
        <li>1Password — надежный коммерческий вариант</li>
        <li>KeePass — оффлайн менеджер для ПК</li>
    </ol>

    <h2><strong>Пример интерфейса менеджера паролей:</strong></h2>
    <img src="https://cdsassets.apple.com/live/7WUAS350/images/macos/sequoia/macos-sequoia-passwords-selected-website-edit-password.png" alt="Менеджер паролей" style="margin:20px 0; width:100%; border-radius:10px;">

    <p>Использование менеджеров значительно повышает безопасность ваших аккаунтов и позволяет легко управлять паролями.</p>
</section>
'
        ]);

        Theory::create([
            'task_id' => $task3->id,
            'content' => '
<section>
    <h1>Фишинг и защита аккаунтов</h1>
    <p>Фишинг — это метод социальной инженерии, при котором злоумышленники пытаются получить ваши пароли и личные данные через поддельные сайты или электронные письма.</p>

    <h2>Как распознать фишинг</h2>
    <ul>
        <li>Проверяйте URL сайта перед вводом пароля</li>
        <li>Не переходите по подозрительным ссылкам из писем</li>
        <li>Будьте осторожны с письмами, где требуют срочно ввести данные</li>
        <li>Не открывайте вложения от неизвестных отправителей</li>
    </ul>

    <h2>Примеры фишинговых писем:</h2>
    <img src="https://cdn.securitylab.ru/upload/main/cfd/cfddecb5acc29cd8bbb6d50fb6c3bf33.png" alt="Фишинговое письмо" style="margin:20px 0; width:100%; border-radius:10px;">

    <h1><strong>Защита аккаунтов</strong></h1>
    <ul>
        <li>Используйте <strong>двухфакторную аутентификацию</strong></li>
        <li>Регулярно обновляйте пароли</li>
        <li>Проверяйте активность аккаунтов</li>
    </ul>

    <p>Осведомленность о методах фишинга и соблюдение правил безопасности помогают защитить ваши личные данные и аккаунты.</p>
</section>
'
        ]);

        $q2 = Question::create([
            'task_id' => $task2->id,
            'content' => 'Что такое брутфорс?',
            'type' => 'single',
            'points' => 2,
        ]);

        $q3 = Question::create([
            'task_id' => $task3->id,
            'content' => 'Как правильно хранить пароли?',
            'type' => 'text',
            'points' => 5,
        ]);

        /*
        |--------------------------------------------------------------------------
        | 5. OPTIONS для вопросов одного выбора
        |--------------------------------------------------------------------------
        */


        // q2
        QuestionOption::create([
            'question_id' => $q2->id,
            'content' => 'Перебор всех возможных комбинаций пароля',
            'is_correct' => true
        ]);
        QuestionOption::create([
            'question_id' => $q2->id,
            'content' => 'Использование случайных символов',
            'is_correct' => false
        ]);

        /*
        |--------------------------------------------------------------------------
        | 6. TEXT ANSWER (правильный текстовый ответ)
        |--------------------------------------------------------------------------
        */
        QuestionTextAnswer::create([
            'question_id' => $q3->id,
            'correct_answer' => 'Открыто'
        ]);
    }

    private function runTestTask(): void
    {
        $task = Task::create([
            'section_id' => 1, // замените на нужный раздел
            'title' => 'Что такое надёжный пароль?',
            'slug' => 'secure-password',
            'description' => 'Проверка знаний о создании и хранении надёжных паролей',
            'difficulty' => 'easy',
            'points' => 20,
            'order' => 1,
        ]);

        Theory::create([
            'task_id' => $task->id,
            'content' => '
<section>
    <h1>Что такое безопасные пароли</h1>
    <p>Безопасный пароль — это ключ для защиты ваших аккаунтов и личных данных. Он должен быть уникальным и сложным, чтобы его было невозможно угадать или взломать.</p>

    <h2>Правила создания безопасного пароля</h2>
    <ul>
        <li>Не используйте простые слова или личную информацию (имя, дату рождения)</li>
        <li>Смешивайте <strong>буквы верхнего и нижнего регистра</strong>, цифры и специальные символы</li>
        <li>Длина пароля должна быть не менее <strong>12 символов</strong></li>
        <li>Используйте уникальный пароль для каждого сервиса</li>
    </ul>

    <h2><strong>Примеры надежных паролей:</strong></h2>
    <img src="https://codeby.net/attachments/secure-password-3-jpg.43258/" alt="Пример безопасного пароля" style="margin:20px 0; width:100%; border-radius:10px;">

    <p>Следуя этим правилам, вы значительно уменьшаете риск взлома аккаунтов.</p>
</section>
'
        ]);


        /*
        |--------------------------------------------------------------------------
        | Вопросы
        |--------------------------------------------------------------------------
        */
// Single выбор (1 правильный)
        $q1 = Question::create([
            'task_id' => $task->id,
            'content' => 'Что делает пароль надёжным?',
            'type' => 'single',
            'points' => 2,
        ]);

        $q2 = Question::create([
            'task_id' => $task->id,
            'content' => 'Какая длина пароля считается минимальной для надёжного?',
            'type' => 'single',
            'points' => 3,
        ]);

        $q3 = Question::create([
            'task_id' => $task->id,
            'content' => 'Что такое брутфорс атака?',
            'type' => 'single',
            'points' => 2,
        ]);

// Multiple выбор (несколько правильных)
        $q4 = Question::create([
            'task_id' => $task->id,
            'content' => 'Какие из следующих правил повышают надёжность пароля?',
            'type' => 'multiple',
            'points' => 10,
        ]);

        $q5 = Question::create([
            'task_id' => $task->id,
            'content' => 'Какие действия помогают безопасно хранить пароли?',
            'type' => 'multiple',
            'points' => 10,
        ]);

// Text ответы
        $q6 = Question::create([
            'task_id' => $task->id,
            'content' => 'Напишите пример символа, который можно использовать в сложном пароле',
            'type' => 'text',
            'points' => 5,
        ]);

        $q7 = Question::create([
            'task_id' => $task->id,
            'content' => 'Какое число из 5 цифр лучше не использовать для пароля?',
            'type' => 'text',
            'points' => 5,
        ]);

// Дополнительные single/multiple
        $q8 = Question::create([
            'task_id' => $task->id,
            'content' => 'Что делает использование уникального пароля для каждого аккаунта?',
            'type' => 'single',
            'points' => 10,
        ]);

        $q9 = Question::create([
            'task_id' => $task->id,
            'content' => 'Выберите безопасные методы восстановления пароля:',
            'type' => 'multiple',
            'points' => 10,
        ]);

        $q10 = Question::create([
            'task_id' => $task->id,
            'content' => 'Что нужно сделать перед тем как хранить пароль в базе данных?',
            'type' => 'single',
            'points' => 15,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Варианты ответов single
        |--------------------------------------------------------------------------
        */
// q1
        QuestionOption::create(['question_id' => $q1->id, 'content' => 'Длина 12+ символов и разные типы знаков', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q1->id, 'content' => 'Имя или дата рождения', 'is_correct' => false]);

// q2
        QuestionOption::create(['question_id' => $q2->id, 'content' => '8 символов', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q2->id, 'content' => '12 символов и более', 'is_correct' => true]);

// q3
        QuestionOption::create(['question_id' => $q3->id, 'content' => 'Перебор всех возможных комбинаций пароля', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q3->id, 'content' => 'Использование случайных символов', 'is_correct' => false]);

// q8
        QuestionOption::create(['question_id' => $q8->id, 'content' => 'Снижает риск компрометации других аккаунтов', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q8->id, 'content' => 'Упрощает восстановление пароля', 'is_correct' => false]);

// q10
        QuestionOption::create(['question_id' => $q10->id, 'content' => 'Хэшировать перед хранением', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q10->id, 'content' => 'Хранить в открытом виде', 'is_correct' => false]);

        /*
        |--------------------------------------------------------------------------
        | Варианты ответов multiple
        |--------------------------------------------------------------------------
        */
// q4
        QuestionOption::create(['question_id' => $q4->id, 'content' => 'Использование цифр', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q4->id, 'content' => 'Использование специальных символов', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q4->id, 'content' => 'Использование имени питомца', 'is_correct' => false]);

// q5
        QuestionOption::create(['question_id' => $q5->id, 'content' => 'Использовать менеджер паролей', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q5->id, 'content' => 'Записывать в блокнот на столе', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q5->id, 'content' => 'Не использовать один и тот же пароль для разных сайтов', 'is_correct' => true]);

// q9
        QuestionOption::create(['question_id' => $q9->id, 'content' => 'Через электронную почту', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q9->id, 'content' => 'Через SMS без проверки', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q9->id, 'content' => 'Секретные вопросы и двухфакторная аутентификация', 'is_correct' => true]);

        /*
        |--------------------------------------------------------------------------
        | Текстовые ответы
        |--------------------------------------------------------------------------
        */
// q6
        QuestionTextAnswer::create(['question_id' => $q6->id, 'correct_answer' => '@']);

// q7
        QuestionTextAnswer::create(['question_id' => $q7->id, 'correct_answer' => '12345']);

    }
}
