<?php
namespace App\Services;

use App\DTO\LogControllerDTO\StoreLogDTO;
use App\Models\FrontendLog;
use Illuminate\Database\Eloquent\ModelNotFoundException;



class LogsService
{
    // Método para armazenar um novo log
    public function store(StoreLogDTO $storeLogDTO): void
    {
        // Verifica se já existe um log com a mesma mensagem
        // $existingLog = FrontendLog::where('message', $storeLogDTO->message)->first();
        // if ($existingLog) {
        //     throw new ModelNotFoundException("Log já existe com esta mensagem.");
        // }
        // dd($storeLogDTO);
        FrontendLog::create($storeLogDTO->toArray());
    }
}