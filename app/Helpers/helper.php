<?php

use Illuminate\Support\Facades\Cookie;
use Carbon\Carbon;

function createCookie($name, $value, $expire)
{
  Cookie::queue($name, $value, $expire);
}

function returnCookie($name)
{
  return Cookie::get($name);
}

function deleteCookie($name)
{
  Cookie::queue(Cookie::forget($name));
}

function normalizeText($text)
{
  $arrayForSearch = array(
    " De ",
    " Do ",
    " Da ",
    " Das ",
    " E ",
    " A ",
    " O ",
    "- "
  );

  $arrayReplaceWith = array(
    " de ",
    " do ",
    " da ",
    " das ",
    " e ",
    " a ",
    " 0 ",
    " - "
  );

  $text = ucwords(mb_strtolower($text));
  $text = mb_convert_case($text, MB_CASE_TITLE, "UTF-8");
  $text = str_replace($arrayForSearch, $arrayReplaceWith, $text);

  return $text;
}

function normalizeDescription($text)
{
  $text = explode(". ", strtolower($text));
  $convertedText = "";

  $numItems = count($text);
  $i = 0;

  foreach ($text as $key => $value) {
    $value = mb_convert_case($value, MB_CASE_TITLE, "UTF-8");

    if (++$i === $numItems) {
      $convertedText = $convertedText . ucfirst(mb_strtolower($value));
    } else {
      $convertedText = $convertedText . ucfirst(mb_strtolower($value)) . ". ";
    }
  }

  return $convertedText;
}

function formatCnpjCpf($value)
{
  $CPF_LENGTH = 11;
  $cnpj_cpf = preg_replace("/\D/", '', $value);

  if (strlen($cnpj_cpf) === $CPF_LENGTH) {
    return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
  }

  return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
}

function right($value, $count)
{
  return substr($value, ($count * -1));
}

function getKey($id, $validate)
{
  $db = new DatabaseQueries();
  $result = $db->keyDetails($id);

  foreach ($result as $row) {
    return generateKey($row->serial, $validate);
  }
}

function generateKey($key, $validate)
{
  $numero_serial_novo = "";
  $tx_data_validacao = date('d/m/Y');
  $data_validacao_vetor = explode("/", $tx_data_validacao);
  $dia = $data_validacao_vetor[0];
  $mes = $data_validacao_vetor[1];
  $ano = $data_validacao_vetor[2];
  $num_hd = $key;

  for ($i = 1; $i <= 6; $i++) {
    $numero_serial = substr($num_hd, $i - 1, 1);

    if (is_numeric($numero_serial)) {
      if ($i == 1) {
        $numero_serial = right(($numero_serial * 3) * $dia, 1);
      } else if ($i == 2) {
        $numero_serial = right(($numero_serial * 17) * $mes, 1);
      } else if ($i == 3) {
        $numero_serial = right(($numero_serial * 75) * $dia, 1);
      } else if ($i == 4) {
        $numero_serial = right(($numero_serial * 13) * $ano, 1) . "-";
      } else if ($i == 5) {
        $numero_serial = right(($numero_serial * 8) * $ano, 1);
      } else if ($i == 6) {
        $numero_serial = right(($numero_serial * 4) * $dia, 1);
      }
    } else {
      if ($i == 1) {
        $numero_serial = "Y";
      } else if ($i == 2) {
        $numero_serial = "J";
      } else if ($i == 3) {
        $numero_serial = "R";
      } else if ($i == 4) {
        $numero_serial = "X";
      } else if ($i == 5) {
        $numero_serial = "W";
      } else if ($i == 6) {
        $numero_serial = "K";
      }
    }

    $numero_serial_novo = $numero_serial_novo . $numero_serial;
  }

  $tx_data_validacao = $validate;
  $data_validacao_vetor = explode("-", $tx_data_validacao);
  $dia = $data_validacao_vetor[2];
  $mes = $data_validacao_vetor[1];
  $ano = $data_validacao_vetor[0];
  $num_serie = $numero_serial_novo . right($ano + 17, 2) . "-" . ($mes + 24) . ($dia + 11);

  return $num_serie;
}

function moneyFormat($amount)
{
  return number_format($amount, 2, ',', '.');
}

function dateFormat($date)
{
  return date('d/m/Y', strtotime($date));
}

function dateFullFormat($date)
{
  return date('d/m/Y H:i:s', strtotime($date));
}

function dateFormatISO($date)
{
  $date = explode(' ', $date)[0];
  $date = explode('/', $date);

  return $date[2] . '-' . $date[1] . '-' . $date[0];
}

function format_time($t, $f = ':')
{
  return sprintf("%02d%s%02d%s", floor($t / 3600), 'h', ($t / 60) % 60, 'min');
}

