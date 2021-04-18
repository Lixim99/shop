<!--
Регулярные выражения!
. - любой одиночный символ
[ ] - любой из них, диапазоны
$ - конец строки
^ - начало строки
\ - экранирование
\d - любую цифру
\D - все что угодно, кроме цифр
\s - пробелы
\S - все кроме пробелов
\w - буква
\W - все кроме букв
\b - граница слова
\B - не границ

Квантификация
n{4} - искать n подряд 4 раза
n{4,6} - искать n от 4 до 6
* от нуля и выше {0,}
+ от 1 и выше {1,}
? - 0 или 1 раз
https://regex101.com/
-->
<?php
$html = <<<HEREDOC
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <a datatype="" href="href1" type=""></a>
    <a datatype="" href='href2' type=""></a>
    <a datatype=""  type="" href="href3"></a>
    <a datatype="" href='href4' type=""></a>
    <a href="href5" datatype=""  type=""></a>
</body>
</html>
HEREDOC;

$ref = '/cn/other/page/blue';

$str = 'Lorem ipsum dolor sit amet, 234 consectetur adipiscing elit. Praesent molestie imperdiet nunc 
        rutrum imperdiet. Nam efficitur 54justo accumsan magna tempus ullamcorper. 
        Aenean nibh felis, maximus varius efficitur ornare, pharetra vitae justo. Aliquam fringilla lobortis elit 
        non convallis. Nullam vulputate turpis porta risus sagittis, vel dignissim metus laoreet. 
        Aliquam sodales eu velit at volutpat. Nunc blandit odio in laoreet sagittis.';
$rusStr = 'Какая-то строка';

$rs = preg_match_all('/\d+/', $str, $matches);
$rs1 = preg_match('/.+?\s+/', $str, $matches);
$rs2 = preg_match_all('/.+\s+/U', $str, $matches);
$rs3 = preg_match_all('/[а-яА-я]+/u', $rusStr, $matches);
$rs4 = preg_match_all('/[а-я]+/ui', $rusStr, $matches);
$rs5 = preg_match_all('/^.+$/uim', $str, $matches);

$rs6 = preg_match_all('/<a\s+[^>]*?href\s*=\s*([\'"])([^>]+?)\1/', $html, $matches);

$rs7 = preg_match_all('/\/(?!page)[^\/]+/', $ref, $matches);

echo '<pre>';
var_dump($rs7);
var_dump($matches);
echo '</pre>';