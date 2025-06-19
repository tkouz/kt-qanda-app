<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>質問詳細 - {{ $question->title }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; }
        .container { max-width: 800px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        .back-link { display: inline-block; margin-bottom: 20px; text-decoration: none; color: #007bff; }
        .back-link:hover { text-decoration: underline; }
        h1 { color: #333; margin-bottom: 10px; }
        .question-meta { font-size: 0.9em; color: #777; margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
        .question-content { background-color: #f9f9f9; padding: 15px; border-radius: 5px; border: 1px solid #ddd; margin-bottom: 30px; line-height: 1.6; }

        h2 { color: #333; margin-top: 30px; margin-bottom: 15px; border-bottom: 2px solid #007bff; padding-bottom: 5px; }
        .answer-item { background-color: #e9f5ff; padding: 15px; margin-bottom: 20px; border-radius: 5px; border: 1px solid #cceeff; }
        .answer-meta { font-size: 0.85em; color: #666; margin-bottom: 10px; }
        .answer-content { line-height: 1.5; margin-bottom: 15px; }

        h3 { color: #555; margin-top: 20px; margin-bottom: 10px; font-size: 1.1em; border-bottom: 1px dashed #ccc; padding-bottom: 5px; }
        .comment-item { background-color: #f0f0f0; padding: 10px; margin-bottom: 10px; border-radius: 4px; border: 1px solid #eee; font-size: 0.9em; }
        .comment-meta { font-size: 0.8em; color: #888; margin-top: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <a href="{{ route('questions.index') }}" class="back-link">&larr; 質問一覧に戻る</a>

        <h1>{{ $question->title }}</h1>
        <div class="question-meta">
            投稿者: {{ $question->user->username }} (ID: {{ $question->user->id }})<br>
            投稿日時: {{ $question->posted_at->format('Y/m/d H:i') }}
        </div>
        <div class="question-content">
            <p>{{ $question->content }}</p>
        </div>

        <h2>回答 ({{ $question->answers->count() }}件)</h2>

        @forelse ($question->answers as $answer)
            <div class="answer-item">
                <div class="answer-meta">
                    回答者: {{ $answer->user->username }} (ID: {{ $answer->user->id }})<br>
                    投稿日時: {{ $answer->posted_at->format('Y/m/d H:i') }}
                </div>
                <div class="answer-content">
                    <p>{{ $answer->content }}</p>
                </div>

                <h3>コメント ({{ $answer->comments->count() }}件)</h3>
                @forelse ($answer->comments as $comment)
                    <div class="comment-item">
                        <p>{{ $comment->content }}</p>
                        <div class="comment-meta">
                            コメント者: {{ $comment->user->username }} (ID: {{ $comment->user->id }})<br>
                            投稿日時: {{ $comment->posted_at->format('Y/m/d H:i') }}
                        </div>
                    </div>
                @empty
                    <p>まだコメントがありません。</p>
                @endforelse
            </div>
        @empty
            <p>まだ回答がありません。</p>
        @endforelse
    </div>
</body>
</html>