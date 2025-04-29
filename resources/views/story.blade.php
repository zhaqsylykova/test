<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>StoryForge — История</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/html-to-image@0.1.10/dist/html-to-image.min.js"></script> <!-- Подключаем библиотеку -->
</head>
<style>
    .ai-generator {
        margin-top: 30px;
        text-align: left;
    }

    .ai-generator textarea {
        width: 100%;
        padding: 10px;
        border-radius: 10px;
        border: 1px solid #ccc;
        margin-bottom: 10px;
        resize: vertical;
    }

    .ai-generator button {
        background: #00b894;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 10px;
        cursor: pointer;
        transition: background 0.3s ease;
        font-size: 14px;
    }

    .ai-generator button:hover {
        background: #019875;
    }

    #ai-result {
        margin-top: 20px;
        padding: 15px;
        background: #f1f1f1;
        border-radius: 10px;
        white-space: pre-wrap;
    }

    #chapters-list {
        background: #f9f9f9;
        padding: 20px;
        border-radius: 15px;
        margin: 20px 0;
    }

    .chapter-block {
        margin-bottom: 30px;
        padding: 20px;
        background: #f9f9f9;
        border-radius: 10px;
    }

    .chapter-block h2 {
        margin-top: 0;
    }


</style>


<body>

<div class="overlay">
    <div class="container">
        <h1 id="story-title">Загрузка...</h1>
        <div id="chapters-list"></div>
    </div>
</div>

<div class="ai-generator">
    <h3>✨ AI-помощник для главы</h3>
    <textarea id="prompt" placeholder="Опиши, что должно произойти..." rows="4"></textarea>
    <button onclick="generateChapter()">Сгенерировать главу</button>
    <div id="ai-result"></div>
</div>

<script>
    const storyId = window.location.pathname.split('/')[2];
    let chapters = [];

    fetch(`/api/stories/${storyId}`)
        .then(response => response.json())
        .then(story => {
            document.getElementById('story-title').textContent = story.title;
            chapters = story.chapters;
            renderChapters();
        });

    function renderChapters() {
        const chaptersList = document.getElementById('chapters-list');
        chaptersList.innerHTML = '';

        chapters.forEach(chapter => {
            const chapterBlock = document.createElement('div');
            chapterBlock.classList.add('chapter-block');

            chapterBlock.innerHTML = `
            <h2>${chapter.title} <small>(от: ${chapter.author})</small></h2>
            <p>${chapter.text}</p>
        `;

            if (chapter.actions && chapter.actions.length > 0) {
                const actionsDiv = document.createElement('div');
                chapter.actions.forEach(action => {
                    const btn = document.createElement('button');
                    btn.textContent = action.text;
                    btn.onclick = () => {
                        if (action.next_chapter_id) {
                            loadChapterFromId(action.next_chapter_id);
                        }
                    };
                    actionsDiv.appendChild(btn);
                });
                chapterBlock.appendChild(actionsDiv);
            }

            chaptersList.appendChild(chapterBlock);
        });
    }

    function loadChapterFromId(chapterId) {
        fetch(`/api/chapters/${chapterId}`)
            .then(response => response.json())
            .then(chapter => {
                chapters.push(chapter);
                renderChapters();
            });
    }

    function generateChapter() {
        const prompt = document.getElementById('prompt').value;
        if (prompt.trim() === '') {
            alert('Напиши, что AI должен продолжить!');
            return;
        }

        const nickname = localStorage.getItem('nickname') || "Неизвестный автор";

        document.getElementById('ai-result').innerHTML = '⏳ Генерация...';

        const fullStory = chapters.map(ch => `${ch.title}\n${ch.text}`).join('\n\n');
        const fullPrompt = `${fullStory}\n\nПродолжи историю: ${prompt}`;

        fetch('/api/ai/generate-chapter', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ prompt: fullPrompt })
        })
            .then(response => response.json())
            .then(data => {
                if (data[0] && data[0].generated_text) {
                    const result = data[0].generated_text;
                    document.getElementById('ai-result').innerHTML = '✅ Глава сгенерирована и добавлена выше.';

                    const nextChapterNumber = chapters.length + 1;

                    fetch('/api/chapters', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({
                            story_id: storyId,
                            title: `Глава ${nextChapterNumber}`,
                            text: result,
                            is_final: false,
                            author: nickname,
                        })
                    })
                        .then(response => response.json())
                        .then(saveData => {
                            console.log('Сохранено:', saveData);
                            chapters.push(saveData);
                            renderChapters();
                            document.getElementById('prompt').value = '';
                        })
                        .catch(() => {
                            console.log('Ошибка при сохранении главы.');
                        });
                } else {
                    document.getElementById('ai-result').innerHTML = 'Не удалось сгенерировать текст.';
                }
            })
            .catch(() => {
                document.getElementById('ai-result').innerHTML = 'Ошибка при обращении к AI.';
            });
    }

    function downloadResultImage() {
        const node = document.getElementById('chapters-list');
        console.log('Trying to generate image from:', node);

        htmlToImage.toPng(node)
            .then(function (dataUrl) {
                console.log('Image generated successfully'); 
                const link = document.createElement('a');
                link.download = 'story-result.png';
                link.href = dataUrl;
                link.click();
            })
            .catch(function (error) {
                console.error('Ошибка генерации изображения:', error);
            });
    }
</script>
</body>
</html>
