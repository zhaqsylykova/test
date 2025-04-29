<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>StoryForge — Документация</title>
    <style>
        body { font-family: Arial, sans-serif; padding: 30px; line-height: 1.6; color: #333; }
        h1, h2, h3 { color: #444; }
        code, pre { background: #f5f5f5; padding: 2px 5px; border-radius: 5px; }
        .section { margin-bottom: 40px; }
    </style>
</head>
<body>

    <h1>📖 StoryForge — генератор интерактивных историй с AI ✨</h1>

    <div class="section">
        <p><strong>StoryForge</strong> — это web-приложение на <strong>Laravel + JavaScript</strong>, в котором пользователи могут создавать свои истории, добавлять главы, а также использовать AI-помощника для генерации продолжения истории с помощью модели Hugging Face (<em>Mixtral-8x7B-Instruct</em>).</p>
    </div>

    <div class="section">
        <h2>📌 Функции</h2>
        <ul>
            <li>📚 Создание новых историй</li>
            <li>✍️ Добавление глав к историям</li>
            <li>🤖 AI-генерация текста следующей главы на основе промпта</li>
            <li>📷 Возможность сохранить историю в виде изображения (не получилось до конца)</li>
            <li>🎨 Современный, адаптивный интерфейс</li>
        </ul>
    </div>

    <div class="section">
        <h2>🛠️ Технологии</h2>
        <ul>
            <li>PHP (Laravel 11)</li>
            <li>JavaScript (vanilla)</li>
            <li>Hugging Face API (Mixtral-8x7B-Instruct)</li>
            <li>cURL для запросов к API</li>
            <li>HTML5 / CSS3</li>
            <li>html-to-image — сохранение в PNG</li>
        </ul>
    </div>

    <div class="section">
        <h2>⚙️ Установка и запуск</h2>
        <ol>
            <li>Клонировать проект:<br><code>git clone https://github.com/yourusername/storyforge.git</code></li>
            <li>Установить зависимости:<br>
                <code>composer install</code><br>
                <code>npm install &amp;&amp; npm run dev</code>
            </li>
            <li>Добавить в <code>.env</code> свой API-ключ Hugging Face:<br>
                <code>HUGGINGFACE_API_KEY=your_token_here</code>
            </li>
            <li>Выполнить миграции:<br>
                <code>php artisan migrate</code>
            </li>
            <li>Запустить сервер:<br>
                <code>php artisan serve</code>
            </li>
        </ol>
    </div>

    <div class="section">
        <h2>📡 API</h2>
        <h3>POST <code>/api/ai/generate-chapter</code></h3>
        <p><strong>Параметры:</strong></p>
        <ul>
            <li><code>prompt</code> — текст, на который AI должен ответить</li>
        </ul>
        <p><strong>Пример ответа:</strong></p>
        <pre>
[
  { "generated_text": "Текст новой главы..." }
]
        </pre>
    </div>

    <div class="section">
        <h2>📑 Как это работает</h2>
        <ol>
            <li>Пользователь пишет промпт</li>
            <li>Отправляется запрос на сервер</li>
            <li>Laravel-контроллер <code>AiController</code> делает POST-запрос к Hugging Face API</li>
            <li>Полученный текст возвращается пользователю и добавляется в историю</li>
        </ol>
    </div>

    <div class="section">
        <h2>📸 Скриншоты</h2>
        <p>(сюда можно добавить изображения интерфейса)</p>
    </div>

    <div class="section">
        <h2>📑 Лицензия</h2>
        <p>MIT</p>
    </div>

</body>
</html>


In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
