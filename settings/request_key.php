<?php
$subdomain = 'perecovperec123'; //Поддомен нужного аккаунта
$link = 'https://' . $subdomain . '.amocrm.ru/oauth2/access_token'; //Формируем URL для запроса

/** Соберем данные для запроса */
$data = [
	'client_id' => '7bde2837-ca51-40a8-b3fa-464d9c6278b0',
	'client_secret' => 'iP64I7VOnz9Nfq6U469zoSHMfQ54Fl0oe841sa485wi2G1B3ESNZ7AZhV7z86etu',
	'grant_type' => 'authorization_code',
	'code' => 'def50200db195223d76f667be6a5dcbd250064ce31a0290752700376e491c647db20c35cb014604180210e2375d49c5533b6da75412fe17c7f82bea1d0e854a3832f477bbd3de4d0125b60d0dfb12aa1709bbf2492a1312168894daa8b7daf99650518531a21e6c5d030577aa172a09c50d6a3cf4076704d88a108e9f6b5c71ccf411102caf18056c8dd79aac145ca9adaaa37c8192f862a8ea13a357bad7ba839e79328fa2863bd6ab44d5a484e9b91429bd020a2cf457b026900fa6cd2690ac0113675fb76d430f7e036d6b56efda604c17f72776292f1010a6f64a9e4c3bc971448069921430dc619108da956d86d272d9409f0e1261793cdfd47ed4c6077a80624aeee110e14b0924bc1979ab13793fa36fbfb43509335ea54b21982f4605abd29d635d134d80cec9cdf8060d38a68a935ee84cc7594269565df8308d671480ecfb8b481e299d949419771d269dc9a39b3ddd11dd75923d41b38900b2e4e3ebc8f037b5e068063c86f1e837583286a92d5439e1d0c0436f5953e54b746bd114b2833e9e100bbc8e9dcd4d191ee9d2394dc23d6738a51e0d1e75754c39068887a7ea99dbf953dfcde8729bd1345464365b7d25061577957585960ce53a2ce944ce197169942bb6704aca57d3f3ed6c30330e322e8ee67b5b5b998e69e8abdae2a9684dfb6ab3acb',
	'redirect_uri' => 'https://testformamocrm.000webhostapp.com/settings/get_key.php',
];

/**
 * Нам необходимо инициировать запрос к серверу.
 * Воспользуемся библиотекой cURL (поставляется в составе PHP).
 * Вы также можете использовать и кроссплатформенную программу cURL, если вы не программируете на PHP.
 */
$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
/** Устанавливаем необходимые опции для сеанса cURL  */
curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
curl_setopt($curl,CURLOPT_URL, $link);
curl_setopt($curl,CURLOPT_HTTPHEADER,['Content-Type:application/json']);
curl_setopt($curl,CURLOPT_HEADER, false);
curl_setopt($curl,CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
$out = curl_exec($curl); //Инициируем запрос к API и сохраняем ответ в переменную
$code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);
/** Теперь мы можем обработать ответ, полученный от сервера. Это пример. Вы можете обработать данные своим способом. */
$code = (int)$code;
$errors = [
	400 => 'Bad request',
	401 => 'Unauthorized',
	403 => 'Forbidden',
	404 => 'Not found',
	500 => 'Internal server error',
	502 => 'Bad gateway',
	503 => 'Service unavailable',
];

try
{
	/** Если код ответа не успешный - возвращаем сообщение об ошибке  */
	if ($code < 200 || $code > 204) {
		throw new Exception(isset($errors[$code]) ? $errors[$code] : 'Undefined error', $code);
	}
}
catch(\Exception $e)
{
	die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
}

/**
 * Данные получаем в формате JSON, поэтому, для получения читаемых данных,
 * нам придётся перевести ответ в формат, понятный PHP
 */
$response = json_decode($out, true);
file_put_contents('auth_key.json', $out);

$access_token = $response['access_token']; //Access токен
$refresh_token = $response['refresh_token']; //Refresh токен
$token_type = $response['token_type']; //Тип токена
$expires_in = $response['expires_in']; //Через сколько действие токена истекает