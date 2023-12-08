<?php

include 'currency.php';

$kur = new TCMB_currency();

echo 'Default (ForexBuying) : ' . $kur->convert('TRY','USD',25) . '<br>';
echo 'BanknoteBuying : ' . $kur->convert('TRY','USD',25, 'BanknoteBuying') . '<br>';
echo 'BanknoteSelling : ' . $kur->convert('TRY','USD',25, 'BanknoteSelling') . '<br>';
echo 'ForexBuying : ' . $kur->convert('TRY','USD',25, 'ForexBuying') . '<br>';
echo 'ForexSelling : ' . $kur->convert('TRY','USD',25, 'ForexSelling');

echo 'Euro - USD' .$kur->convert('EUR','TRY',1) . '<br>';

// Tarih
echo $kur->getDatae();




?>
