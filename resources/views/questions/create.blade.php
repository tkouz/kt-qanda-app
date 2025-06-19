<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>質問投稿</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: auto; background: #fff; padding: 25px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .back-link { display: inline-block; margin-bottom: 20px; text-decoration: none; color: #007bff; }
        .back-link:hover { text-decoration: underline; }
        h1 { color: #333; text-align: center; margin-bottom: 30px; }
        form div { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; color: #555; font-weight: bold; }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box; /* paddingとborderをwidthに含める */
            font-size: 1em;
        }
        textarea {
            resize: vertical; /* 垂直方向のみリサイズ可能 */
            min-height: 150px;
        }
        button {
            background-color: #28a745;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 1.1em;
            width: 100%;
        }
        button:hover {
            background-color: #218838;
        }
        .error-message {
            color: #dc3545;
            font-size: 0.9em;
            margin-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('questions.index') }}" class="back-link">&larr; 質問一覧に戻る</a>

        <h1>質問を投稿する</h1>

        <form action="{{ route('questions.store') }}" method="POST">
            @csrf {{-- ★この行を追加！★ --}}
            <div>
                <label for="title">タイトル:</label>
                <input type="text" id="title" name="title" value="{{ old('title') }}" required>
                @error('title')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div>
                <label for="content">質問内容:</label>
                <textarea id="content" name="content" required>{{ old('content') }}</textarea>
                @error('content')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit">質問を投稿</button>
        </form>
    </div>
</body>
</html>