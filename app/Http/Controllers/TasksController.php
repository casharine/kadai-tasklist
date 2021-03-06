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
    // getでmessages/にアクセスされた場合の「一覧表示処理」
        public function index()
    {
        $data = [];
        if (\Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = \Auth::user();
             //タスク一覧を取得
            $tasks = $user->tasks()->orderBy('created_at', 'desc')->paginate(10);
            $data = [
                'user' => $user,
                'tasks' => $tasks,
            ];
            return view('tasks.index',$data);
        }
        
        //サインアップ前ユーザーはウェルカムページへ
        return view('welcome',$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // getでmessages/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
        $task = new Task;

        // メッセージ作成ビューを表示
        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // postでmessages/にアクセスされた場合の「新規登録処理」
     public function store(Request $request)
    {
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',   // 追加
            'content' => 'required|max:255',
        ]);

        // 認証済みユーザーとして作成
        $request->user()->tasks()->create([
        'status' => $request->status,    // 追加
        'content' => $request->content,
        ]);

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // getでmessages/（任意のid）にアクセスされた場合の「取得表示処理」
    public function show($id)
    {   
        // タスクidの取得
        $task = Task::findOrFail($id);
       
       //　タスクidの所有者か　真：ユーザーは認証済みユーザー
        if (\Auth::id() === $task->user_id) {
             $user = \Auth::user();
            
            // タスク詳細ビューでそれらを表示
            return view('tasks.show', [
                'user' => $user,
                'task' => $task,
        ]);
        }
        //else リダイレクト
        return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
     // getでmessages/（任意のid）/editにアクセスされた場合の「更新画面表示処理」
    public function edit($id)
    {   
        // タスクidの取得
        $task = Task::findOrFail($id);
       
       //　タスクidの所有者か　真：ユーザーは認証済みユーザー
        if (\Auth::id() === $task->user_id) {
             $user = \Auth::user();
            

        // タスク編集ビューでそれを表示
        return view('tasks.edit', [
            'task' => $task,
        ]);
        }
        return redirect('/');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // putまたはpatchでmessages/（任意のid）にアクセスされた場合の「更新処理」

    public function update(Request $request, $id)
    {   
        // タスクidの取得
        $task = Task::findOrFail($id);
       
       //　タスクidの所有者か　真：ユーザーは認証済みユーザー
        if (\Auth::id() === $task->user_id) {
             $user = \Auth::user();
            
         // バリデーション
        $request->validate([
            'status' => 'required|max:10',   // 追加
            'content' => 'required|max:255',
        ]);
        
        //　タスク更新
        $task->status = $request->status;
        $task->content = $request->content;
        $task->save();
    }
        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * 
     */
     // deleteでmessages/（任意のid）にアクセスされた場合の「削除処理」
    public function destroy($id)
    {   
        // タスクidの取得
        $task = Task::findOrFail($id);
       
       //　タスクidの所有者か　真：ユーザーは認証済みユーザー
        if (\Auth::id() === $task->user_id) {
             $user = \Auth::user();
             
        //　タスク削除
        if (\Auth::id() === $task->user_id) {
            $task->delete();
         }
         }
        // トップページへリダイレクトさせる
        return redirect('/');
    }
}
