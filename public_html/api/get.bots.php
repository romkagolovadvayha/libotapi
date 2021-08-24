<?php
header('Content-Type: application/json');
require __DIR__ . '/../../vendor/autoload.php';

$config = \Libot\Config::getInstance();
$tradeBotRepository = new \Libot\TradeBotRepository($config->PDO);
$useCase = new \Libot\Models\Bot($tradeBotRepository);
$userUseCase = new \Libot\Models\User($tradeBotRepository);

$userId = filter_input(INPUT_GET, 'userId', FILTER_SANITIZE_STRING);

$bots = [];
try {
    $userUseCase->checkAuthUser();
    $bots = $useCase->getBots($userId);
} catch (\ErrorException $ex) {
    echo json_encode(['status' => $ex->getCode(), 'error' => $ex->getMessage()]);
    exit;
}


echo json_encode(['status' => 200, 'response' => ['bots' => $bots]]);