<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //$tasks = Task::orderBy('id', 'asc')->get();
        //$tasks = Task::all();
        //return view('tasks.index', ['tasks'=>$tasks]);
        
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
            // ユーザの投稿の一覧を作成日時の降順で取得
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
        }/* else {
            $tasks = Task::orderBy('created_at', 'desc')->paginate(10);
            $data = [
                'tasks' => $tasks,
            ];            
        }*/

        // Welcomeビューでそれらを表示
        return view('welcome', $data);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        /*
        $task = new Task;
        return view('tasks.create', ['task'=>$task]);
        */
        
        $task = new Task;
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();

            $data = [
                'user' => $user,
                'task' => $task,              
            ];
        }

        // Welcomeビューでそれらを表示
        return view('tasks.create', $data);       
        
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
       /*$request->validate([
        'content' => 'required|max:255',
        'status' => 'required|max:10',
        ]);     
        
        $task = new Task;
        $task->content = $request->content;
        $task->status = $request->status;
        $task->save();
        
        return redirect('/');*/
        // バリデーション
        $request->validate([
            'content' => 'required|max:255',
            'status' => 'required|max:10',
        ]);
        
        // 認証済みユーザ（閲覧者）の投稿として作成（リクエストされた値をもとに作成）
        $request->user()->tasks()->create([
            'content' => $request->content,
            'status' => $request->status,
        ]);

        // 前のURLへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $task = Task::findOrFail($id);
        return view('tasks.show', ['task'=>$task]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        /*$task = Task::findOrFail($id);
        return view('tasks.edit', ['task'=>$task]);*/
         
        $task = Task::findOrFail($id);
        if (\Auth::id() ===$task->user_id) { // 認証済みの場合
            // 認証済みユーザを取得
            //$user = \Auth::user();
            // ユーザの投稿の一覧を作成日時の降順で取得
            /*$tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);

            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];*/
            
            
            
            return view('tasks.edit', ['task'=>$task]);
            
        } else {
            return redirect('/');
        }         
        
        
        
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
       $request->validate([
        'content' => 'required|max:255',
        'status' => 'required|max:10',
        ]);     
        
        $task = Task::findOrFail($id);
        $task->content = $request->content;
        $task->status = $request->status;
        $task->save();
        
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        /*$task = Task::findOrFail($id);
        $task->delete();
        
        return redirect('/');*/
        
        $task = Task::findOrFail($id);
        // 認証済みユーザ（閲覧者）がその投稿の所有者である場合は、投稿を削除
        if (\Auth::id() === $task->user_id) {
            $task->delete();
        }        
        
        return back();        
    }
}
