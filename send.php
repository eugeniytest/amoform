<?php

date_default_timezone_set('UTC');

$accesToken = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . '/settings/auth_key.json'), true);
$accesToken = $accesToken['access_token'];

$data = [
   0 => [
      "name" => "Заявка из тестовой формы",
      "price" => 0,
      "_embedded" => [
         "contacts" => [
            0 => [
               "first_name" => $_POST['name'],
               "created_at" => time(),
               "responsible_user_id" => 7159429,
               "updated_by" => 0,
               "custom_fields_values" => [
                  0 => [
                     "field_id" => 301357,
                     "values" => [
                        0 => [
                           "enum_id" => 156355,
                           "value" => $_POST['email']
                        ]
                     ]
                  ],
                  1 => [
                     "field_id" => 301355,
                     "values" => [
                        0 => [
                           "enum_id" => 156345,
                           "value" => $_POST['phone']
                        ]
                     ]
                  ]
               ]
            ]
         ]
      ],
      "created_at" => time(),
      "responsible_user_id" => 7159429,
      "status_id" => 40729630,
      "pipeline_id" => 4379053,
      "request_id" => "qweasd"
   ]
];

$subdomain = 'perecovperec123';
$link = 'https://' . $subdomain . '.amocrm.ru/api/v4/leads/complex';

$headers = [
	'Authorization: Bearer ' . $accesToken
];

$curl = curl_init(); //Сохраняем дескриптор сеанса cURL
/** Устанавливаем необходимые опции для сеанса cURL  */
curl_setopt($curl,CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl,CURLOPT_USERAGENT,'amoCRM-oAuth-client/1.0');
curl_setopt($curl,CURLOPT_URL, $link);
curl_setopt($curl,CURLOPT_HTTPHEADER, $headers);
curl_setopt($curl,CURLOPT_HEADER, false);
curl_setopt($curl,CURLOPT_SSL_VERIFYPEER, 1);
curl_setopt($curl,CURLOPT_SSL_VERIFYHOST, 2);
curl_setopt($curl,CURLOPT_POSTFIELDS, json_encode($data));
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
	
	echo('ok');
}
catch(\Exception $e)
{
	die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
}