function somenteNumeros($texto)
{
  return preg_replace("/[^0-9]/", "", $texto);
}

function addDaysToDate($date, $days)
{
  $date = Carbon::parse($date);
  return $date->addDays($days);
}

function formatPhoneNumber($number)
{
  $number = preg_replace('/[^0-9]/', '', $number);

  if (strlen($number) == 10) {
    $formattedNumber = '(' . substr($number, 0, 2) . ') ' . substr($number, 2, 4) . '-' . substr($number, 6, 4);
  } elseif (strlen($number) == 11) {
    $formattedNumber = '(' . substr($number, 0, 2) . ') ' . substr($number, 2, 5) . '-' . substr($number, 7, 4);
  } else {
    $formattedNumber = $number;
  }

  return $formattedNumber;
}

function whatTypeItIs($type)
{
  if (1 === $type) return ['name' => 'Cliente', 'color' => '#cbd5e1'];
  if (2 === $type) return ['name' => 'Instalação', 'color' => '#dc2626'];
  if (3 === $type) return ['name' => 'Negociação', 'color' => '#22c55e'];
  if (4 === $type) return ['name' => 'Apresentação', 'color' => '#2563eb'];
  if (5 === $type) return ['name' => 'Prospect', 'color' => '#7c3aed'];
  if (6 === $type) return ['name' => 'Cadastro', 'color' => '#f59e0b'];

  return ['name' => '', 'color' => ''];
}

function normalizeProduct($name)
{
  if ('iaut' === strtolower($name)) return 'iAut';
  if ('icar' === strtolower($name)) return 'iCar';
  if ('iodo' === strtolower($name)) return 'iOdo';
  if ('icli' === strtolower($name)) return 'iCli';
  if ('item' === strtolower($name)) return 'iTem';
  if ('iges' === strtolower($name)) return 'iGes';
}

function whatProductItIs($product)
{
  if ('iaut' === strtolower($product)) return 'iAut';
  if ('icar' === strtolower($product)) return 'iCar';
  if ('iodo' === strtolower($product)) return 'iOdo';
  if ('icli' === strtolower($product)) return 'iCli';
  if ('item' === strtolower($product)) return 'iTem';
  if ('iges' === strtolower($product)) return 'iGes';

  return '';
}

function removeNumbersSpecialChar($text)
{
  $cleanedText = preg_replace('/[^a-zA-ZÀ-ú\s]/u', '', $text);
  return $cleanedText;
}

function formatZipCode($zipcode)
{
  $zipcode = preg_replace("/[^0-9]/", "", $zipcode);

  if (strlen($zipcode) === 8) {
    $zipcode = substr($zipcode, 0, 5) . '-' . substr($zipcode, 5, 3);
  }

  return $zipcode;
}

function extrairMesPorExtenso($data)
{
  $meses = array(
    1 => 'Janeiro',
    2 => 'Fevereiro',
    3 => 'Março',
    4 => 'Abril',
    5 => 'Maio',
    6 => 'Junho',
    7 => 'Julho',
    8 => 'Agosto',
    9 => 'Setembro',
    10 => 'Outubro',
    11 => 'Novembro',
    12 => 'Dezembro'
  );

  $mes = date('n', strtotime($data));

  if (isset($meses[$mes])) {
    return $meses[$mes];
  } else {
    return false;
  }
}

function formatText($text)
{
  $arraySearch  = array(' De ', ' Do ', ' Da ', ' E ', ' A ', ' O ', '- ');
  $arrayReplace = array(' de ', ' do ', ' da ', ' e ', ' a ', ' o ', ' - ');
  $text = ucwords(mb_strtolower($text));
  $text = mb_convert_case($text, MB_CASE_TITLE, 'UTF-8');
  $text = str_replace($arraySearch, $arrayReplace, $text);

  return $text;
}

function formatDescription($text)
{
  $convertedText = "";
  $text = strtolower($text);
  $text = explode(". ", $text);

  $numItems = count($text);
  $i = 0;

  foreach ($text as $key => $value) {
    $value = mb_convert_case($value, MB_CASE_TITLE, "UTF-8");

    if (++$i === $numItems) {
      $convertedText = $convertedText . ucfirst(mb_strtolower($value));
    } else {
      $convertedText = $convertedText . ucfirst(mb_strtolower($value)) . ". ";
    }
  }

  return $convertedText;
}

function extractNumber($number)
{
  return preg_replace('/[^0-9]/', '', $number);
}

function convertToNumber($string)
{
  return intval($string);
}

function convertToString($string)
{
  return strval($string);
}

function setCookies($name, $value)
{
  Cookie::queue($name, $value, 250000);
}

function getCookies($name)
{
  return request()->cookie($name);
}
