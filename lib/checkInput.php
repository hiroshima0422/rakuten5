<?php
# 入力値に不正なデータがないかなどをチェックする関数です。
function checkInput($var)
{
  if (is_array($var)) {
    return array_map('checkInput', $var);
  } else {
# magic_quotes_gpcへの対策（magic_quotes_gpcがOnでもOffでも動作するようにしたい）を行ないます。
    if (get_magic_quotes_gpc()) {
      $var = stripslashes($var);
    }
# nullバイト攻撃対策（nullバイト攻撃とは？）
# nullバイトを含む制御文字が含まれていないかをチェックします（最大10000文字）。
    if (preg_match('/\A[\r\n\t[:^cntrl:]]{0,3000}\z/u', $var) == 0) {
      die('不正な入力です。');
    }
# 文字エンコードの確認（入力値の検証方法を知りたい）を行ないます。
    if (! mb_check_encoding($var, 'UTF-8')) {
      die('不正な入力です。');
    }
    return $var;
  }
}

