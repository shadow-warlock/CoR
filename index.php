<?php


use App\CompanyStructure\Point;
use App\CompanyStructure\User;

spl_autoload_register(static function ($class_name) {
    include __DIR__ . '/src/' . str_replace("\\", "/", substr($class_name, 4)) . '.php';
});

$director = new User('Директор');
$managerNorth = new User('Северный менеджер');
$managerSouth = new User('Южный менеджер');
$sellerSPb = new User('Питерский продавец');

$root = new Point('Россия', null);
$north = new Point('Север', $root);
$south = new Point('Юг', $root);
$spb = new Point('Санкт-Петербург', $north);
$moscow = new Point('Москва', $north);
$krasnodar = new Point('Краснодар', $south);

$root->addAccessToUser($director);
$north->addAccessToUser($managerNorth);
$south->addAccessToUser($managerSouth);
$spb->addAccessToUser($sellerSPb);

function drawAccess(User $user, Point $point): void
{
    $isAccess = $point->checkUserAccess($user);
    printf(
        "Пользователь %s %s доступ к структуной единице \"%s\" \n",
        $user->getName(),
        $isAccess ? 'имеет' : 'не имеет',
        $point->getName()
    );
}
echo "Структура подразделений: \n";
echo $root->getStructureAsText();
echo "\n";
echo "Примеры доступов: \n";
drawAccess($director, $moscow);
drawAccess($managerNorth, $spb);
drawAccess($managerNorth, $krasnodar);
drawAccess($managerSouth, $moscow);
drawAccess($managerSouth, $krasnodar);
drawAccess($sellerSPb, $spb);
drawAccess($sellerSPb, $north);