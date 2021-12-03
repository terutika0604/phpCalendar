<?php

date_default_timezone_set('Asia/Tokyo');

// GETで受け取った年月を$ymにセット
if (isset($_GET['ym'])) {
  $ym = $_GET['ym'];
} else {
  // 今月の年月を表示
  $ym = date('Y-m');
}

$timestamp = strtotime($ym . '-01');
if ($timestamp === false) {
    $ym = date('Y-m');
    $timestamp = strtotime($ym . '-01');
}

$today = date('Y-m-j');

$prev = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)-1, 1, date('Y', $timestamp)));
$next = date('Y-m', mktime(0, 0, 0, date('m', $timestamp)+1, 1, date('Y', $timestamp)));

// 今月の日数
$day_count = date('t', $timestamp);

// 今月の1日の曜日、0が日曜
$youbi = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));


$weeks = [];
$week = '';

// 空セルを作る
$week .= str_repeat('<td></td>', $youbi);


// weeksを作る
for ( $day = 1; $day <= $day_count; $day++, $youbi++) {

  // todayを作る
  $date = $ym . '-' . $day;

  if ($today == $date) {
      $week .= '<td class="today">' . $day;
  } else {
      $week .= '<td>' . $day;
  }
  $week .= '</td>';

  // 週終わり、または、月終わりの場合
  if ($youbi % 7 == 6 || $day == $day_count) {

      if ($day == $day_count) {
          // 月の最終日の場合、空セルを追加
          $week .= str_repeat('<td></td>', 6 - $youbi % 7);
      }

      // weeks配列にtrと$weekを追加する
      $weeks[] = '<tr>' . $week . '</tr>';

      $week = '';
  }
}


?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>PHPカレンダー</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP&family=Oswald:wght@700&display=swap" rel="stylesheet">
    <style>
      .container {
            font-family: 'Noto Sans JP', sans-serif;
            margin-top: 80px;
        }
        a {
            text-decoration: none;
        }
        th {
            height: 30px;
            text-align: center;
        }
        td {
            height: 100px;
        }
        .today {
            background: orange !important;
            opacity: 0.8;
        }
        th:nth-of-type(1), td:nth-of-type(1) {
            color: red;
        }
        th:nth-of-type(7), td:nth-of-type(7) {
            color: blue;
        }
    </style>
</head>
<body>
    <div class="container">
        <h3 class="mb-5"><a href="?ym=<?php echo $prev; ?>">&lt;</a><?php echo date('Y年n月', $timestamp); ?><a href="?ym=<?php echo $next; ?>">&gt;</a></h3>
        <table class="table table-bordered">
            <tr>
                <th>日</th>
                <th>月</th>
                <th>火</th>
                <th>水</th>
                <th>木</th>
                <th>金</th>
                <th>土</th>
            </tr>
            <?php
                foreach ($weeks as $week) {
                    echo $week;
                }
            ?>
        </table>
    </div>
</body>
</html>