<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CountryController extends Controller
{
  public function search(Request $request)
  {
    $q = trim((string) $request->get('q', ''));
    try 
    {
      if ($q !== '' && mb_strlen($q) >= 2) 
      {
        $url = "https://restcountries.com/v3.1/name/".rawurlencode($q);
        $resp = Http::timeout(6)->retry(1, 500)->get($url, [
          'fields' => 'name,idd,cca2'
        ]);
        if (! $resp->successful()) 
        {
          Log::warning('restcountries name search failed', ['q'=>$q, 'status'=>$resp->status()]);
          return response()->json([], 200);
        } $countries = $resp->json();
      } 
      else 
      {
        $countries = Cache::remember('restcountries_all', 60 * 24, function () {
          $url = 'https://restcountries.com/v3.1/all';
          $resp = Http::timeout(10)->retry(1, 800)->get($url, [
            'fields' => 'name,idd,cca2'
          ]);
          if (! $resp->successful()) 
          {
            Log::error('restcountries /all failed', ['status' => $resp->status(), 'body' => $resp->body()]);
            return [];
          }
          return $resp->json();
        });
      }

      if (!is_array($countries)) 
      {
        Log::warning('restcountries returned unexpected payload', ['q'=>$q, 'payload'=>gettype($countries)]);
        return response()->json([], 200);
      }

      $items = [];
      foreach ($countries as $c) 
      {
        $name = data_get($c, 'name.common') ?? data_get($c, 'name.official') ?? null;
        $iddRoot = data_get($c, 'idd.root');
        $iddSuffixes = data_get($c, 'idd.suffixes', []);
        if (! $name || ! $iddRoot || empty($iddSuffixes) || ! is_array($iddSuffixes)) { continue; }
        $suffix = null;
        foreach ($iddSuffixes as $suf) { if (is_string($suf) && $suf !== '') { $suffix = $suf; break; } }
        if ($suffix === null) continue;
        $calling = $iddRoot . $suffix;
        $calling = preg_replace('/\s+/', '', $calling);

        $items[] = [
          'id'   => $calling,
          'text' => "{$name} ({$calling})",
          'cca2' => data_get($c, 'cca2')
        ];
      }

      usort($items, function ($a, $b) 
      {
        return strcasecmp($a['text'], $b['text']);
      });

      if ($q !== '') 
      {
        $items = array_slice($items, 0, 60);
      } 
      else 
      {
        // for "all" we might want to limit to a reasonable number for the UI,
        // but keep entire list if you prefer. Here we return all.
      }
      return response()->json($items);
    } catch (\Throwable $e) {
      Log::error('CountryController::search exception: '.$e->getMessage(), [
        'exception' => $e
      ]);
      return response()->json([], 200);
    }
  }
}
