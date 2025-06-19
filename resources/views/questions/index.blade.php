<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>質問一覧</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background-color: #f4f4f4; }
        .container { max-width: 800px; margin: auto; background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { color: #333; text-align: center; margin-bottom: 30px; }
        .question-item { border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 5px; background-color: #f9f9f9; }
        .question-item h2 { margin-top: 0; color: #0056b3; font-size: 1.2em; }
        .question-item p { color: #555; line-height: 1.5; }
        .question-meta { font-size: 0.9em; color: #777; margin-top: 10px; }
        .pagination { margin-top: 20px; text-align: center; }
        .pagination a, .pagination span {
            display: inline-block;
            padding: 8px 12px;
            margin: 0 4px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #007bff;
            background-color: #fff;
        }
        .pagination span.current {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }
        .pagination a:hover {
            background-color: #e2f0ff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>質問一覧</h1>

        @forelse ($questions as $question)
            <div class="question-item">
              <h2><a href="{{ route('questions.show', $question->id) }}">{{ $question->title }}</a></h2>
              <p>{{ Str::limit($question->content, 150) }}</p>
              <div class="question-meta">
                      投稿者: {{ $question->user->username }} (ID: {{ $question->user->id }}) <br>
                      投稿日時: {{ $question->posted_at->format('Y/m/d H:i') }}
              </div>
           </div>
        @empty
            <p>まだ質問がありません。</p>
        @endforelse

        {{-- ページネーションリンク --}}
        <div class="pagination">
            {{ $questions->links() }}
        </div>
    </div>
</body>
</html>