<?php

namespace app\services;

use app\models\Tank;
use app\models\Filling;
use app\repositories\TankRepository;
use app\repositories\FillingRepository;

class FillingService {
    private $tankRepository;
    private $fillingRepository;

    // внедрение зависимостей через конструктор

    public function __construct(
        TankRepository $tankRepository,
        FillingRepository $fillingRepository
    ) {
        $this->tankRepository = $tankRepository;
        $this->fillingRepository = $fillingRepository;
    }

    public function fillTank(string $username, int $volume): array {
        // находим цистерну с наименьшим заполнением
        $tankToFill = $this->tankRepository->findLeastFilledTank();

        // на случай, если цистерн нет
        if (!$tankToFill) {
            return ['success' => false, 'error' => 'Цистерны не найдены.'];
        }

        // получаем новый объем цистерны после заполнения и проверяем его
        $newVolume = $tankToFill->current_volume + $volume;
        
        if ($newVolume > Tank::MAX_VOLUME) {
            return ['success' => false, 'error' => 'Превышен максимальный объем цистерны.'];
        }

        // если все проверки пройдены, обновляем объем цистерны
        $tankToFill->current_volume = $newVolume;
        if (!$this->tankRepository->save($tankToFill)) {
            return [
                'success'=> true,
                'message' => 'Не удалось обновить цистерну.',
            ];
        }

        // сохраняем информацию о заполнении
        $filling = new Filling();
        $filling->tank_id = $tankToFill->id;
        $filling->volume = $volume;
        $filling->username = $username;


        if (!$this->fillingRepository->save($filling)) {
            return [
                'success' => false,
                'error' => 'Не удалось сохранить информацию о заполнении.',
            ];
        }

        return [
            'success' => true,
            'message' => 'Цистерна успешно заполнена.',
            'tank_id' => $tankToFill->id,
            'current_volume' => $tankToFill->current_volume,
        ];
    }

    // получаем историю заполнений цистерн
    public function getFillingsHistory(): array {

        $fillings = $this->fillingRepository->findAll();

        return [
            'fillings_history' => $fillings,
        ];
    }
}