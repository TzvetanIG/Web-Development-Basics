<?php
use Constants\Codes;

$cnf[Codes::USERNAME.Codes::INVALID] = 'Невалидно потребителско име. Използвай латински букви и цифри.';
$cnf[Codes::USERNAME.Codes::MIN_LENGTH] = 'Потребителското име трябва да е поне от 3 символа.';
$cnf[Codes::USERNAME.Codes::EXIST] = 'Потребителското име е заето.';
$cnf[Codes::USERNAME.Codes::PASSWORD.Codes::WRONG] = 'Грешно потребителското име или парола.';

$cnf[Codes::PASSWORD.Codes::MIN_LENGTH] = 'Паролата трябва да е поне от 5 символа.';
$cnf[Codes::PASSWORD.Codes::NOT_MATCH] = 'Въведени са различни пароли.';

$cnf[Codes::EMAIL.Codes::INVALID] = 'Невалиден email.';

$cnf[Codes::GRADE . Codes::REQUIRED] = 'Не е избран клас.';
$cnf[Codes::CATEGORIES . Codes::REQUIRED] = 'Не е въведена категория.';
$cnf[Codes::CONDITION . Codes::REQUIRED] = 'Не е въведено условие.';


return $cnf;