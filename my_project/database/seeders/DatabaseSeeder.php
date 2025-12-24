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

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin2@gmail.com',
            'password' => bcrypt('111'),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@gmail.com',
            'password' => bcrypt('111'),
            'role' => 'user',
        ]);


        $this->runSection1();
        $this->runSection2();
        $this->runSection3();
        $this->runSection4();
        $this->runSection5();
        $this->runSection6();
    }

    private function runSection1(): void
    {
        /*
        |--------------------------------------------------------------------------
        | РАЗДЕЛ 1: Основы кибербезопасности и ИБ
        |--------------------------------------------------------------------------
        */
        $section1 = Section::create([
            'title' => 'Основы кибербезопасности и информационной безопасности',
            'description' => 'Триада КИА: Конфиденциальность, Целостность, Доступность. Основные составляющие кибербезопасности.',
        ]);

        /*
        |--------------------------------------------------------------------------
        | ЗАДАЧА 1.1: Легкий уровень
        |--------------------------------------------------------------------------
        */
        $task1_1 = Task::create([
            'section_id' => $section1->id,
            'title' => 'Основы кибербезопасности - Легкий уровень',
            'slug' => 'cybersecurity-basics-easy',
            'description' => 'Базовые понятия кибербезопасности и информационной безопасности',
            'difficulty' => 'easy',
            'points' => 10,
            'order' => 1,
        ]);

        Theory::create([
            'task_id' => $task1_1->id,
            'content' => '
<section>
    <h1>Основы кибербезопасности и информационной безопасности</h1>
    <p><strong>Кибербезопасность</strong> — это состояние защиты информации, цифровых сведений, устройств и систем от несанкционированного доступа, использования, раскрытия, нарушения, изменения или уничтожения.</p>

    <p><strong>Информационная безопасность</strong> — это состояние защиты информации, обеспечивающее конфиденциальность, целостность и доступность.</p>

    <h2>Триада КИА (CIA Triad)</h2>
    <ul>
        <li><strong>Конфиденциальность</strong> — защита от несанкционированного доступа к информации</li>
        <li><strong>Целостность</strong> — актуальность, непротиворечивость и защита от несанкционированного изменения информации</li>
        <li><strong>Доступность</strong> — возможность за приемлемое время получить требуемую информационную услугу</li>
    </ul>

    <h2>Основные составляющие кибербезопасности</h2>
    <ul>
        <li>Надежные пароли</li>
        <li>Хорошие кибер-привычки</li>
        <li>Блокировка устройств</li>
        <li>Обновление программного обеспечения</li>
        <li>Резервные копии данных</li>
        <li>Многофакторная аутентификация</li>
    </ul>
</section>
',
        ]);

        // Вопрос 1.1.1
        $q1 = Question::create([
            'task_id' => $task1_1->id,
            'content' => 'Что такое кибербезопасность?',
            'type' => 'single',
            'points' => 2,
        ]);

        QuestionOption::create(['question_id' => $q1->id, 'content' => 'защита устройств, личных данных, файлов и т.д.', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q1->id, 'content' => 'это защита от несанкционированного доступа к информации', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q1->id, 'content' => 'состояние защиты информации, цифровых сведений, устройств...', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q1->id, 'content' => 'актуальность и непротиворечивость информации', 'is_correct' => false]);

        // Вопрос 1.1.2
        $q2 = Question::create([
            'task_id' => $task1_1->id,
            'content' => 'Какая из перечисленных составляющих НЕ является основной для кибербезопасности?',
            'type' => 'single',
            'points' => 2,
        ]);

        QuestionOption::create(['question_id' => $q2->id, 'content' => 'Надежные пароли', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q2->id, 'content' => 'Использование самой последней версии видеоигры', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q2->id, 'content' => 'Обновление ПО', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q2->id, 'content' => 'Резервные копии', 'is_correct' => false]);

        // Вопрос 1.1.3
        $q3 = Question::create([
            'task_id' => $task1_1->id,
            'content' => 'Выберите главные составляющие кибербезопасности:',
            'type' => 'multiple',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q3->id, 'content' => 'Надежные пароли', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q3->id, 'content' => 'Хорошие кибер-привычки', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q3->id, 'content' => 'Использование одного пароля везде', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q3->id, 'content' => 'Блокировка устройств', 'is_correct' => true]);

        // Вопрос 1.1.4
        $q4 = Question::create([
            'task_id' => $task1_1->id,
            'content' => 'Заполните пропуск: Возможность за приемлемое время получить требуемую информационную услугу — это ______.',
            'type' => 'text',
            'points' => 2,
        ]);

        QuestionTextAnswer::create(['question_id' => $q4->id, 'correct_answer' => 'доступность']);

        // Вопрос 1.1.5
        $q5 = Question::create([
            'task_id' => $task1_1->id,
            'content' => 'Ситуация: Компания обновила политику хранения данных. Какой принцип нарушен, если сотрудник случайно удалил важный отчет и его нельзя восстановить?',
            'type' => 'single',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q5->id, 'content' => 'Конфиденциальность', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q5->id, 'content' => 'Целостность', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q5->id, 'content' => 'Доступность', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q5->id, 'content' => 'Все принципы', 'is_correct' => false]);

        /*
        |--------------------------------------------------------------------------
        | ЗАДАЧА 1.2: Средний уровень
        |--------------------------------------------------------------------------
        */
        $task1_2 = Task::create([
            'section_id' => $section1->id,
            'title' => 'Основы кибербезопасности - Средний уровень',
            'slug' => 'cybersecurity-basics-medium',
            'description' => 'Глубокое понимание триады КИА и примеры нарушений',
            'difficulty' => 'medium',
            'points' => 15,
            'order' => 2,
        ]);

        Theory::create([
            'task_id' => $task1_2->id,
            'content' => '
<section>
    <h1>Глубокое понимание триады КИА</h1>

    <h2>Конфиденциальность</h2>
    <p>Защита от несанкционированного доступа к информации. Примеры нарушений:</p>
    <ul>
        <li>Пересылка конфиденциальных данных на личную почту</li>
        <li>Хранение паролей на видном месте (стикеры на мониторе)</li>
        <li>Утечка баз данных клиентов</li>
    </ul>

    <h2>Целостность</h2>
    <p>Актуальность, непротиворечивость и защита от несанкционированного изменения информации. Примеры нарушений:</p>
    <ul>
        <li>Изменение сумм в финансовых документах</li>
        <li>Подмена данных в отчетах</li>
        <li>Внесение изменений в чертежи или проекты</li>
    </ul>

    <h2>Доступность</h2>
    <p>Возможность получения информационной услуги в нужное время. Примеры нарушений:</p>
    <ul>
        <li>DDoS-атаки, делающие сервис недоступным</li>
        <li>Удаление важных файлов без возможности восстановления</li>
        <li>Блокировка доступа к системам</li>
    </ul>
</section>
',
        ]);

        // Вопрос 1.2.1
        $q6 = Question::create([
            'task_id' => $task1_2->id,
            'content' => 'Введите термин: Защита от несанкционированного доступа к информации.',
            'type' => 'text',
            'points' => 2,
        ]);

        QuestionTextAnswer::create(['question_id' => $q6->id, 'correct_answer' => 'конфиденциальность']);

        // Вопрос 1.2.2
        $q7 = Question::create([
            'task_id' => $task1_2->id,
            'content' => 'Что подразумевает "целостность" информации?',
            'type' => 'single',
            'points' => 2,
        ]);

        QuestionOption::create(['question_id' => $q7->id, 'content' => 'Ее защиту от копирования', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q7->id, 'content' => 'Ее актуальность, непротиворечивость и защиту от несанкционированного изменения', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q7->id, 'content' => 'Скорость ее передачи', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q7->id, 'content' => 'Ее общедоступность', 'is_correct' => false]);

        // Вопрос 1.2.3
        $q8 = Question::create([
            'task_id' => $task1_2->id,
            'content' => 'Какие из следующих ситуаций являются нарушением конфиденциальности?',
            'type' => 'multiple',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q8->id, 'content' => 'Сотрудник отправил базу данных клиентов на свою личную почту', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q8->id, 'content' => 'Вирус зашифровал файлы на сервере', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q8->id, 'content' => 'Пароль от системы был написан на стикере на мониторе', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q8->id, 'content' => 'Хакеры осуществили DDoS-атаку на сайт', 'is_correct' => false]);

        // Вопрос 1.2.4
        $q9 = Question::create([
            'task_id' => $task1_2->id,
            'content' => 'Ситуация: Помощник бухгалтера изменил в документе сумму своей премии, и главный бухгалтер подписал его, не заметив подлога. Какое свойство информации было нарушено?',
            'type' => 'single',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q9->id, 'content' => 'Конфиденциальность', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q9->id, 'content' => 'Целостность', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q9->id, 'content' => 'Доступность', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q9->id, 'content' => 'Ни одно из перечисленных', 'is_correct' => false]);

        // Вопрос 1.2.5
        $q10 = Question::create([
            'task_id' => $task1_2->id,
            'content' => 'Ситуация: Руководитель заявил, что для него важнее всего, чтобы данные не попали к конкурентам, даже если их придется немного изменять. Какой принцип он считает приоритетным?',
            'type' => 'single',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q10->id, 'content' => 'Конфиденциальность', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q10->id, 'content' => 'Целостность', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q10->id, 'content' => 'Доступность', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q10->id, 'content' => 'Все в равной степени', 'is_correct' => false]);

        /*
        |--------------------------------------------------------------------------
        | ЗАДАЧА 1.3: Сложный уровень
        |--------------------------------------------------------------------------
        */
        $task1_3 = Task::create([
            'section_id' => $section1->id,
            'title' => 'Основы кибербезопасности - Сложный уровень',
            'slug' => 'cybersecurity-basics-hard',
            'description' => 'Взаимосвязь принципов, оценка комплексных ситуаций',
            'difficulty' => 'hard',
            'points' => 20,
            'order' => 3,
        ]);

        Theory::create([
            'task_id' => $task1_3->id,
            'content' => '
<section>
    <h1>Взаимосвязь принципов и комплексные ситуации</h1>

    <p>В реальных ситуациях часто нарушается несколько принципов информационной безопасности одновременно. Важно уметь анализировать такие комплексные случаи и определять, какие принципы были нарушены.</p>

    <h2>Примеры комплексных нарушений:</h2>
    <ul>
        <li><strong>Взлом почты + подмена данных:</strong> Нарушение конфиденциальности (доступ к информации) и целостности (изменение данных)</li>
        <li><strong>Утечка базы данных:</strong> Нарушение конфиденциальности, которое может привести к нарушению доступности (спам, фишинг)</li>
        <li><strong>Хранение паролей в открытом виде:</strong> Прямая угроза конфиденциальности, которая может привести к нарушению всех трех принципов</li>
    </ul>

    <h2>Ответственность в кибербезопасности:</h2>
    <p>Каждый сотрудник несет ответственность за соблюдение принципов информационной безопасности. Незнание правил не освобождает от ответственности за последствия их нарушения.</p>
</section>
',
        ]);

        // Вопрос 1.3.1
        $q11 = Question::create([
            'task_id' => $task1_3->id,
            'content' => 'Ситуация: Злоумышленник взломал почту сотрудника, похитил чертежи нового продукта (нарушение А) и подменил в них ключевые параметры (нарушение Б). Какие принципы были нарушены?',
            'type' => 'single',
            'points' => 4,
        ]);

        QuestionOption::create(['question_id' => $q11->id, 'content' => 'А - Конфиденциальность, Б - Целостность', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q11->id, 'content' => 'А - Доступность, Б - Целостность', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q11->id, 'content' => 'Оба нарушения - это нарушение Конфиденциальности', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q11->id, 'content' => 'Оба нарушения - это нарушение Доступности', 'is_correct' => false]);

        // Вопрос 1.3.2
        $q12 = Question::create([
            'task_id' => $task1_3->id,
            'content' => 'При утечке базы данных "Спортмастера" (имена, телефоны, почты) какие принципы ИБ пострадали в первую очередь для клиентов компании?',
            'type' => 'multiple',
            'points' => 5,
        ]);

        QuestionOption::create(['question_id' => $q12->id, 'content' => 'Конфиденциальность их персональных данных', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q12->id, 'content' => 'Целостность данных на серверах "Спортмастера"', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q12->id, 'content' => 'Возможность злоупотребления этими данными (косвенно влияет на доступность их спокойствия)', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q12->id, 'content' => 'Доступность сайта "Спортмастера"', 'is_correct' => false]);

        // Вопрос 1.3.3
        $q13 = Question::create([
            'task_id' => $task1_3->id,
            'content' => 'Кибербезопасность является частью...',
            'type' => 'single',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q13->id, 'content' => 'Цифрового профиля', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q13->id, 'content' => 'Информационной безопасности', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q13->id, 'content' => 'Социальной инженерии', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q13->id, 'content' => 'Программного обеспечения', 'is_correct' => false]);

        // Вопрос 1.3.4
        $q14 = Question::create([
            'task_id' => $task1_3->id,
            'content' => 'Ситуация: Вы обнаружили, что коллега хранит пароли от корпоративных систем в незашифрованном файле на рабочем столе. Нарушение какого принципа ИБ это представляет наибольшую непосредственную угрозу?',
            'type' => 'single',
            'points' => 4,
        ]);

        QuestionOption::create(['question_id' => $q14->id, 'content' => 'Конфиденциальность', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q14->id, 'content' => 'Целостность', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q14->id, 'content' => 'Доступность', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q14->id, 'content' => 'Все перечисленные в равной степени', 'is_correct' => false]);

        // Вопрос 1.3.5
        $q15 = Question::create([
            'task_id' => $task1_3->id,
            'content' => 'Ситуация: В результате атаки на сайт госуслуг пользователи не могут подать заявления несколько дней. Это привело к финансовым потерям и падению доверия. Нарушение какого принципа стало ПЕРВОПРИЧИНОЙ всех последствий?',
            'type' => 'single',
            'points' => 4,
        ]);

        QuestionOption::create(['question_id' => $q15->id, 'content' => 'Конфиденциальности (утекли данные)', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q15->id, 'content' => 'Целостности (данные изменились)', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q15->id, 'content' => 'Доступности (сервис не работал)', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q15->id, 'content' => 'Всех одновременно', 'is_correct' => false]);
    }

    private function runSection2(): void
    {
        /*
        |--------------------------------------------------------------------------
        | РАЗДЕЛ 2: Цифровой профиль и безопасность в соцсетях
        |--------------------------------------------------------------------------
        */
        $section2 = Section::create([
            'title' => 'Цифровой профиль и безопасность в социальных сетях',
            'description' => 'Понятие цифрового профиля, безопасность в социальных сетях, кибербуллинг',
        ]);

        /*
        |--------------------------------------------------------------------------
        | ЗАДАЧА 2.1: Легкий уровень
        |--------------------------------------------------------------------------
        */
        $task2_1 = Task::create([
            'section_id' => $section2->id,
            'title' => 'Цифровой профиль - Легкий уровень',
            'slug' => 'digital-profile-easy',
            'description' => 'Базовые понятия цифрового профиля и безопасности в соцсетях',
            'difficulty' => 'easy',
            'points' => 10,
            'order' => 1,
        ]);

        Theory::create([
            'task_id' => $task2_1->id,
            'content' => '
<section>
    <h1>Цифровой профиль и безопасность в социальных сетях</h1>

    <h2>Что такое цифровой профиль?</h2>
    <p><strong>Цифровой профиль</strong> — это совокупность цифровых записей о вас в информационных системах.</p>

    <h2>Какие данные автоматически собираются о нас в сети:</h2>
    <ul>
        <li>История поиска в браузере</li>
        <li>Геолокация (местоположение)</li>
        <li>Время, проведенное на сайтах</li>
        <li>Покупки и интересы</li>
    </ul>

    <h2>Примеры технологий, использующих цифровой профиль:</h2>
    <ul>
        <li><strong>Face Pay</strong> — технология оплаты с помощью распознавания лица в московском метро</li>
        <li>Персонализированная реклама</li>
        <li>Рекомендательные системы (YouTube, Netflix)</li>
    </ul>

    <h2>Базовая осторожность в соцсетях:</h2>
    <ul>
        <li>Не размещайте личную информацию в открытом доступе</li>
        <li>Проверяйте настройки конфиденциальности</li>
        <li>Будьте осторожны с незнакомыми людьми</li>
    </ul>
</section>
',
        ]);

        // Вопрос 2.1.1
        $q16 = Question::create([
            'task_id' => $task2_1->id,
            'content' => 'Цифровой профиль — это...',
            'type' => 'single',
            'points' => 2,
        ]);

        QuestionOption::create(['question_id' => $q16->id, 'content' => 'Ваше фото на пропуске', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q16->id, 'content' => 'Совокупность цифровых записей о вас в информационных системах', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q16->id, 'content' => 'Только ваши пароли', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q16->id, 'content' => 'Ваш бумажный паспорт', 'is_correct' => false]);

        // Вопрос 2.1.2
        $q17 = Question::create([
            'task_id' => $task2_1->id,
            'content' => 'Технология оплаты с помощью распознавания лица в московском метро называется...',
            'type' => 'single',
            'points' => 2,
        ]);

        QuestionOption::create(['question_id' => $q17->id, 'content' => 'Face Pay', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q17->id, 'content' => 'BioPay', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q17->id, 'content' => 'Face ID', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q17->id, 'content' => 'MetroPay', 'is_correct' => false]);

        // Вопрос 2.1.3
        $q18 = Question::create([
            'task_id' => $task2_1->id,
            'content' => 'Что может входить в цифровой профиль человека?',
            'type' => 'multiple',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q18->id, 'content' => 'История поиска в браузере', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q18->id, 'content' => 'Геопозиции на фотографиях в соцсетях', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q18->id, 'content' => 'Записи на стене в социальных сетях', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q18->id, 'content' => 'Его внутренние мысли и мечты', 'is_correct' => false]);

        // Вопрос 2.1.4
        $q19 = Question::create([
            'task_id' => $task2_1->id,
            'content' => 'Просматривая открытую страницу человека в соцсети, злоумышленник НЕ может узнать...',
            'type' => 'single',
            'points' => 2,
        ]);

        QuestionOption::create(['question_id' => $q19->id, 'content' => 'Его место учебы', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q19->id, 'content' => 'Его примерные интересы', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q19->id, 'content' => 'Пароль от его почты', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q19->id, 'content' => 'Город проживания', 'is_correct' => false]);

        // Вопрос 2.1.5
        $q20 = Question::create([
            'task_id' => $task2_1->id,
            'content' => 'Ситуация: Вы видите в соцсети пост: "Ищу владельца кошелька, найденного в парке". К фото кошелька приложена карта с замазанным номером, но видно имя. Опасно ли это?',
            'type' => 'single',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q20->id, 'content' => 'Да, это может быть попытка сбора информации (имя + факт потери) для фишинга или социальной инженерии', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q20->id, 'content' => 'Нет, это благородный поступок', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q20->id, 'content' => 'Опасно только если показаны деньги', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q20->id, 'content' => 'Не опасно, раз номер карты замазан', 'is_correct' => false]);

        /*
        |--------------------------------------------------------------------------
        | ЗАДАЧА 2.2: Средний уровень
        |--------------------------------------------------------------------------
        */
        $task2_2 = Task::create([
            'section_id' => $section2->id,
            'title' => 'Безопасность в соцсетях - Средний уровень',
            'slug' => 'social-media-safety-medium',
            'description' => 'Риски в социальных сетях, фейковые аккаунты',
            'difficulty' => 'medium',
            'points' => 15,
            'order' => 2,
        ]);

        Theory::create([
            'task_id' => $task2_2->id,
            'content' => '
<section>
    <h1>Риски в социальных сетях</h1>

    <h2>Какая информация в соцсетях представляет наибольший риск:</h2>
    <ul>
        <li><strong>Точный домашний адрес</strong> — может быть использован для физических угроз</li>
        <li><strong>График отпусков/отъездов</strong> — информация о том, когда дома никого нет</li>
        <li><strong>Место работы</strong> — для целевого фишинга или атак на компанию</li>
        <li><strong>Точное местоположение в реальном времени</strong></li>
    </ul>

    <h2>Как анализ переписок и фото дает злоумышленнику почву для атаки:</h2>
    <p>Анализируя ваши посты, комментарии и фотографии, злоумышленник может узнать:</p>
    <ul>
        <li>Ваши увлечения и интересы</li>
        <li>Проблемы и слабости</li>
        <li>Круг общения</li>
        <li>Места, которые вы часто посещаете</li>
    </ul>

    <h2>Опасность фейковых (клонированных) аккаунтов:</h2>
    <ul>
        <li>Создаются для сбора информации о друзьях жертвы</li>
        <li>Используются для мошенничества (просьбы денег от имени "друга")</li>
        <li>Могут быть использованы для кибербуллинга</li>
    </ul>
</section>
',
        ]);

        // Вопрос 2.2.1
        $q21 = Question::create([
            'task_id' => $task2_2->id,
            'content' => 'Какой из перечисленных пунктов информации наиболее критично скрывать от общего доступа в соцсетях?',
            'type' => 'single',
            'points' => 2,
        ]);

        QuestionOption::create(['question_id' => $q21->id, 'content' => 'Любимая музыкальная группа', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q21->id, 'content' => 'Город рождения (если вы там не живете)', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q21->id, 'content' => 'Точный домашний адрес и график отпусков', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q21->id, 'content' => 'Любимый цвет', 'is_correct' => false]);

        // Вопрос 2.2.2
        $q22 = Question::create([
            'task_id' => $task2_2->id,
            'content' => 'Что нежелательно указывать в открытом доступе в социальной сети?',
            'type' => 'multiple',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q22->id, 'content' => 'Реальный город текущего проживания', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q22->id, 'content' => 'Вымышленный город в качестве родного города', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q22->id, 'content' => 'Фамилию и Имя вместе с датой рождения на одной странице', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q22->id, 'content' => 'Никнейм, не связанный с реальным именем', 'is_correct' => false]);

        // Вопрос 2.2.3
        $q23 = Question::create([
            'task_id' => $task2_2->id,
            'content' => 'Анализ переписки в открытом чате или комментариях может дать злоумышленнику в первую очередь...',
            'type' => 'single',
            'points' => 2,
        ]);

        QuestionOption::create(['question_id' => $q23->id, 'content' => 'Информацию о проблемах, интересах и контексте для дальнейшей манипуляции', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q23->id, 'content' => 'Пароли от банковских счетов', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q23->id, 'content' => 'Точный домашний адрес', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q23->id, 'content' => 'Ничего ценного', 'is_correct' => false]);

        // Вопрос 2.2.4
        $q24 = Question::create([
            'task_id' => $task2_2->id,
            'content' => 'Ситуация: Вы видите в соцсети фото друга в новой фирменной униформе на фоне здания с большой вывеской компании. Почему такая публикация может быть рискованной?',
            'type' => 'single',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q24->id, 'content' => 'Раскрывает его место работы, что можно использовать для целевого фишинга или попытки проникновения в компанию', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q24->id, 'content' => 'Это нарушает дресс-код компании', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q24->id, 'content' => 'Это просто некрасиво', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q24->id, 'content' => 'Никакого риска нет, все и так знают, где он работает', 'is_correct' => false]);

        // Вопрос 2.2.5
        $q25 = Question::create([
            'task_id' => $task2_2->id,
            'content' => 'Ситуация: Вам приходит запрос в друзья от незнакомца, у которого много общих с вами друзей и интересных постов. Принимать?',
            'type' => 'single',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q25->id, 'content' => 'Да, раз много общих друзей и интересная страница', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q25->id, 'content' => 'Нет, это может быть фейковый аккаунт (клонированный или собранный), созданный для сбора информации или мошенничества', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q25->id, 'content' => 'Да, но ограничу доступ к своим постам', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q25->id, 'content' => 'Нет, я не добавляю незнакомцев', 'is_correct' => false]);

        /*
        |--------------------------------------------------------------------------
        | ЗАДАЧА 2.3: Сложный уровень
        |--------------------------------------------------------------------------
        */
        $task2_3 = Task::create([
            'section_id' => $section2->id,
            'title' => 'Кибербуллинг и защита - Сложный уровень',
            'slug' => 'cyberbullying-protection-hard',
            'description' => 'Кибербуллинг, законодательная защита, правильные действия',
            'difficulty' => 'hard',
            'points' => 20,
            'order' => 3,
        ]);

        Theory::create([
            'task_id' => $task2_3->id,
            'content' => '
<section>
    <h1>Кибербуллинг и защита в цифровом пространстве</h1>

    <h2>Что такое кибербуллинг?</h2>
    <p><strong>Кибербуллинг</strong> — травля, агрессия, преследование и насилие в цифровом пространстве.</p>

    <h2>Последствия кибербуллинга:</h2>
    <ul>
        <li><strong>Психологические:</strong> постоянная грусть, чувство стыда, тревожность, депрессия</li>
        <li><strong>Физиологические:</strong> хроническая усталость, проблемы со сном, потеря аппетита</li>
        <li><strong>Эмоциональные:</strong> потеря интереса к прежним увлечениям, апатия</li>
        <li><strong>Социальные:</strong> изоляция, проблемы в учебе/работе</li>
    </ul>

    <h2>Законодательная защита в РФ:</h2>
    <ul>
        <li><strong>Статья 138 УК РФ</strong> — нарушение тайны переписки</li>
        <li>Статья 119 УК РФ — угроза убийством</li>
        <li>Статья 128.1 УК РФ — клевета</li>
    </ul>

    <h2>Правильные действия жертвы:</h2>
    <ol>
        <li>Собрать доказательства (скриншоты, записи)</li>
        <li>Рассказать доверенному взрослому/другу</li>
        <li>Подать жалобу администраторам платформы</li>
        <li>В серьезных случаях — обратиться в полицию</li>
    </ol>

    <h2>Риски публикации рабочих деталей на фото:</h2>
    <p>На фотографиях рабочего места могут быть видны: пароли на стикерах, конфиденциальные документы, интерфейсы внутренних систем.</p>
</section>
',
        ]);

        // Вопрос 2.3.1
        $q26 = Question::create([
            'task_id' => $task2_3->id,
            'content' => 'Кибербуллинг — это...',
            'type' => 'single',
            'points' => 2,
        ]);

        QuestionOption::create(['question_id' => $q26->id, 'content' => 'Взлом аккаунта с кражей денег', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q26->id, 'content' => 'Травля, агрессия, преследование и насилие в цифровом пространстве', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q26->id, 'content' => 'Рассылка коммерческого спама', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q26->id, 'content' => 'Легальный сбор информации для рекламы', 'is_correct' => false]);

        // Вопрос 2.3.2
        $q27 = Question::create([
            'task_id' => $task2_3->id,
            'content' => 'Какие последствия может ощутить жертва кибербуллинга?',
            'type' => 'multiple',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q27->id, 'content' => 'Психологические: постоянная грусть, чувство стыда', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q27->id, 'content' => 'Физические: повышенный аппетит', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q27->id, 'content' => 'Физиологические: хроническая усталость, проблемы со сном', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q27->id, 'content' => 'Эмоциональные: потеря интереса к прежним увлечениям', 'is_correct' => true]);

        // Вопрос 2.3.3
        $q28 = Question::create([
            'task_id' => $task2_3->id,
            'content' => 'Нарушение тайны переписки в РФ регулируется...',
            'type' => 'single',
            'points' => 2,
        ]);

        QuestionOption::create(['question_id' => $q28->id, 'content' => 'Только правилами соцсети', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q28->id, 'content' => 'Федеральным законом "О персональных данных"', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q28->id, 'content' => 'Уголовным кодексом РФ (ст. 138)', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q28->id, 'content' => 'Это не регулируется российским законодательством', 'is_correct' => false]);

        // Вопрос 2.3.4
        $q29 = Question::create([
            'task_id' => $task2_3->id,
            'content' => 'Ситуация: На человека в сети начали поступать угрозы, оскорбления, создана группа для его травли. Его первая реакция — удалить свои аккаунты и никому не говорить. Насколько это эффективная стратегия?',
            'type' => 'single',
            'points' => 4,
        ]);

        QuestionOption::create(['question_id' => $q29->id, 'content' => 'Неэффективная. Нужно собрать доказательства, рассказать доверенному взрослому/другу и подать жалобы администраторам платформ, а в серьезных случаях — в полицию', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q29->id, 'content' => 'Эффективная, если удалить всё навсегда', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q29->id, 'content' => 'Эффективная, если потом завести новые аккаунты под другим именем', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q29->id, 'content' => 'Эффективная, так как обидчики потеряют интерес', 'is_correct' => false]);

        // Вопрос 2.3.5
        $q30 = Question::create([
            'task_id' => $task2_3->id,
            'content' => 'Ситуация: Ваш знакомый разместил в блоге фото с нового рабочего места. На заднем плане (в расфокусе) виден монитор, а на нем — стикер с какими-то буквами и цифрами. Эксперт по безопасности назвал это серьезным риском. Почему?',
            'type' => 'single',
            'points' => 4,
        ]);

        QuestionOption::create(['question_id' => $q30->id, 'content' => 'На стикере может быть записан пароль, логин или другая чувствительная информация, которую можно восстановить с помощью увеличения или угадать по контексту', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q30->id, 'content' => 'Это нарушает корпоративный стиль, за что могут уволить', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q30->id, 'content' => 'Фотографировать рабочее место всегда запрещено', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q30->id, 'content' => 'Это сглаз на работу', 'is_correct' => false]);
    }

    private function runSection3(): void
    {
        /*
        |--------------------------------------------------------------------------
        | РАЗДЕЛ 3: Взлом и его последствия. Мошенничество
        |--------------------------------------------------------------------------
        */
        $section3 = Section::create([
            'title' => 'Взлом и его последствия. Мошенничество',
            'description' => 'Виды взлома, кража личности, телефонное мошенничество, утечки данных',
        ]);

        /*
        |--------------------------------------------------------------------------
        | ЗАДАЧА 3.1: Легкий уровень
        |--------------------------------------------------------------------------
        */
        $task3_1 = Task::create([
            'section_id' => $section3->id,
            'title' => 'Взлом аккаунтов - Легкий уровень',
            'slug' => 'account-hacking-easy',
            'description' => 'Базовые понятия взлома, кражи личности, простые примеры мошенничества',
            'difficulty' => 'easy',
            'points' => 10,
            'order' => 1,
        ]);

        Theory::create([
            'task_id' => $task3_1->id,
            'content' => '
<section>
    <h1>Взлом и его последствия. Мошенничество</h1>

    <h2>Что такое взлом аккаунта?</h2>
    <p>Несанкционированный доступ к учетной записи пользователя с использованием различных методов (подбор пароля, фишинг, социальная инженерия).</p>

    <h2>Что может пострадать при взломе:</h2>
    <ul>
        <li><strong>Деньги:</strong> доступ к банковским счетам, электронным кошелькам</li>
        <li><strong>Репутация:</strong> публикация компрометирующих материалов от вашего имени</li>
        <li><strong>Личная жизнь:</strong> доступ к личной переписке, фотографиям</li>
    </ul>

    <h2>Кража личности (identity theft):</h2>
    <p>Использование ваших персональных данных (имя, паспортные данные, фото) для совершения действий от вашего имени.</p>

    <h2>Простые примеры мошенничества:</h2>
    <ul>
        <li>Просьба денег от взломанного аккаунта друга</li>
        <li>Фишинг-письма с просьбой "восстановить доступ"</li>
        <li>"Вы выиграли приз" с требованием оплатить доставку</li>
    </ul>

    <h2>Примеры утечек данных:</h2>
    <ul>
        <li><strong>Спортмастер (2022):</strong> утечка имен, телефонов, email и дат рождения</li>
        <li>Яндекс.Еда (2021): утечка данных заказов</li>
    </ul>
</section>
',
        ]);

        // Вопрос 3.1.1
        $q31 = Question::create([
            'task_id' => $task3_1->id,
            'content' => 'Что может пострадать при взломе аккаунта?',
            'type' => 'single',
            'points' => 2,
        ]);

        QuestionOption::create(['question_id' => $q31->id, 'content' => 'Только деньги на привязанной карте', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q31->id, 'content' => 'Только репутация', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q31->id, 'content' => 'Только личная жизнь', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q31->id, 'content' => 'Деньги, репутация и личная жизнь', 'is_correct' => true]);

        // Вопрос 3.1.2
        $q32 = Question::create([
            'task_id' => $task3_1->id,
            'content' => 'Самым распространенным и тяжелым последствием взлома считается...',
            'type' => 'single',
            'points' => 2,
        ]);

        QuestionOption::create(['question_id' => $q32->id, 'content' => 'Потеря доступа к игре', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q32->id, 'content' => 'Кража личности (использование ваших данных от вашего имени)', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q32->id, 'content' => 'Необходимость придумать новый пароль', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q32->id, 'content' => 'Временная блокировка аккаунта', 'is_correct' => false]);

        // Вопрос 3.1.3
        $q33 = Question::create([
            'task_id' => $task3_1->id,
            'content' => 'Какие из перечисленных являются разновидностями кражи личности?',
            'type' => 'multiple',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q33->id, 'content' => 'Создание клонов (фейковых страниц знаменитостей)', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q33->id, 'content' => 'Кража данных для изменения личности (например, нелегальными мигрантами)', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q33->id, 'content' => 'Кража данных для оформления кредитов на жертву', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q33->id, 'content' => 'Кража физического кошелька из сумки', 'is_correct' => false]);

        // Вопрос 3.1.4
        $q34 = Question::create([
            'task_id' => $task3_1->id,
            'content' => 'Утечка базы данных "Спортмастера" привела к раскрытию...',
            'type' => 'single',
            'points' => 2,
        ]);

        QuestionOption::create(['question_id' => $q34->id, 'content' => 'Только паролей пользователей', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q34->id, 'content' => 'Имен, телефонов, email и дат рождения', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q34->id, 'content' => 'Данных банковских карт', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q34->id, 'content' => 'Домашних адресов и паспортных данных', 'is_correct' => false]);

        // Вопрос 3.1.5
        $q35 = Question::create([
            'task_id' => $task3_1->id,
            'content' => 'Ситуация: Вам в личные сообщения от аккаунта друга пришло: "Привет, попал в беду, срочно нужны 5000 руб. на такси, потом отдам. Карта 1234..." Ваши действия?',
            'type' => 'single',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q35->id, 'content' => 'Свяжусь с другом по другому, проверенному каналу (звонок, второй мессенджер) и переспрошу', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q35->id, 'content' => 'Переведу деньги, раз друг просит', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q35->id, 'content' => 'Проигнорирую, раз не позвонил', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q35->id, 'content' => 'Начну уточнять детали в этом же чате', 'is_correct' => false]);

        /*
        |--------------------------------------------------------------------------
        | ЗАДАЧА 3.2: Средний уровень
        |--------------------------------------------------------------------------
        */
        $task3_2 = Task::create([
            'section_id' => $section3->id,
            'title' => 'Виды мошенничества - Средний уровень',
            'slug' => 'fraud-types-medium',
            'description' => 'Виды кражи личности, телефонное мошенничество, кейсы утечек',
            'difficulty' => 'medium',
            'points' => 15,
            'order' => 2,
        ]);

        Theory::create([
            'task_id' => $task3_2->id,
            'content' => '
<section>
    <h1>Виды мошенничества и утечек данных</h1>

    <h2>Виды кражи личности:</h2>
    <ul>
        <li><strong>Создание клонов:</strong> фейковые страницы знаменитостей для сбора денег</li>
        <li><strong>Изменение личности:</strong> покупка паспортных данных для нелегального проживания</li>
        <li><strong>Финансовые махинации:</strong> оформление кредитов на чужое имя</li>
    </ul>

    <h2>Телефонное мошенничество ("банкиры"):</h2>
    <p><strong>Приемы мошенников:</strong></p>
    <ul>
        <li><strong>Срочность:</strong> "Нужно срочно совершить действия"</li>
        <li><strong>Шум на фоне:</strong> имитация call-центра</li>
        <li><strong>Поддельные должности:</strong> "сотрудник главного управления МВД", "служба безопасности банка"</li>
        <li><strong>Просьба назвать коды:</strong> CVV, коды из SMS</li>
    </ul>

    <h2>Разбор кейсов утечек:</h2>
    <ul>
        <li><strong>Яндекс.Еда:</strong> утечка данных заказов, раскрытие локаций госучреждений</li>
        <li><strong>Ким Кардашьян:</strong> взлом iCloud, обнародование личных фото → репутационный ущерб</li>
    </ul>

    <h2>Последствия для репутации:</h2>
    <p>Утечка личных данных знаменитостей часто наносит больший репутационный ущерб, чем финансовый.</p>
</section>
',
        ]);

        // Вопрос 3.2.1
        $q36 = Question::create([
            'task_id' => $task3_2->id,
            'content' => 'Примером какой кражи личности является покупка паспорта в даркнете для нелегального проживания в другой стране?',
            'type' => 'single',
            'points' => 2,
        ]);

        QuestionOption::create(['question_id' => $q36->id, 'content' => 'Создание клонов', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q36->id, 'content' => 'Кража данных с целью изменения личности', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q36->id, 'content' => 'Кража данных с целью финансовых махинаций', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q36->id, 'content' => 'Кража юридического лица', 'is_correct' => false]);

        // Вопрос 3.2.2
        $q37 = Question::create([
            'task_id' => $task3_2->id,
            'content' => 'Примером какой кражи личности является создание фейковой страницы знаменитости для сбора денег на "благотворительность"?',
            'type' => 'single',
            'points' => 2,
        ]);

        QuestionOption::create(['question_id' => $q37->id, 'content' => 'Создание клонов', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q37->id, 'content' => 'Кража данных с целью изменения личности', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q37->id, 'content' => 'Кража данных с целью финансовых махинаций', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q37->id, 'content' => 'Кража персональных данных', 'is_correct' => false]);

        // Вопрос 3.2.3
        $q38 = Question::create([
            'task_id' => $task3_2->id,
            'content' => 'Что должно насторожить при звонке от потенциального телефонного мошенника ("банкира")?',
            'type' => 'multiple',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q38->id, 'content' => 'Шум на фоне, как в большом call-центре', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q38->id, 'content' => 'Требование СРОЧНО совершить действия (перевести, назвать код, установить приложение)', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q38->id, 'content' => 'Просьба назвать номер карты, CVV-код или пароль из SMS', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q38->id, 'content' => 'Представление "сотрудником главного управления МВД" или "службы безопасности банка"', 'is_correct' => true]);

        // Вопрос 3.2.4
        $q39 = Question::create([
            'task_id' => $task3_2->id,
            'content' => 'Ситуация: После утечки базы "Яндекс.Еды" выяснилось, что несколько заказов были сделаны на адрес здания ФСБ. Какое нарушение в первую очередь было допущено сотрудниками?',
            'type' => 'single',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q39->id, 'content' => 'Нарушение репутации ФСБ', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q39->id, 'content' => 'Нарушение режима секретности/конфиденциальности места работы (раскрытие локации)', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q39->id, 'content' => 'Нарушение правил здорового питания', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q39->id, 'content' => 'Нарушения нет, они просто заказали обед', 'is_correct' => false]);

        // Вопрос 3.2.5
        $q40 = Question::create([
            'task_id' => $task3_2->id,
            'content' => 'Ситуация: Злоумышленники, взломав iCloud Ким Кардашьян, обнародовали ее личные фото. Какой основной тип ущерба был нанесен?',
            'type' => 'single',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q40->id, 'content' => 'Только финансовый (украли деньги)', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q40->id, 'content' => 'В первую очередь репутационный и ущерб личной жизни', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q40->id, 'content' => 'Только ущерб устройству (сломали телефон)', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q40->id, 'content' => 'Никакого, это был пиар', 'is_correct' => false]);

        /*
        |--------------------------------------------------------------------------
        | ЗАДАЧА 3.3: Сложный уровень
        |--------------------------------------------------------------------------
        */
        $task3_3 = Task::create([
            'section_id' => $section3->id,
            'title' => 'Сложные мошенничества - Сложный уровень',
            'slug' => 'advanced-fraud-hard',
            'description' => 'Классификация злоумышленников, сложные финансовые риски, технические методы',
            'difficulty' => 'hard',
            'points' => 20,
            'order' => 3,
        ]);

        Theory::create([
            'task_id' => $task3_3->id,
            'content' => '
<section>
    <h1>Сложные виды мошенничества и злоумышленники</h1>

    <h2>Классификация злоумышленников по целям:</h2>
    <ul>
        <li><strong>Мошенники:</strong> массовые атаки для быстрой финансовой выгоды</li>
        <li><strong>Преступные группировки:</strong> целевые атаки на компании, работа по заказу</li>
        <li><strong>Хактивисты:</strong> действия по идеологическим соображениям (политика, экология)</li>
        <li><strong>Внутренние нарушители:</strong> недовольные сотрудники</li>
    </ul>

    <h2>Сложные финансовые риски:</h2>
    <ul>
        <li><strong>Скимминг:</strong> установка устройств в банкоматы для считывания данных карт</li>
        <li><strong>Перехват SMS:</strong> вредоносное ПО для перехвата кодов двухфакторной аутентификации</li>
        <li><strong>Социальная инженерия:</strong> фишинг с имитацией госорганов (налоги, полиция)</li>
    </ul>

    <h2>Технические методы мошенничества:</h2>
    <ul>
        <li>Вредоносное ПО для перехвата 2FA (двухфакторной аутентификации)</li>
        <li>Поддельные письма от госорганов с фишинговыми ссылками</li>
        <li>Взлом аккаунтов через утечки паролей (credential stuffing)</li>
    </ul>

    <h2>Юридические сложности:</h2>
    <p>Доказать, что перевод совершил мошенник, а не вы, бывает сложно, особенно если операция подтверждена SMS-кодом.</p>
</section>
',
        ]);

        // Вопрос 3.3.1
        $q41 = Question::create([
            'task_id' => $task3_3->id,
            'content' => 'Кто из злоумышленников преследует цели заработка денег, часто работая по заказу против конкретных лиц или компаний?',
            'type' => 'single',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q41->id, 'content' => 'Мошенники (массовый сегмент)', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q41->id, 'content' => 'Проправительственные группировки', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q41->id, 'content' => 'Преступные группировки', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q41->id, 'content' => 'Хактивисты', 'is_correct' => false]);

        // Вопрос 3.3.2
        $q42 = Question::create([
            'task_id' => $task3_3->id,
            'content' => 'Кто из злоумышленников действует не ради денег, а по идеологическим соображениям (политика, экология и т.д.)?',
            'type' => 'single',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q42->id, 'content' => 'Мошенники', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q42->id, 'content' => 'Преступные группировки', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q42->id, 'content' => 'Хактивисты', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q42->id, 'content' => 'Индивидуальные исследователи', 'is_correct' => false]);

        // Вопрос 3.3.3
        $q43 = Question::create([
            'task_id' => $task3_3->id,
            'content' => 'Какие из утверждений о финансовой безопасности верны?',
            'type' => 'multiple',
            'points' => 4,
        ]);

        QuestionOption::create(['question_id' => $q43->id, 'content' => 'Фотография потерянной карты с двух сторон (с номером и CVV) позволяет украсть деньги онлайн', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q43->id, 'content' => 'Установка скиммингового устройства в банкомат — реальный способ кражи данных карты', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q43->id, 'content' => 'Сложный пароль от почты делает двухфакторную аутентификацию ненужной', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q43->id, 'content' => 'Доказать, что перевод с карты совершил мошенник, а не вы, бывает юридически сложно', 'is_correct' => true]);

        // Вопрос 3.3.4
        $q44 = Question::create([
            'task_id' => $task3_3->id,
            'content' => 'Ситуация: Вы стали жертвой мошенников, с вашей карты списали деньги через интернет-платеж. В банке говорят, что операция подтверждена одноразовым паролем из SMS, который пришел на ваш номер. Что, скорее всего, произошло?',
            'type' => 'single',
            'points' => 4,
        ]);

        QuestionOption::create(['question_id' => $q44->id, 'content' => 'Взломали сам банк', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q44->id, 'content' => 'На ваше устройство (смартфон) было установлено вредоносное ПО, перехватывающее SMS', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q44->id, 'content' => 'Вы сами забыли про этот платеж', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q44->id, 'content' => 'Банк совершил ошибку', 'is_correct' => false]);

        // Вопрос 3.3.5
        $q45 = Question::create([
            'task_id' => $task3_3->id,
            'content' => 'Ситуация: Вам на почту приходит письмо якобы от налоговой с требованием срочно предоставить документы, иначе будет штраф. В письме — ссылка на сайт, похожий на госуслуги, но с другой доменной зоной. Это пример...',
            'type' => 'single',
            'points' => 4,
        ]);

        QuestionOption::create(['question_id' => $q45->id, 'content' => 'Вирусной рассылки', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q45->id, 'content' => 'Целевого фишинга с элементами социальной инженерии (давление страхом)', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q45->id, 'content' => 'Официального запроса', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q45->id, 'content' => 'Спама', 'is_correct' => false]);
    }

    private function runSection4(): void
    {
        /*
        |--------------------------------------------------------------------------
        | РАЗДЕЛ 4: Вредоносное программное обеспечение (ВПО)
        |--------------------------------------------------------------------------
        */
        $section4 = Section::create([
            'title' => 'Вредоносное программное обеспечение (ВПО)',
            'description' => 'Виды ВПО, признаки заражения, защита от вредоносного ПО',
        ]);

        /*
        |--------------------------------------------------------------------------
        | ЗАДАЧА 4.1: Легкий уровень
        |--------------------------------------------------------------------------
        */
        $task4_1 = Task::create([
            'section_id' => $section4->id,
            'title' => 'Основы ВПО - Легкий уровень',
            'slug' => 'malware-basics-easy',
            'description' => 'Базовые виды вредоносного ПО, признаки заражения',
            'difficulty' => 'easy',
            'points' => 10,
            'order' => 1,
        ]);

        Theory::create([
            'task_id' => $task4_1->id,
            'content' => '
<section>
    <h1>Вредоносное программное обеспечение (ВПО)</h1>

    <h2>Что такое ВПО?</h2>
    <p><strong>Вредоносное программное обеспечение (ВПО)</strong> — любое программное обеспечение, предназначенное для нанесения ущерба компьютеру, серверу, компьютерной сети или пользователю.</p>

    <h2>Основные и самые известные виды ВПО:</h2>
    <ul>
        <li><strong>Вирусы:</strong> заражают другие файлы и распространяются с ними</li>
        <li><strong>Трояны:</strong> маскируются под полезные программы</li>
        <li><strong>Рекламное ПО (adware):</strong> показывает навязчивую рекламу</li>
        <li><strong>Программы-вымогатели (ransomware):</strong> блокируют доступ к данным с требованием выкупа</li>
    </ul>

    <h2>Как ВПО распространяется:</h2>
    <ul>
        <li>Через письма с вложениями</li>
        <li>Через зараженные флешки</li>
        <li>Через вредоносные сайты</li>
        <li>Вместе с пиратским ПО</li>
    </ul>

    <h2>Простые признаки заражения:</h2>
    <ul>
        <li>Компьютер стал работать медленнее</li>
        <li>Появилась навязчивая реклама</li>
        <li>Программы запускаются со сбоями</li>
        <li>Необычные сообщения об ошибках</li>
    </ul>
</section>
',
        ]);

        // Вопрос 4.1.1
        $q46 = Question::create([
            'task_id' => $task4_1->id,
            'content' => 'Как расшифровывается аббревиатура ВПО?',
            'type' => 'single',
            'points' => 2,
        ]);

        QuestionOption::create(['question_id' => $q46->id, 'content' => 'Внутренние правовые отношения', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q46->id, 'content' => 'Военный пограничный объект', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q46->id, 'content' => 'Вредоносное программное обеспечение', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q46->id, 'content' => 'Всероссийская подрядная организация', 'is_correct' => false]);

        // Вопрос 4.1.2
        $q47 = Question::create([
            'task_id' => $task4_1->id,
            'content' => 'Этот вид ВПО "заражает" другие файлы и распространяется вместе с ними (например, через флешку или вложение в письме):',
            'type' => 'single',
            'points' => 2,
        ]);

        QuestionOption::create(['question_id' => $q47->id, 'content' => 'Вирус', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q47->id, 'content' => 'Червь', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q47->id, 'content' => 'Троян', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q47->id, 'content' => 'Рекламное ПО', 'is_correct' => false]);

        // Вопрос 4.1.3
        $q48 = Question::create([
            'task_id' => $task4_1->id,
            'content' => 'Какие из перечисленных признаков могут указывать на заражение компьютера ВПО?',
            'type' => 'multiple',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q48->id, 'content' => 'Устройство стало работать значительно медленнее', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q48->id, 'content' => 'Появились всплывающие окна с рекламой в браузере и на рабочем столе', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q48->id, 'content' => 'На корпусе ноутбука появилась царапина', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q48->id, 'content' => 'Перестали запускаться некоторые программы или они работают со сбоями', 'is_correct' => true]);

        // Вопрос 4.1.4
        $q49 = Question::create([
            'task_id' => $task4_1->id,
            'content' => 'Ситуация: На экране компьютера внезапно появилось окно с требованием заплатить биткойнами в течение 24 часов, иначе все файлы будут удалены. Что это, скорее всего, за тип ВПО?',
            'type' => 'single',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q49->id, 'content' => 'Рекламное ПО', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q49->id, 'content' => 'Программа-вымогатель (Ransomware)', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q49->id, 'content' => 'Вирус', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q49->id, 'content' => 'Червь', 'is_correct' => false]);

        // Вопрос 4.1.5
        $q50 = Question::create([
            'task_id' => $task4_1->id,
            'content' => 'Ситуация: Вы скачали "бесплатную" программу для обработки фото. После установки в браузере начала появляться навязчивая реклама, а стартовая страница изменилась. Что вы, скорее всего, установили вместе с программой?',
            'type' => 'single',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q50->id, 'content' => 'Вирус', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q50->id, 'content' => 'Червь', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q50->id, 'content' => 'Рекламное ПО (Adware)', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q50->id, 'content' => 'Антивирус', 'is_correct' => false]);

        /*
        |--------------------------------------------------------------------------
        | ЗАДАЧА 4.2: Средний уровень
        |--------------------------------------------------------------------------
        */
        $task4_2 = Task::create([
            'section_id' => $section4->id,
            'title' => 'Сложные виды ВПО - Средний уровень',
            'slug' => 'advanced-malware-medium',
            'description' => 'Черви, шпионское ПО, трояны, защита смартфонов',
            'difficulty' => 'medium',
            'points' => 15,
            'order' => 2,
        ]);

        Theory::create([
            'task_id' => $task4_2->id,
            'content' => '
<section>
    <h1>Сложные виды вредоносного ПО</h1>

    <h2>Более сложные виды ВПО:</h2>
    <ul>
        <li><strong>Черви:</strong> распространяются по сети самостоятельно, без действий пользователя</li>
        <li><strong>Шпионское ПО (spyware):</strong> следит за действиями пользователя, крадет данные</li>
        <li><strong>Трояны:</strong> маскируются под полезные программы, открывают бэкдоры</li>
        <li><strong>Руткиты:</strong> скрывают свое присутствие в системе</li>
    </ul>

    <h2>Мифы о ВПО:</h2>
    <ul>
        <li><strong>Миф:</strong> Письма от знакомых всегда безопасны (их аккаунты могли быть взломаны)</li>
        <li><strong>Миф:</strong> Любое сообщение об ошибке — это вирус (могут быть обычные сбои ПО)</li>
        <li><strong>Миф:</strong> Вирусы могут физически сжечь микросхемы (крайне маловероятно)</li>
        <li><strong>Миф:</strong> Антивирус дает 100% защиту (нет, нужны и другие меры)</li>
    </ul>

    <h2>Как ВПО попадает на смартфоны:</h2>
    <ul>
        <li>Через вредоносные приложения из неофициальных магазинов</li>
        <li>Через поддельные обновления</li>
        <li>Через фишинговые ссылки в SMS и мессенджерах</li>
    </ul>

    <h2>Важность проверки разрешений приложений:</h2>
    <p>Приложение "Фонарик" не должно запрашивать доступ к контактам, SMS и звонкам. Это явный признак вредоносного ПО.</p>
</section>
',
        ]);

        // Вопрос 4.2.1
        $q51 = Question::create([
            'task_id' => $task4_2->id,
            'content' => 'Чем червь принципиально отличается от вируса?',
            'type' => 'single',
            'points' => 2,
        ]);

        QuestionOption::create(['question_id' => $q51->id, 'content' => 'Он менее опасен', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q51->id, 'content' => 'Он может распространяться по сети самостоятельно, без действий пользователя', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q51->id, 'content' => 'Он не вредит файлам', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q51->id, 'content' => 'Его нельзя удалить', 'is_correct' => false]);

        // Вопрос 4.2.2
        $q52 = Question::create([
            'task_id' => $task4_2->id,
            'content' => 'Какие из утверждений являются мифами о ВПО?',
            'type' => 'multiple',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q52->id, 'content' => 'Любое сообщение об ошибке на компьютере — это признак вируса', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q52->id, 'content' => 'Вложения в письмах от известных отправителей (друзей, коллег) всегда безопасны', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q52->id, 'content' => 'Антивирусные программы не могут дать 100% гарантии защиты', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q52->id, 'content' => 'Вирусы могут физически сжечь микросхемы в компьютере', 'is_correct' => true]);

        // Вопрос 4.2.3
        $q53 = Question::create([
            'task_id' => $task4_2->id,
            'content' => 'Ситуация: Вы устанавливаете на смартфон бесплатное приложение "Фонарик", и оно запрашивает доступ к контактам, SMS и звонкам. Что делать?',
            'type' => 'single',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q53->id, 'content' => 'Отказаться от установки, так как запрос необоснован для функционала фонарика — это подозрительно', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q53->id, 'content' => 'Разрешить, раз программа бесплатная и популярная', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q53->id, 'content' => 'Разрешить, но потом удалить приложение', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q53->id, 'content' => 'Написать разработчику с вопросом', 'is_correct' => false]);

        // Вопрос 4.2.4
        $q54 = Question::create([
            'task_id' => $task4_2->id,
            'content' => 'Вредоносный код, обнаруженный в легитимном приложении "CamScanner" из официального магазина Google Play, был...',
            'type' => 'single',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q54->id, 'content' => 'Вирусом', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q54->id, 'content' => 'Троянским загрузчиком (мог позже загрузить другой вирус)', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q54->id, 'content' => 'Рекламным модулем', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q54->id, 'content' => 'Программой-вымогателем', 'is_correct' => false]);

        // Вопрос 4.2.5
        $q55 = Question::create([
            'task_id' => $task4_2->id,
            'content' => 'Какие действия вредоносные программы могут выполнять на смартфоне?',
            'type' => 'multiple',
            'points' => 4,
        ]);

        QuestionOption::create(['question_id' => $q55->id, 'content' => 'Воровать деньги, отправляя платные SMS или оформляя подписки', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q55->id, 'content' => 'Воровать пароли из банковских приложений и данные карт', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q55->id, 'content' => 'Показывать навязчивую рекламу поверх всех окон', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q55->id, 'content' => 'Использовать мощность процессора для майнинга криптовалюты', 'is_correct' => true]);

        /*
        |--------------------------------------------------------------------------
        | ЗАДАЧА 4.3: Сложный уровень
        |--------------------------------------------------------------------------
        */
        $task4_3 = Task::create([
            'section_id' => $section4->id,
            'title' => 'Защита от ВПО - Сложный уровень',
            'slug' => 'malware-protection-hard',
            'description' => 'Современные угрозы, защитные меры, анализ инцидентов',
            'difficulty' => 'hard',
            'points' => 20,
            'order' => 3,
        ]);

        Theory::create([
            'task_id' => $task4_3->id,
            'content' => '
<section>
    <h1>Защита от современных угроз ВПО</h1>

    <h2>Современные угрозы ВПО:</h2>
    <ul>
        <li><strong>Fileless malware:</strong> вредоносный код, работающий в памяти без записи на диск</li>
        <li><strong>Целевые атаки (APT):</strong> сложные многоэтапные атаки на конкретные организации</li>
        <li><strong>Криптоджекинг:</strong> использование ресурсов устройств для майнинга криптовалют</li>
        <li><strong>Мобильные банковские трояны:</strong> специализированное ПО для кражи банковских данных</li>
    </ul>

    <h2>Защитные меры:</h2>
    <ul>
        <li><strong>Многоуровневая защита:</strong> антивирус + firewall + системы обнаружения вторжений</li>
        <li><strong>Регулярное обновление ПО:</strong> закрытие уязвимостей</li>
        <li><strong>Обучение сотрудников:</strong> распознавание фишинга и социальной инженерии</li>
        <li><strong>Резервное копирование:</strong> защита от программ-вымогателей</li>
        <li><strong>Принцип наименьших привилегий:</strong> ограничение прав пользователей</li>
    </ul>

    <h2>Анализ инцидентов:</h2>
    <p>При заражении ВПО важно:</p>
    <ol>
        <li>Изолировать зараженное устройство от сети</li>
        <li>Определить тип вредоносного ПО</li>
        <li>Найти точку входа (как произошло заражение)</li>
        <li>Очистить систему и восстановить данные из резервных копий</li>
        <li>Устранить уязвимость, через которую произошло заражение</li>
    </ol>

    <h2>Проактивная защита:</h2>
    <p>Лучшая защита — предотвращение заражения через обучение пользователей и использование надежных защитных решений.</p>
</section>
',
        ]);

        // Вопрос 4.3.1
        $q56 = Question::create([
            'task_id' => $task4_3->id,
            'content' => 'Что такое "fileless malware"?',
            'type' => 'text',
            'points' => 3,
        ]);

        QuestionTextAnswer::create(['question_id' => $q56->id, 'correct_answer' => 'вредоносный код, работающий в памяти без записи на диск']);

        // Вопрос 4.3.2
        $q57 = Question::create([
            'task_id' => $task4_3->id,
            'content' => 'Какие из перечисленных мер являются наиболее эффективными против программ-вымогателей?',
            'type' => 'multiple',
            'points' => 4,
        ]);

        QuestionOption::create(['question_id' => $q57->id, 'content' => 'Регулярное резервное копирование важных данных', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q57->id, 'content' => 'Обновление антивирусных баз каждый месяц', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q57->id, 'content' => 'Обучение пользователей не открывать подозрительные вложения', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q57->id, 'content' => 'Использование средств защиты электронной почты', 'is_correct' => true]);

        // Вопрос 4.3.3
        $q58 = Question::create([
            'task_id' => $task4_3->id,
            'content' => 'Ситуация: В компании произошло заражение программой-вымогателем. Какое действие должно быть выполнено ПЕРВЫМ?',
            'type' => 'single',
            'points' => 4,
        ]);

        QuestionOption::create(['question_id' => $q58->id, 'content' => 'Начать переговоры с хакерами о выкупе', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q58->id, 'content' => 'Изолировать зараженные устройства от сети', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q58->id, 'content' => 'Сразу восстановить данные из резервной копии', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q58->id, 'content' => 'Сообщить об инциденте в СМИ', 'is_correct' => false]);

        // Вопрос 4.3.4
        $q59 = Question::create([
            'task_id' => $task4_3->id,
            'content' => 'Что означает принцип "наименьших привилегий" в контексте защиты от ВПО?',
            'type' => 'single',
            'points' => 4,
        ]);

        QuestionOption::create(['question_id' => $q59->id, 'content' => 'Пользователи должны иметь минимально необходимые права для выполнения своих задач', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q59->id, 'content' => 'Все пользователи должны иметь административные права', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q59->id, 'content' => 'Антивирус должен иметь минимальные права', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q59->id, 'content' => 'ВПО должно иметь ограниченные права', 'is_correct' => false]);

        // Вопрос 4.3.5
        $q60 = Question::create([
            'task_id' => $task4_3->id,
            'content' => 'Ситуация: Сотрудник получил фишинговое письмо, но не открыл вложение, а сообщил в ИТ-отдел. Какой процент успеха атаки можно считать в этом случае?',
            'type' => 'single',
            'points' => 4,
        ]);

        QuestionOption::create(['question_id' => $q60->id, 'content' => '0% - атака полностью предотвращена', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q60->id, 'content' => '50% - частичный успех, так письмо все же дошло', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q60->id, 'content' => '100% - атака успешна, раз письмо дошло', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q60->id, 'content' => '25% - минимальный успех', 'is_correct' => false]);
    }

    private function runSection5(): void
    {
        /*
        |--------------------------------------------------------------------------
        | РАЗДЕЛ 5: Социальная инженерия и OSINT
        |--------------------------------------------------------------------------
        */
        $section5 = Section::create([
            'title' => 'Социальная инженерия и OSINT',
            'description' => 'Методы социальной инженерии, сбор информации из открытых источников',
        ]);

        /*
        |--------------------------------------------------------------------------
        | ЗАДАЧА 5.1: Легкий уровень
        |--------------------------------------------------------------------------
        */
        $task5_1 = Task::create([
            'section_id' => $section5->id,
            'title' => 'Основы социальной инженерии - Легкий уровень',
            'slug' => 'social-engineering-basics-easy',
            'description' => 'Базовые методы социальной инженерии, фишинг',
            'difficulty' => 'easy',
            'points' => 10,
            'order' => 1,
        ]);

        Theory::create([
            'task_id' => $task5_1->id,
            'content' => '
<section>
    <h1>Социальная инженерия и OSINT</h1>

    <h2>Что такое социальная инженерия?</h2>
    <p><strong>Социальная инженерия</strong> — метод манипуляции людьми с целью получения конфиденциальной информации или доступа к системам.</p>

    <h2>Базовые методы социальной инженерии:</h2>
    <ul>
        <li><strong>Фишинг:</strong> поддельные письма/сайты для кражи данных</li>
        <li><strong>Претекстинг:</strong> создание вымышленного сценария для получения информации</li>
        <li><strong>Кви про кво (что-то за что-то):</strong> предложение помощи в обмен на информацию</li>
        <li><strong>Троянский конь:</strong> "полезный" софт со скрытым вредоносным функционалом</li>
    </ul>

    <h2>Что такое OSINT?</h2>
    <p><strong>OSINT (Open Source INTelligence)</strong> — сбор и анализ информации из открытых источников.</p>

    <h2>Примеры источников OSINT:</h2>
    <ul>
        <li>Социальные сети</li>
        <li>Публичные базы данных</li>
        <li>Форумы и блоги</li>
        <li>Сайты компаний</li>
        <li>Публичные реестры</li>
    </ul>

    <h2>Защита от социальной инженерии:</h2>
    <ul>
        <li>Проверяйте отправителей писем и сообщений</li>
        <li>Не предоставляйте информацию по телефону незнакомцам</li>
        <li>Используйте двухфакторную аутентификацию</li>
        <li>Ограничивайте информацию о себе в соцсетях</li>
    </ul>
</section>
',
        ]);

        // Вопрос 5.1.1
        $q61 = Question::create([
            'task_id' => $task5_1->id,
            'content' => 'Что такое социальная инженерия?',
            'type' => 'single',
            'points' => 2,
        ]);

        QuestionOption::create(['question_id' => $q61->id, 'content' => 'Программирование социальных сетей', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q61->id, 'content' => 'Метод манипуляции людьми с целью получения конфиденциальной информации', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q61->id, 'content' => 'Создание социальных программ', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q61->id, 'content' => 'Изучение социальных наук', 'is_correct' => false]);

        // Вопрос 5.1.2
        $q62 = Question::create([
            'task_id' => $task5_1->id,
            'content' => 'Что такое фишинг?',
            'type' => 'single',
            'points' => 2,
        ]);

        QuestionOption::create(['question_id' => $q62->id, 'content' => 'Вид спортивной рыбалки', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q62->id, 'content' => 'Метод социальной инженерии с использованием поддельных писем/сайтов', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q62->id, 'content' => 'Тип компьютерного вируса', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q62->id, 'content' => 'Способ шифрования данных', 'is_correct' => false]);

        // Вопрос 5.1.3
        $q63 = Question::create([
            'task_id' => $task5_1->id,
            'content' => 'Какие из перечисленных являются источниками OSINT?',
            'type' => 'multiple',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q63->id, 'content' => 'Социальные сети', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q63->id, 'content' => 'Закрытые базы данных спецслужб', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q63->id, 'content' => 'Публичные реестры', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q63->id, 'content' => 'Личные переписки (при взломе)', 'is_correct' => false]);

        // Вопрос 5.1.4
        $q64 = Question::create([
            'task_id' => $task5_1->id,
            'content' => 'Ситуация: Вам звонит "сотрудник банка" и просит назвать код из SMS для "подтверждения личности". Это пример...',
            'type' => 'single',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q64->id, 'content' => 'Законной процедуры банка', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q64->id, 'content' => 'Социальной инженерии', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q64->id, 'content' => 'Технической поддержки', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q64->id, 'content' => 'Маркетингового опроса', 'is_correct' => false]);

        // Вопрос 5.1.5
        $q65 = Question::create([
            'task_id' => $task5_1->id,
            'content' => 'Что означает аббревиатура OSINT?',
            'type' => 'text',
            'points' => 2,
        ]);

        QuestionTextAnswer::create(['question_id' => $q65->id, 'correct_answer' => 'Open Source Intelligence']);

        /*
        |--------------------------------------------------------------------------
        | ЗАДАЧА 5.2: Средний уровень
        |--------------------------------------------------------------------------
        */
        $task5_2 = Task::create([
            'section_id' => $section5->id,
            'title' => 'Методы OSINT - Средний уровень',
            'slug' => 'osint-methods-medium',
            'description' => 'Методы сбора информации из открытых источников',
            'difficulty' => 'medium',
            'points' => 15,
            'order' => 2,
        ]);

        Theory::create([
            'task_id' => $task5_2->id,
            'content' => '
<section>
    <h1>Методы OSINT (Open Source Intelligence)</h1>

    <h2>Основные методы сбора информации:</h2>
    <ul>
        <li><strong>Поиск в социальных сетях:</strong> анализ профилей, друзей, постов, геотегов</li>
        <li><strong>Поиск по изображениям:</strong> Google Images, TinEye для поиска оригинала фото</li>
        <li><strong>Анализ метаданных:</strong> EXIF данные фотографий (координаты, дата, модель устройства)</li>
        <li><strong>Поиск в публичных реестрах:</strong> ЕГРЮЛ, реестры недвижимости, судебные решения</li>
        <li><strong>Мониторинг форумов и блогов:</strong> специализированные ресурсы по тематикам</li>
    </ul>

    <h2>Инструменты OSINT:</h2>
    <ul>
        <li><strong>Поисковые системы:</strong> Google dorks (специальные операторы поиска)</li>
        <li><strong>Социальные сети:</strong> Facebook Graph Search, LinkedIn поиск</li>
        <li><strong>Специализированные инструменты:</strong> Maltego, SpiderFoot, Shodan</li>
        <li><strong>Анализ WHOIS:</strong> информация о доменах и их владельцах</li>
    </ul>

    <h2>Этичные аспекты OSINT:</h2>
    <ul>
        <li>Использование только открытых источников</li>
        <li>Соблюдение законов о защите персональных данных</li>
        <li>Неиспользование информации для противоправных действий</li>
        <li>Уважение приватности людей</li>
    </ul>

    <h2>Защита от OSINT:</h2>
    <ul>
        <li>Ограничение информации в социальных сетях</li>
        <li>Удаление метаданных с фотографий перед публикацией</li>
        <li>Использование псевдонимов в публичных обсуждениях</li>
        <li>Регулярная проверка "цифрового следа"</li>
    </ul>
</section>
',
        ]);

        // Вопрос 5.2.1
        $q66 = Question::create([
            'task_id' => $task5_2->id,
            'content' => 'Что такое Google dorks?',
            'type' => 'single',
            'points' => 2,
        ]);

        QuestionOption::create(['question_id' => $q66->id, 'content' => 'Специальные операторы поиска Google для точного поиска информации', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q66->id, 'content' => 'Глупые вопросы в Google', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q66->id, 'content' => 'Новый вид поискового алгоритма', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q66->id, 'content' => 'Приложение для Android', 'is_correct' => false]);

        // Вопрос 5.2.2
        $q67 = Question::create([
            'task_id' => $task5_2->id,
            'content' => 'Какая информация может содержаться в EXIF данных фотографии?',
            'type' => 'multiple',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q67->id, 'content' => 'Географические координаты места съемки', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q67->id, 'content' => 'Дата и время съемки', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q67->id, 'content' => 'Модель камеры/телефона', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q67->id, 'content' => 'Имена людей на фото', 'is_correct' => false]);

        // Вопрос 5.2.3
        $q68 = Question::create([
            'task_id' => $task5_2->id,
            'content' => 'Что такое Shodan?',
            'type' => 'single',
            'points' => 2,
        ]);

        QuestionOption::create(['question_id' => $q68->id, 'content' => 'Поисковая система для интернета вещей (IoT устройств)', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q68->id, 'content' => 'Социальная сеть', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q68->id, 'content' => 'Антивирусная программа', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q68->id, 'content' => 'Язык программирования', 'is_correct' => false]);

        // Вопрос 5.2.4
        $q69 = Question::create([
            'task_id' => $task5_2->id,
            'content' => 'Ситуация: Вы хотите узнать больше о новом деловом партнере. Какой из этих методов будет этичным OSINT?',
            'type' => 'single',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q69->id, 'content' => 'Взлом его электронной почты', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q69->id, 'content' => 'Анализ его публичных профилей в LinkedIn и Facebook', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q69->id, 'content' => 'Установка шпионского ПО на его телефон', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q69->id, 'content' => 'Подкуп его сотрудника', 'is_correct' => false]);

        // Вопрос 5.2.5
        $q70 = Question::create([
            'task_id' => $task5_2->id,
            'content' => 'Как защититься от сбора информации через OSINT?',
            'type' => 'multiple',
            'points' => 4,
        ]);

        QuestionOption::create(['question_id' => $q70->id, 'content' => 'Ограничить информацию в социальных сетях', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q70->id, 'content' => 'Удалять метаданные с фотографий перед публикацией', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q70->id, 'content' => 'Использовать разные псевдонимы на разных платформах', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q70->id, 'content' => 'Вообще не пользоваться интернетом', 'is_correct' => false]);

        /*
        |--------------------------------------------------------------------------
        | ЗАДАЧА 5.3: Сложный уровень
        |--------------------------------------------------------------------------
        */
        $task5_3 = Task::create([
            'section_id' => $section5->id,
            'title' => 'Продвинутая социальная инженерия - Сложный уровень',
            'slug' => 'advanced-social-engineering-hard',
            'description' => 'Целевые атаки, водные атаки, защита компаний',
            'difficulty' => 'hard',
            'points' => 20,
            'order' => 3,
        ]);

        Theory::create([
            'task_id' => $task5_3->id,
            'content' => '
<section>
    <h1>Продвинутые методы социальной инженерии</h1>

    <h2>Целевые атаки (Spear phishing):</h2>
    <ul>
        <li><strong>Отличие от массового фишинга:</strong> персональный подход, изучение жертвы</li>
        <li><strong>Методы:</strong> использование реальных имен, должностей, тем, актуальных для жертвы</li>
        <li><strong>Цели:</strong> доступ к корпоративным сетям, промышленный шпионаж</li>
    </ul>

    <h2>Водные атаки (Watering hole):</h2>
    <ul>
        <li>Взлом сайтов, которые часто посещает целевая группа</li>
        <li>Заражение сайтов эксплойтами</li>
        <li>Атака на посетителей через уязвимости в браузерах</li>
    </ul>

    <h2>Физическая социальная инженерия:</h2>
    <ul>
        <li><strong>Тайлгейтинг:</strong> проход за сотрудником через защищенную дверь</li>
        <li><strong>Дампинг:</strong> поиск информации в мусоре (документы, жесткие диски)</li>
        <li><strong>Шпионаж:</strong> подслушивание разговоров в общественных местах</li>
    </ul>

    <h2>Защита компаний от социальной инженерии:</h2>
    <ul>
        <li><strong>Регулярное обучение сотрудников:</strong> симуляции фишинговых атак</li>
        <li><strong>Политика очистки рабочего стола:</strong> уборка документов перед уходом</li>
        <li><strong>Проверка посетителей:</strong> система пропусков, сопровождение гостей</li>
        <li><strong>Уничтожение документов:</strong> шредеры для конфиденциальных бумаг</li>
        <li><strong>Многофакторная аутентификация:</strong> даже при утечке паролей</li>
    </ul>

    <h2>Психологические основы социальной инженерии:</h2>
    <ul>
        <li><strong>Авторитет:</strong> имитация начальства или официальных лиц</li>
        <li><strong>Взаимность:</strong> "я вам помог, теперь вы мне"</li>
        <li><strong>Дефицит:</strong> "ограниченное предложение, нужно срочно"</li>
        <li><strong>Социальное доказательство:</strong> "все так делают"</li>
    </ul>
</section>
',
        ]);

        // Вопрос 5.3.1
        $q71 = Question::create([
            'task_id' => $task5_3->id,
            'content' => 'Чем spear phishing отличается от обычного фишинга?',
            'type' => 'single',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q71->id, 'content' => 'Использует копья вместо сетей', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q71->id, 'content' => 'Это массовая рассылка без персонализации', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q71->id, 'content' => 'Целевая атака с персональным подходом и изучением жертвы', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q71->id, 'content' => 'Использует только телефонные звонки', 'is_correct' => false]);

        // Вопрос 5.3.2
        $q72 = Question::create([
            'task_id' => $task5_3->id,
            'content' => 'Что такое "watering hole" атака?',
            'type' => 'single',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q72->id, 'content' => 'Атака через заражение воды в кулере', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q72->id, 'content' => 'Взлом сайтов, часто посещаемых целевой группой', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q72->id, 'content' => 'Фишинг через сообщения о выигрыше в лотерею', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q72->id, 'content' => 'Кража данных через публичные Wi-Fi сети', 'is_correct' => false]);

        // Вопрос 5.3.3
        $q73 = Question::create([
            'task_id' => $task5_3->id,
            'content' => 'Что такое "тайлгейтинг" в контексте физической социальной инженерии?',
            'type' => 'single',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q73->id, 'content' => 'Проход за сотрудником через защищенную дверь', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q73->id, 'content' => 'Кража пропусков', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q73->id, 'content' => 'Подделка документов', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q73->id, 'content' => 'Взлом турникетов', 'is_correct' => false]);

        // Вопрос 5.3.4
        $q74 = Question::create([
            'task_id' => $task5_3->id,
            'content' => 'Какие из перечисленных мер эффективны для защиты компании от социальной инженерии?',
            'type' => 'multiple',
            'points' => 5,
        ]);

        QuestionOption::create(['question_id' => $q74->id, 'content' => 'Регулярное обучение сотрудников с симуляциями фишинговых атак', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q74->id, 'content' => 'Политика очистки рабочего стола', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q74->id, 'content' => 'Установка камер в туалетах', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q74->id, 'content' => 'Использование шредеров для уничтожения конфиденциальных документов', 'is_correct' => true]);

        // Вопрос 5.3.5
        $q75 = Question::create([
            'task_id' => $task5_3->id,
            'content' => 'Ситуация: Сотрудник получает письмо от "директора" с просьбой срочно перевести деньги на указанный счет. Письмо содержит реальное имя директора и ссылается на реальный проект. Какой это тип атаки и что делать?',
            'type' => 'single',
            'points' => 5,
        ]);

        QuestionOption::create(['question_id' => $q75->id, 'content' => 'Spear phishing, нужно перезвонить директору для подтверждения', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q75->id, 'content' => 'Обычный спам, можно игнорировать', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q75->id, 'content' => 'Техническая ошибка, нужно сообщить в ИТ-отдел', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q75->id, 'content' => 'Легитимный запрос, нужно выполнить', 'is_correct' => false]);
    }

    private function runSection6(): void
    {
        /*
        |--------------------------------------------------------------------------
        | РАЗДЕЛ 6: Правовые основы и цифровая гигиена
        |--------------------------------------------------------------------------
        */
        $section6 = Section::create([
            'title' => 'Правовые основы и цифровая гигиена',
            'description' => 'Правовые аспекты кибербезопасности, пароли, VPN, резервные копии',
        ]);

        /*
        |--------------------------------------------------------------------------
        | ЗАДАЧА 6.1: Легкий уровень
        |--------------------------------------------------------------------------
        */
        $task6_1 = Task::create([
            'section_id' => $section6->id,
            'title' => 'Цифровая гигиена - Легкий уровень',
            'slug' => 'digital-hygiene-easy',
            'description' => 'Базовые правила цифровой гигиены, создание паролей',
            'difficulty' => 'easy',
            'points' => 10,
            'order' => 1,
        ]);

        Theory::create([
            'task_id' => $task6_1->id,
            'content' => '
<section>
    <h1>Правовые основы и цифровая гигиена</h1>

    <h2>Что такое цифровая гигиена?</h2>
    <p><strong>Цифровая гигиена</strong> — набор правил и практик для безопасного использования цифровых устройств и интернета.</p>

    <h2>Базовые правила цифровой гигиены:</h2>
    <ul>
        <li><strong>Надежные пароли:</strong> длинные, сложные, уникальные для каждого сервиса</li>
        <li><strong>Регулярное обновление ПО:</strong> ОС, браузеров, приложений</li>
        <li><strong>Осторожность с почтой:</strong> не открывать подозрительные вложения, не переходить по странным ссылкам</li>
        <li><strong>Резервное копирование:</strong> регулярное сохранение важных данных</li>
        <li><strong>Использование VPN:</strong> особенно в публичных Wi-Fi сетях</li>
    </ul>

    <h2>Создание надежных паролей:</h2>
    <ul>
        <li>Длина не менее 12 символов</li>
        <li>Комбинация букв (заглавных и строчных), цифр, специальных символов</li>
        <li>Не использовать личную информацию (имена, даты рождения)</li>
        <li>Не использовать один пароль для разных сервисов</li>
        <li>Использовать менеджеры паролей</li>
    </ul>

    <h2>Что такое VPN и зачем он нужен?</h2>
    <p><strong>VPN (Virtual Private Network)</strong> — технология, создающая зашифрованное соединение между устройством и сетью.</p>
    <p><strong>Зачем нужен VPN:</strong></p>
    <ul>
        <li>Защита данных в публичных Wi-Fi сетях</li>
        <li>Сокрытие реального IP-адреса</li>
        <li>Доступ к заблокированным ресурсам</li>
        <li>Защита от отслеживания провайдером</li>
    </ul>

    <h2>Резервное копирование (бэкапы):</h2>
    <ul>
        <li><strong>Правило 3-2-1:</strong> 3 копии, 2 разных носителя, 1 копия в другом месте</li>
        <li>Регулярность: ежедневно/еженедельно в зависимости от важности данных</li>
        <li>Проверка восстановления: периодически проверять, что бэкапы работают</li>
    </ul>
</section>
',
        ]);

        // Вопрос 6.1.1
        $q76 = Question::create([
            'task_id' => $task6_1->id,
            'content' => 'Что такое цифровая гигиена?',
            'type' => 'single',
            'points' => 2,
        ]);

        QuestionOption::create(['question_id' => $q76->id, 'content' => 'Мытье цифровых устройств', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q76->id, 'content' => 'Набор правил для безопасного использования цифровых устройств и интернета', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q76->id, 'content' => 'Программа для очистки компьютера', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q76->id, 'content' => 'Специальная диета для программистов', 'is_correct' => false]);

        // Вопрос 6.1.2
        $q77 = Question::create([
            'task_id' => $task6_1->id,
            'content' => 'Какая минимальная длина рекомендуется для надежного пароля?',
            'type' => 'single',
            'points' => 2,
        ]);

        QuestionOption::create(['question_id' => $q77->id, 'content' => '6 символов', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q77->id, 'content' => '8 символов', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q77->id, 'content' => '12 символов', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q77->id, 'content' => '4 символа', 'is_correct' => false]);

        // Вопрос 6.1.3
        $q78 = Question::create([
            'task_id' => $task6_1->id,
            'content' => 'Какие из перечисленных правил относятся к цифровой гигиене?',
            'type' => 'multiple',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q78->id, 'content' => 'Использование надежных паролей', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q78->id, 'content' => 'Регулярное обновление программного обеспечения', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q78->id, 'content' => 'Хранение всех паролей в текстовом файле на рабочем столе', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q78->id, 'content' => 'Регулярное резервное копирование важных данных', 'is_correct' => true]);

        // Вопрос 6.1.4
        $q79 = Question::create([
            'task_id' => $task6_1->id,
            'content' => 'Что означает правило бэкапов 3-2-1?',
            'type' => 'single',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q79->id, 'content' => '3 копии, 2 разных носителя, 1 копия в другом месте', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q79->id, 'content' => '3 раза в день, 2 раза в неделю, 1 раз в месяц', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q79->id, 'content' => '3 устройства, 2 пароля, 1 пользователь', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q79->id, 'content' => '3 уровня шифрования, 2 фактора аутентификации, 1 резервная копия', 'is_correct' => false]);

        // Вопрос 6.1.5
        $q80 = Question::create([
            'task_id' => $task6_1->id,
            'content' => 'Что такое VPN и для чего он используется?',
            'type' => 'single',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q80->id, 'content' => 'Виртуальная частная сеть для создания зашифрованного соединения', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q80->id, 'content' => 'Программа для увеличения скорости интернета', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q80->id, 'content' => 'Антивирусная программа', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q80->id, 'content' => 'Система видеонаблюдения', 'is_correct' => false]);

        /*
        |--------------------------------------------------------------------------
        | ЗАДАЧА 6.2: Средний уровень
        |--------------------------------------------------------------------------
        */
        $task6_2 = Task::create([
            'section_id' => $section6->id,
            'title' => 'Правовые основы - Средний уровень',
            'slug' => 'legal-basics-medium',
            'description' => 'Правовые аспекты кибербезопасности, законы РФ',
            'difficulty' => 'medium',
            'points' => 15,
            'order' => 2,
        ]);

        Theory::create([
            'task_id' => $task6_2->id,
            'content' => '
<section>
    <h1>Правовые основы кибербезопасности в РФ</h1>

    <h2>Основные законы РФ в области кибербезопасности:</h2>
    <ul>
        <li><strong>Федеральный закон № 152-ФЗ "О персональных данных":</strong> регулирование обработки персональных данных</li>
        <li><strong>Федеральный закон № 187-ФЗ "О безопасности критической информационной инфраструктуры":</strong> защита важных объектов</li>
        <li><strong>Федеральный закон № 149-ФЗ "Об информации, информационных технологиях и о защите информации":</strong> основы информационной безопасности</li>
        <li><strong>Уголовный кодекс РФ:</strong> статьи о компьютерных преступлениях</li>
    </ul>

    <h2>Статьи Уголовного кодекса РФ:</h2>
    <ul>
        <li><strong>Статья 138:</strong> нарушение тайны переписки</li>
        <li><strong>Статья 159 (мошенничество):</strong> в том числе компьютерное</li>
        <li><strong>Статья 272:</strong> неправомерный доступ к компьютерной информации</li>
        <li><strong>Статья 273:</strong> создание, использование и распространение вредоносных программ</li>
        <li><strong>Статья 274:</strong> нарушение правил эксплуатации ЭВМ</li>
    </ul>

    <h2>Ответственность за нарушения:</h2>
    <ul>
        <li><strong>Административная:</strong> штрафы для юридических и должностных лиц</li>
        <li><strong>Уголовная:</strong> штрафы, исправительные работы, лишение свободы</li>
        <li><strong>Гражданско-правовая:</strong> возмещение ущерба</li>
        <li><strong>Дисциплинарная:</strong> выговор, увольнение</li>
    </ul>

    <h2>Права пользователей (согласно 152-ФЗ):</h2>
    <ul>
        <li>Право на доступ к своим персональным данным</li>
        <li>Право на уточнение, блокирование, уничтожение данных</li>
        <li>Право на отзыв согласия на обработку данных</li>
        <li>Право на обжалование действий оператора</li>
    </ul>

    <h2>Обязанности операторов персональных данных:</h2>
    <ul>
        <li>Защита данных от неправомерного доступа</li>
        <li>Уведомление Роскомнадзора об обработке данных</li>
        <li>Получение согласия субъекта на обработку данных</li>
        <li>Обеспечение конфиденциальности данных</li>
    </ul>
</section>
',
        ]);

        // Вопрос 6.2.1
        $q81 = Question::create([
            'task_id' => $task6_2->id,
            'content' => 'Какой федеральный закон регулирует обработку персональных данных в РФ?',
            'type' => 'single',
            'points' => 2,
        ]);

        QuestionOption::create(['question_id' => $q81->id, 'content' => 'Федеральный закон № 152-ФЗ "О персональных данных"', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q81->id, 'content' => 'Федеральный закон № 149-ФЗ "Об информации"', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q81->id, 'content' => 'Уголовный кодекс РФ', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q81->id, 'content' => 'Гражданский кодекс РФ', 'is_correct' => false]);

        // Вопрос 6.2.2
        $q82 = Question::create([
            'task_id' => $task6_2->id,
            'content' => 'Какая статья Уголовного кодекса РФ предусматривает ответственность за создание и распространение вредоносных программ?',
            'type' => 'single',
            'points' => 2,
        ]);

        QuestionOption::create(['question_id' => $q82->id, 'content' => 'Статья 138 (нарушение тайны переписки)', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q82->id, 'content' => 'Статья 159 (мошенничество)', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q82->id, 'content' => 'Статья 273 (создание и распространение вредоносных программ)', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q82->id, 'content' => 'Статья 105 (убийство)', 'is_correct' => false]);

        // Вопрос 6.2.3
        $q83 = Question::create([
            'task_id' => $task6_2->id,
            'content' => 'Какие из перечисленных являются правами субъекта персональных данных согласно 152-ФЗ?',
            'type' => 'multiple',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q83->id, 'content' => 'Право на доступ к своим персональным данным', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q83->id, 'content' => 'Право на уточнение и уничтожение данных', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q83->id, 'content' => 'Право на продажу своих данных', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q83->id, 'content' => 'Право на отзыв согласия на обработку данных', 'is_correct' => true]);

        // Вопрос 6.2.4
        $q84 = Question::create([
            'task_id' => $task6_2->id,
            'content' => 'Ситуация: Компания собирает данные клиентов без их согласия и не уведомляет Роскомнадзор. Какие законы нарушает компания?',
            'type' => 'single',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q84->id, 'content' => 'Только Уголовный кодекс', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q84->id, 'content' => 'Федеральный закон № 152-ФЗ "О персональных данных"', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q84->id, 'content' => 'Трудовой кодекс', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q84->id, 'content' => 'Налоговый кодекс', 'is_correct' => false]);

        // Вопрос 6.2.5
        $q85 = Question::create([
            'task_id' => $task6_2->id,
            'content' => 'Какие виды ответственности могут наступить за нарушения в области защиты персональных данных?',
            'type' => 'multiple',
            'points' => 4,
        ]);

        QuestionOption::create(['question_id' => $q85->id, 'content' => 'Административная (штрафы)', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q85->id, 'content' => 'Уголовная (лишение свободы)', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q85->id, 'content' => 'Гражданско-правовая (возмещение ущерба)', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q85->id, 'content' => 'Дисциплинарная (выговор, увольнение)', 'is_correct' => true]);

        /*
        |--------------------------------------------------------------------------
        | ЗАДАЧА 6.3: Сложный уровень
        |--------------------------------------------------------------------------
        */
        $task6_3 = Task::create([
            'section_id' => $section6->id,
            'title' => 'Продвинутая защита - Сложный уровень',
            'slug' => 'advanced-protection-hard',
            'description' => 'Многофакторная аутентификация, криптография, инцидент-менеджмент',
            'difficulty' => 'hard',
            'points' => 20,
            'order' => 3,
        ]);

        Theory::create([
            'task_id' => $task6_3->id,
            'content' => '
<section>
    <h1>Продвинутые методы защиты и инцидент-менеджмент</h1>

    <h2>Многофакторная аутентификация (MFA/2FA):</h2>
    <ul>
        <li><strong>Факторы аутентификации:</strong>
            <ul>
                <li>Что-то, что вы знаете (пароль, PIN)</li>
                <li>Что-то, что у вас есть (токен, телефон, ключ)</li>
                <li>Что-то, что вы есть (отпечаток, лицо, голос)</li>
            </ul>
        </li>
        <li><strong>Типы MFA:</strong>
            <ul>
                <li>SMS/звонок с кодом</li>
                <li>Приложения-аутентификаторы (Google Authenticator, Microsoft Authenticator)</li>
                <li>Аппаратные токены (YubiKey)</li>
                <li>Биометрическая аутентификация</li>
            </ul>
        </li>
    </ul>

    <h2>Основы криптографии для пользователей:</h2>
    <ul>
        <li><strong>Шифрование:</strong> преобразование данных в нечитаемый вид</li>
        <li><strong>Ключи:</strong> симметричные (один ключ) и асимметричные (публичный/приватный)</li>
        <li><strong>Цифровые подписи:</strong> подтверждение авторства и целостности</li>
        <li><strong>SSL/TLS:</strong> защита соединений в интернете (HTTPS)</li>
    </ul>

    <h2>Инцидент-менеджмент в кибербезопасности:</h2>
    <ul>
        <li><strong>Обнаружение:</strong> выявление инцидента безопасности</li>
        <li><strong>Анализ:</strong> определение масштаба и типа инцидента</li>
        <li><strong>Сдерживание:</strong> ограничение распространения</li>
        <li><strong>Устранение:</strong> удаление угрозы из системы</li>
        <li><strong>Восстановление:</strong> возврат к нормальной работе</li>
        <li><strong>Извлечение уроков:</strong> анализ и предотвращение повторения</li>
    </ul>

    <h2>Политики безопасности организации:</h2>
    <ul>
        <li><strong>Политика использования:</strong> что можно и нельзя делать с корпоративными ресурсами</li>
        <li><strong>Политика паролей:</strong> требования к созданию и хранению паролей</li>
        <li><strong>Политика резервного копирования:</strong> что, когда и как备份</li>
        <li><strong>Политика удаленной работы:</strong> требования к безопасности при работе вне офиса</li>
        <li><strong>План реагирования на инциденты:</strong> пошаговый алгоритм действий</li>
    </ul>

    <h2>Соответствие стандартам и регуляторным требованиям:</h2>
    <ul>
        <li><strong>GDPR (ЕС):</strong> защита персональных данных граждан ЕС</li>
        <li><strong>PCI DSS:</strong> стандарт безопасности для платежных карт</li>
        <li><strong>ISO 27001:</strong> международный стандарт управления информационной безопасностью</li>
        <li><strong>СОПБ (РФ):</strong> требования ФСТЭК России</li>
    </ul>
</section>
',
        ]);

        // Вопрос 6.3.1
        $q86 = Question::create([
            'task_id' => $task6_3->id,
            'content' => 'Какие из перечисленного относятся к факторам аутентификации?',
            'type' => 'multiple',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q86->id, 'content' => 'Что-то, что вы знаете (пароль)', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q86->id, 'content' => 'Что-то, что у вас есть (токен)', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q86->id, 'content' => 'Что-то, что вы есть (отпечаток пальца)', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q86->id, 'content' => 'Что-то, что вы хотите (желание)', 'is_correct' => false]);

        // Вопрос 6.3.2
        $q87 = Question::create([
            'task_id' => $task6_3->id,
            'content' => 'Что такое асимметричное шифрование?',
            'type' => 'single',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q87->id, 'content' => 'Шифрование с использованием одного ключа', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q87->id, 'content' => 'Шифрование с использованием пары ключей (публичный и приватный)', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q87->id, 'content' => 'Шифрование без использования ключей', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q87->id, 'content' => 'Простое перекодирование данных', 'is_correct' => false]);

        // Вопрос 6.3.3
        $q88 = Question::create([
            'task_id' => $task6_3->id,
            'content' => 'Каков правильный порядок этапов инцидент-менеджмента?',
            'type' => 'single',
            'points' => 4,
        ]);

        QuestionOption::create(['question_id' => $q88->id, 'content' => 'Обнаружение → Анализ → Сдерживание → Устранение → Восстановление → Извлечение уроков', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q88->id, 'content' => 'Устранение → Обнаружение → Восстановление → Анализ → Сдерживание', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q88->id, 'content' => 'Анализ → Обнаружение → Восстановление → Сдерживание → Устранение', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q88->id, 'content' => 'Сдерживание → Устранение → Обнаружение → Восстановление', 'is_correct' => false]);

        // Вопрос 6.3.4
        $q89 = Question::create([
            'task_id' => $task6_3->id,
            'content' => 'Что из перечисленного является международным стандартом управления информационной безопасностью?',
            'type' => 'single',
            'points' => 3,
        ]);

        QuestionOption::create(['question_id' => $q89->id, 'content' => 'ISO 9001 (качество)', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q89->id, 'content' => 'ISO 27001 (информационная безопасность)', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q89->id, 'content' => 'PCI DSS (платежные карты)', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q89->id, 'content' => 'GDPR (защита данных в ЕС)', 'is_correct' => false]);

        // Вопрос 6.3.5
        $q90 = Question::create([
            'task_id' => $task6_3->id,
            'content' => 'Ситуация: В компании произошла утечка данных. Какие документы должны быть в первую очередь использованы для реагирования?',
            'type' => 'multiple',
            'points' => 5,
        ]);

        QuestionOption::create(['question_id' => $q90->id, 'content' => 'План реагирования на инциденты', 'is_correct' => true]);
        QuestionOption::create(['question_id' => $q90->id, 'content' => 'Политика использования информационных ресурсов', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q90->id, 'content' => 'Договор с интернет-провайдером', 'is_correct' => false]);
        QuestionOption::create(['question_id' => $q90->id, 'content' => 'Контакты регуляторов и правоохранительных органов', 'is_correct' => true]);
    }
}
