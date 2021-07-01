<?php
if(!function_exists('moneyFormat')){
    function moneyFormat($number){
        $number = round($number, 0);
        return number_format( $number,0,'.',',');
    }
}

if(!function_exists('moneyRoundAndFormat')){
    function percentage($firstNumber, $secondNumber){
        if($secondNumber == 0) return 0;
        return round($firstNumber / $secondNumber * 100,0);
    }
}

if(!function_exists('getFormatSummaryReportDate')){
    function getFormatSummaryReportDate($date){
        if($date) {
            $date = explode('-', request('date'));
            return \Carbon\Carbon::parse($date[1].'-'.$date[0])->format('F Y');
        }
        return \Carbon\Carbon::now()->format('F Y');
    }
}

