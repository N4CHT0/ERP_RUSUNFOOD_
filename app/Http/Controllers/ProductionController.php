<?php

namespace App\Http\Controllers;

use App\Models\Production;
use Illuminate\Http\Request;

class ProductionController extends Controller
{
    public function index()
    {
        $data = Production::with('product')->paginate(100);

        return view('modules.manufacturing.index', [
            'data' => $data,
        ]);
    }
}
