<?php
$strRoute = 'index';
if (isset($_SERVER['REDIRECT_URL'])) {
    $strRoute = substr($_SERVER['REDIRECT_URL'], 1);
}
$strMethod = $_SERVER['REQUEST_METHOD'];
$arrRoutes = include_once('route.php');
try {
    if (!array_key_exists($strRoute, $arrRoutes)) {
        throw new \Exception('A rota: ' . $strRoute . ' não existe', 500);
    }
    $arrInfoRoute = $arrRoutes[$strRoute];
    if (!array_key_exists($strMethod, $arrInfoRoute) && $strMethod != 'OPTIONS') {
        throw new \Exception('O método HTTP: ' . $strMethod . ' não existe para a rota: ' . $strRoute, 500);
    }
    require_once 'vendor/autoload.php';
    if ($arrInfoRoute) {
        $strController = $arrInfoRoute[$strMethod]['controller'];
        $strAction = $arrInfoRoute[$strMethod]['action'];
        $mixResult = (new $strController())->$strAction();
        printResult(0, $mixResult, 200);
    }
} catch (\Exception $exception) {
    printResult(
        500,
        ['message' => $exception->getMessage()],
        false
    );
}

function printResult($intCodStatus, $mixMessage, $intStatus)
{
    header('Content-Type: application/json');
    echo json_encode([
        'status' => $intStatus,
        'result' => $mixMessage,
        'codigo' => $intCodStatus
    ], JSON_PRETTY_PRINT);
}
