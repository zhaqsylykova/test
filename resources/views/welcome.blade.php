<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>StoryForge — Твоя история</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<style>
    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        font-family: 'Inter', sans-serif;
        background: linear-gradient(135deg, #f3e7e9, #e3eeff);
        color: #333;
    }

    .overlay {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
    }

    .container {
        background: rgba(255, 255, 255, 0.9);
        padding: 40px;
        border-radius: 20px;
        max-width: 500px;
        width: 90%;
        text-align: center;
        box-shadow: 0 8px 30px rgba(0,0,0,0.1);
    }

    h1 {
        font-size: 36px;
        margin-bottom: 10px;
    }

    .subtitle {
        color: #666;
        margin-bottom: 30px;
        font-size: 16px;
    }

    input {
        padding: 12px;
        width: 80%;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 10px;
        outline: none;
    }

    button {
        background: #6c5ce7;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 10px;
        cursor: pointer;
        transition: background 0.3s ease;
        font-size: 14px;
    }

    button:hover {
        background: #574b90;
    }

    h2 {
        margin-top: 30px;
        font-size: 24px;
        color: #444;
    }

    .story-list {
        margin-top: 20px;
        text-align: left;
    }

    .story-list div {
        background: #f7f7f7;
        padding: 12px 18px;
        margin-bottom: 10px;
        border-radius: 10px;
        transition: background 0.2s ease;
        cursor: pointer;
    }

    .story-list div:hover {
        background: #ececec;
    }

    .create-story-container {
        margin-top: 30px;
        text-align: center;
    }
</style>
<body>
<div class="overlay">
    <div class="container">
        <h1>🎭 StoryForge</h1>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <p class="subtitle">Создавай истории и проходи чужие</p>

        <input type="text" id="nickname" placeholder="Твой никнейм">
        <input type="text" id="story-title" placeholder="Название новой истории">
        <button onclick="createStory()">Создать историю</button>

        <h2>📚 Истории:</h2>
        <div id="stories" class="story-list"></div>
    </div>
</div>

<script src="{{ asset('js/script.js') }}"></script>
</body>
</html>

<script>
    function createStory() {
        const nickname = document.getElementById('nickname').value;
        const title = document.getElementById('story-title').value;

        if (nickname.trim() === '' || title.trim() === '') {
            alert('Пожалуйста, введите никнейм и название истории!');
            return;
        }

        localStorage.setItem('nickname', nickname);

        fetch('/api/stories', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                title: title,
                author: nickname,
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.id) {
                    alert('История создана успешно!');
                    loadStories();
                    document.getElementById('story-title').value = '';
                    document.getElementById('nickname').value = '';
                }
            })
            .catch(() => {
                alert('Ошибка при создании истории');
            });
    }

    function loadStories() {
        fetch('/api/stories')
            .then(response => response.json())
            .then(data => {
                const container = document.getElementById('stories');
                container.innerHTML = '';
                data.forEach(story => {
                    const el = document.createElement('div');
                    el.textContent = story.title;
                    el.onclick = () => {
                        window.location.href = `/story/${story.id}`;
                    };
                    container.appendChild(el);
                });
            })
            .catch(() => {
                const container = document.getElementById('stories');
                container.innerHTML = '<p>Нет доступных историй.</p>';
            });
    }
    
    loadStories();
</script>
