<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Show a list of all of the application's users.
     *
     * @return Response
     */

    public function index()
    {
      // Get the currently authenticated user's ID...
      $id = Auth::id();

      $products = DB::table('agreements')
              ->join('dumps', 'dumps.id', '=', 'agreements.id_dump')
              ->join('products', 'products.ID', '=', 'agreements.id_product')
              ->join('emails', 'emails.ID', '=', 'agreements.id_email')
              ->select('products.ID as id', 'products.name as name')
              ->where('id_dump','=',$id)
              ->whereNull('id_bin')
              ->groupBy('products.ID')
              ->groupBy('products.name')
              ->get();

      $bins = DB::table('bins')->get();

      return view('product', [
        'products' => $products,
        'bins' => $bins
      ]);
    }

    public function bin(Request $request, $product)
    {
      $bin = $request->input('bin');
      // Get the currently authenticated user's ID...
      $dump = Auth::id();

      DB::table('agreements')
            ->where('id_dump', $dump)
            ->where('id_product', $product)
            ->update([
              'id_status' => 1,
              'id_bin' => $bin
            ]);

      return redirect()->action('ProductController@index');
    }

    public function destroy($product)
    {
      // Get the currently authenticated user's ID...
      $dump = Auth::id();

      DB::table('agreements')
            ->where('id_dump', $dump)
            ->where('id_product', $product)
            ->delete();

      return redirect()->action('ProductController@index');
    }
}
