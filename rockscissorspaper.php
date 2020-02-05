<?php

define('STONE',0);
define('SCISSORS',1);
define('PAPER',2);

define('HAND',array(
    STONE =>  'グー',
    SCISSORS => 'チョキ',
    PAPER => 'パー'
));

define('ANSWER_YES','はい');
define('ANSWER_NO','いいえ');

define('DROW',0);
define('LOOSE',1);
define('WIN',2);

// ジャンケンゲーム
jankenGame();
function jankenGame(){
    echo "ジャンケンしよう！ \n";
    echo "グー、チョキ、パーいずれかを入力してね！ \n";
    $myHand = inputCode();  
    $comHand = getComHand();
    
    $result = judge($myHand,$comHand);

    show($result,$myHand,$comHand);

    $retry = retry();
    if($retry === ANSWER_YES){
        return jankenGame();
    }else if($retry === ANSWER_NO){
        echo "ありがとうございました";
        exit;
    }
}

// 選んだ手を取得する
function inputCode() {
    $ans = trim(fgets(STDIN));
    $check = checkInputCode($ans);
    if($check === false){
        return inputCode();
    }
    $myHandNumber = array_search($ans,HAND);
    return $myHandNumber;
}

// 選んだ手のバリデーションチェック
function checkInputCode($ans){
    if($ans === '') {
        echo "値を入力してね！ \n";
        return false;
    }
    if(in_array($ans,HAND,true)===false) {
        echo "正しい値を入力してね！ \n";
        return false;
    }
    return true;
}

// コンピュータの手の取得
function getComHand(){
    $comHandNumber = array_rand(HAND);
    return $comHandNumber;
}

// 勝敗を決定する
function judge($myHand,$comHand){
    $resultNumber = ($myHand - $comHand + 3) % 3;
    switch($resultNumber){
        case DROW:
            return 0; //引き分け
            break;
        case LOOSE:
            return 1; //負け
            break;
        case WIN;
            return 2; //勝ち
            break;
    }
}

// 勝敗を表示する
function show($result,$myHand,$comHand) {
    if($result === 0){
        echo "あいこ！もう一度！";
        return jankenGame();
    }else if($result === 1) {
        echo "負け！ \n";
        echo "自分が選んだ手:".HAND[$myHand] ."\n";
        echo "コンピュータの手:".HAND[$comHand] ."\n";
    }else if($result === 2) {
        echo "勝ち！ \n";
        echo "自分が選んだ手:".HAND[$myHand] ."\n";
        echo "コンピュータの手:".HAND[$comHand] ."\n";
    }
}

// 再戦
function retry(){
    echo "もう一度やる？「はい」か「いいえ」で答えてね！";
    $ans = trim(fgets(STDIN));
    $check = checkRetryCode($ans);
    if($check === false){
        return retry();
    }
    return $check;
}

// 再戦するかどうかのバリデーションチェック
function checkRetryCode($ans) {
    if($ans === '') {
        echo "「はい」か「いいえ」を入力してね！ \n";
        return false;
    }
    if($ans !== ANSWER_YES && $ans !== ANSWER_NO) {
        echo "正しい値を入力してね！ \n";
        return false;
    }
    return $ans;
}        