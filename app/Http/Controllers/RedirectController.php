<?php

namespace App\Http\Controllers;

use App\History;
use App\Link;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;

class RedirectController extends Controller
{
    public function redirect(Request $request)
    {
        $link = Link::where('key', $request->slug)->first();

        /**
         * Если ссылки нет то редиректем на главную
         */
        if (empty($link)) {
            return redirect("/");
        }

        /**
         * Если время жизни ссылки закончилось, редириктем на главную
         */
        if ($link->undead == 0 && $link->dead_time < Carbon::now()) {
            return redirect("/");
        } else {
            $agent = new Agent();
            $browser = $agent->browser();

            $link->count_redirect++;
            $link->save();

            /**
             * Создаем запись в истории переходов
             */
            History::create([
                'link_id' => $link->id,
                'browser' => $browser,
                'browser_version' => $agent->version($browser),
                'platform' => $agent->platform(),
                'languages' => $agent->languages()[0] ?? "none",
                'device' => $agent->device() ?? "none",
                'ip' => $request->getClientIp(),
            ]);

            return redirect($link->redirect_to);
        }
    }
}
