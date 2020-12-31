@extends('layouts.app')

@section('content')

    @if (Auth::check())



        <div class="row">
            <aside class="col-sm-4">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">ユーザ:{{ Auth::user()->name }}</h3>
                    </div>
                </div>
                <div>
                    {!! link_to_route('tasks.create', '新規タスク投稿', [],  ['class' => 'btn btn-primary']) !!}
                </div>
            </aside>
            <div class="col-sm-8">
                {{-- 投稿一覧 --}}
                @include('tasks.tasklist')
            </div>
        </div>


    @else
        <div class="center jumbotron">
            <div class="text-center">
                <h1>Welcome to the Tasklist</h1>
                {{-- ユーザ登録ページへのリンク --}}
                {!! link_to_route('signup.get', 'Sign up now!', [], ['class' => 'btn btn-lg btn-primary']) !!}
            </div>
        </div>

{{--
            <div>
@if (count($tasks) > 0)
    <p>すべてのタスクリスト</p>
    <ul class="list-unstyled">
        @foreach ($tasks as $task)
            <li class="media mb-3">
                <div class="media-body">
                    <div>
                        <p class="mb-0">ステータス：{!! nl2br(e($task->status)) !!}</p>
                    </div>               
                    <div>
                        <p class="mb-0">タスク内容：{!! nl2br(e($task->content)) !!}</p>
                    </div>
               
                    
                    
                </div>
            </li>
        @endforeach
    </ul>
    {{ $tasks->links() }}
    
@endif




        </div>
        --}}
        
    @endif
    
@endsection