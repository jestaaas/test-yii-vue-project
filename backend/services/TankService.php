<?php

namespace app\services;
use app\repositories\TankRepository;
class TankService {
    // внедрение зависимостей через конструктор
    private $tankRepository;

    public function __construct(TankRepository $tankRepository) {
        $this->tankRepository = $tankRepository;
    }

    //получаем статистику по цистернам
    public function getTankStats(): array {
        $tanks = $this->tankRepository->findAll();

        return [
            'tanks_stats' => $tanks,
        ];
    }
}