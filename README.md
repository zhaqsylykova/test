

<h1 align="center">📖 StoryForge</h1>
<p align="center"><em>Генератор интерактивных историй с AI ✨</em></p>

<hr>

<p><strong>StoryForge</strong> — это web-приложение на <strong>Laravel + JavaScript</strong>, в котором пользователи могут создавать свои истории, добавлять главы, а также использовать AI-помощника для генерации продолжения истории с помощью модели Hugging Face (<code>Mixtral-8x7B-Instruct</code>).</p>

<hr>

<h2>📌 Функции</h2>
<ul>
  <li>📚 Создание новых историй</li>
  <li>✍️ Добавление глав к историям</li>
  <li>🤖 AI-генерация текста следующей главы на основе промпта</li>
  <li>📷 Сохранение истории в виде изображения(не удалось закончить)</li>
  <li>🎨 Современный, адаптивный интерфейс</li>
</ul>

<hr>

<h2>🛠️ Технологии</h2>
<ul>
  <li>PHP (Laravel 11)</li>
  <li>JavaScript (vanilla)</li>
  <li>Hugging Face API (Mixtral-8x7B-Instruct)</li>
  <li>cURL для API-запросов</li>
  <li>HTML5 / CSS3</li>
  <li>html-to-image — сохранение в PNG</li>
</ul>

<hr>

<h2>⚙️ Установка и запуск</h2>
<ol>
  <li>Клонировать репозиторий:
    <pre><code>git clone https://github.com/zhaqsylykova/test.git</code></pre>
  </li>
  <li>Установить зависимости:
    <pre><code>composer install
npm install && npm run dev</code></pre>
  </li>
  <li>Скопировать .env и задать ключ Hugging Face:
    <pre><code>HUGGINGFACE_API_KEY=your_token_here</code></pre>
  </li>
  <li>Выполнить миграции:
    <pre><code>php artisan migrate</code></pre>
  </li>
  <li>Запустить сервер:
    <pre><code>php artisan serve</code></pre>
  </li>
</ol>

<h2>🚀 Онлайн-демо</h2>
<p>Протестировать приложение можно здесь:</p>
<p><a href="http://91.243.71.186:8008/" target="_blank"><strong>🔗 http://91.243.71.186:8008/</strong></a></p>

