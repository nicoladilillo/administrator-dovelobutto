<?php

return array(
  'driver' => env('MAIL_DRIVER'),
  'host' => env('MAIL_HOST'),
  'port' => env('MAIL_PORT'),
  'from' => array('address' => 'dovelobutto@riciclo.com', 'name' => 'DoveLoButto'),
  'encryption' => env('MAIL_ENCRYPTION'),
  'username' => env('MAIL_USERNAME'),
  'password' => env('MAIL_PASSWORD'),
);
