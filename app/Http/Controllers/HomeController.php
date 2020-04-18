<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Link;
use Illuminate\Support\Str;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user();

        $link = Link::where('user_id', $user->id)->orderBy("created_at","desc")->paginate(30);
        return view('home', ['Links' => $link]);
    }

    public function show($id)
    {
        $user = Auth::user();

        /**
         * Выкидываем пользователя если он не владелец ссылки
         */
        $link = Link::with('history')->find($id);
        if($link->user_id != $user->id) {
            return abort(403);
        }

        return view('home_show', [
            'Link' => $link->key,
            'Url' => Str::limit($link->redirect_to, 100),
            'History' => $link->history()->paginate(100)
        ]);
    }
}
