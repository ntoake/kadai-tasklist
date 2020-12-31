@if (count($tasks) > 0)
    <p>{{ Auth::user()->name }}のタスク</p>
    <ul class="list-unstyled">
        @foreach ($tasks as $task)
            <li class="media mb-3">
                {{-- 投稿の所有者のメールアドレスをもとにGravatarを取得して表示 --}}
                <div class="media-body">
                    <div>
                        {{-- 投稿の所有者のユーザ詳細ページへのリンク --}}
                        <span class="text-muted">posted at {{ $task->created_at }}</span>
                    </div>
                    <div>
                        <p class="mb-0">ステータス：{!! nl2br(e($task->status)) !!}</p>
                    </div>               
                    <div>
                        {{-- 投稿内容 --}}
                        <p class="mb-0">タスク内容：{!! nl2br(e($task->content)) !!}</p>
                    </div>
                    
                    @if (Auth::id() == $task->user_id)
                        <div>
                            
                            
                        {!! link_to_route('tasks.edit', 'このタスクを編集', ['task'=>$task->id], ['class' => 'btn btn-light']) !!}                            
                            
                        {{-- 投稿削除ボタンのフォーム --}}
                        {!! Form::open(['route' => ['tasks.destroy', $task->id], 'method' => 'delete']) !!}
                            {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                        {!! Form::close() !!}
                        </div>
                    @endif                    
                    
                    
                </div>
            </li>
        @endforeach
    </ul>
    {{-- ページネーションのリンク --}}
    {{ $tasks->links() }}
@endif