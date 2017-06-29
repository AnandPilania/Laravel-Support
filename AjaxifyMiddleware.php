<?php

namespace Anand\Support;

use Closure;
use Illuminate\Http\JsonResponse;

class AjaxifyMiddleware
{
    public function handle($request, Closure $next, $guard = null)
    {
        $response = $next($request);

        if(!$this->shouldAjaxify($request, $response)){
            return $response;
        }

        if($response->isSuccessful()){
            $originalContent = $response->getOriginalContent();
            $data = $originalContent->getData();
            return $response()->json($data);
        }

        $flashData = $this->getFlashData($request);

        if(!count($flashData)){
            return $response;
        }

        return $response()->json($flashData, $response->getStatusCode());
    }

    protected function shouldAjaxify($request, $response)
    {
        if($response instanceof JsonResponse){
            return false;
        }

        if($response->isServerError()){
            return false;
        }

        if($response->isSuccessful() && !method_exists($response->getOriginalContent(), 'getData')){
            return false;
        }

        return $request->ajax() || $request->wantsJson() || $request->exists('ajaxify');
    }

    protected function getFlashData($request)
    {
        $sessionData = collect($request->session()->all());
        $flashedKeys = $request->session()->get('flash.new');
        $flashData = $sessionData->only($flashedKeys);

        $request->session()->forget($flashedKeys);
        return $flashData;
    }
}