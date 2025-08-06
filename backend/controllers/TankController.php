<?php
namespace app\controllers;

use yii\rest\Controller;
use app\services\FillingService;
use app\services\TankService;
use yii\filters\Cors;

class TankController extends Controller {
    // инъекция зависимостей
    private $fillingService;
    private $tankService;

    public function __construct($id, $module, FillingService $fillingService, TankService $tankService, $config = [])
    {
        $this->fillingService = $fillingService;
        $this->tankService = $tankService;
        parent::__construct($id, $module, $config);
    }

    // настройки CORS
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['http://localhost:5173'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => true,
            ],
        ];

        return $behaviors;
    }

    public function actionOptions()
    {
        \Yii::$app->response->statusCode = 200;
    }
    // обработка запроса на заполнение цистерны
    public function actionFill() {
        // получаем данные запроса
        $requestData = \yii::$app->request->post();
        $username = $requestData['username'] ?? null;
        $volume = $requestData['volume'] ?? 0;


        // проверяем, что имя пользователя и объем заполнения указаны
        if (empty($username) || !is_numeric($volume) || $volume <= 0) {
            \yii::$app->response->statusCode = 400;
            return ['error' => 'Неверные данные запроса. Имя и объем должны быть указаны корректно.'];
        }

        // вызываем сервис для заполнения цистерны
        $result = $this->fillingService->fillTank($username, (int)$volume);

        if ($result['success']) {
            \yii::$app->response->statusCode = 200;

            return [
                'status' => 'success',
                'message' => $result['message'],
                'tank_id' => $result['tank_id'],
                'current_volume' => $result['current_volume'],
            ];
        }
        else {
            \yii::$app->response->statusCode = 422;
            return ['error' => $result['error']];
        }
    }

    // получаем статистику по цистернам
    public function actionTanksStats() {
        return $this->tankService->getTankStats();
    }

    // получаем историю заполнений цистерн
    public function actionFillingsHistory() {
        return $this->fillingService->getFillingsHistory();
    }
}