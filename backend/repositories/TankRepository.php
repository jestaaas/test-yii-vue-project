<?php

namespace app\repositories;
use app\models\Tank;

class TankRepository {
    public function findAll(): array {
        return Tank::find()->orderBy(['id' => SORT_ASC])->all();
    }

    // находим цистерну с наименьшим заполнением
    public function findLeastFilledTank(): ?Tank {
        return Tank::find()
            ->orderBy(['current_volume' => SORT_ASC])
            ->one();
    }

    // сохраняем цистерну
    public function save(Tank $tank): bool {
        return $tank->save();
    }
}