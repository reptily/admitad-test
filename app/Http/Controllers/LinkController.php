<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LinkCreateRequest;
use App\Http\Resources\LinkCreatedResource;
use App\Link;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Request;

class LinkController extends Controller
{

    public function __construct()
    {
        $this->middleware("web");
    }

    public function createLink(LinkCreateRequest $request)
    {
        $user = Auth::user();

        /**
         * Если приходит время смерти ссылки, то проверяем валидность переменной
         */
        if ($request->dead_time) {
            $request->validate(['dead_time' => 'date']);
        }

        $link = Link::create([
            'redirect_to' => $request->link,
            'user_id' => $user->id ?? 0,
            'undead' => $request->dead_time ? false : true,
            'dead_time' => $request->dead_time ? Carbon::parse($request->dead_time)->format("Y-m-d") : null,
        ]);

        return new LinkCreatedResource($link);
    }

}
