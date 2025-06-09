<?php

namespace App\Http\Controllers;

use App\Http\Requests\LogRequest;
use App\DTO\LogControllerDTO\StoreLogDTO;
use App\Services\LogsService;

class LogController extends Controller
{
    public function __construct(
        protected LogsService $logsService
    )
    {}

    public function store(LogRequest $request)
    {
        $this->processLog($request);
        return response()->json(['message' => 'Error register success'], 201);
    }

    private function processLog(LogRequest $request)
    {
        
        $DTO = StoreLogDTO::fromRequest($request->validated());
        
        $this->logsService->store($DTO);
    }
}
