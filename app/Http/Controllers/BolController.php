<?php

namespace App\Http\Controllers;

use App\Repositories\Bol\IBol;
use App\Repositories\Bol\BolRepository;
use Illuminate\Http\Request;

class BolController extends Controller
{
    protected $bolRepository;

    public function __construct(BolRepository $bolRepository)
    {
        $this->bolRepository = $bolRepository;
    }

    public function store(Request $request)
    {
        try {
            $bol = $request->all();
            $this->bolRepository->create($bol);

            return response()->json(['message' => 'BOL created successfully'], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to create BOL', 'error' => $e->getMessage()], 500);
        }
    }
}