<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function getNextDate($date) {
    return strtotime('+1 month', $date);
}

function getPreviousDate($date) {
    return strtotime('-1 month', $date);
}

function getMonthAndYearString($date) {
    return date(("F"), $date) . " " . date(("Y"), $date);
}

function isCurrentDay($day, $month, $year) {
    if ($day == intval(date("d")) && $month == intval(date("m")) && $year == intval(date("Y"))) {
        return true;
    } else {
        return false;
    }
}

function getCalendarRows($date) {
    //Get year and month from the date.
    $year = date("Y", $date);
    $month = date("m", $date);
    //Get the first day in the month timestamp.
    $firstDayTimeStamp = mktime(0, 0, 0, $month, 1, $year);
    $firstDay = date("d", $firstDayTimeStamp);
    //Get number of days in the month (28-31).
    $numberOfdays = intval(date("t", $firstDayTimeStamp));
    //Get index of the first day meaning which day it is (1-7).
    $indexOfFirstDay = intval(date("N", $firstDayTimeStamp));
    $day = intval($firstDay);
    $calendar = "<tr>";
    //------------------------------------------------------------------
    //Write blanks for the first days until indexOfFirstDay.
    for ($r = 1; $r < $indexOfFirstDay; $r++) {
        //CELL DATA
        $calendar .= "<td>";
        $calendar .= "&nbsp;";
        $calendar .= "</td>";
    }
    //Write the rest of days starting from where previous for ended.
    for ($rem = $r; $rem <= 7; $rem++) {
        //CELL DATA
        if (isCurrentDay($day, $month, $year)) {
            $calendar .= "<td class='danger'>";
        } else {
            $calendar .= "<td>";
        }
        $calendar .= $day++;
        $calendar .= "</td>";
    }
    $calendar .= "</tr>";
    $calendar .= "<tr>";
    //------------------------------------------------------------------
    //Write middle rows.
    for ($r = 1; $r <= 4; $r++) {
        for ($c = 1; $c <= 7; $c++) {
            //If the end of month is reached, write blank.
            if ($day != $numberOfdays + 1) {
                //CELL DATA
                if (isCurrentDay($day, $month, $year)) {
                    $calendar .= "<td class='danger'>";
                } else {
                    $calendar .= "<td>";
                }
                $calendar .= $day++;
                $calendar .= "</td>";
            } else {
                //CELL DATA
                $calendar .= "<td>";
                $calendar .= "&nbsp;";
                $calendar .= "</td>";
            }
        }
        $calendar .= "</tr>";
    }
    //------------------------------------------------------------------
    //Write last row of days.
    $calendar .= "<tr>";
    for ($r = 1; $r <= 7; $r++) {
        //
        if ($day != $numberOfdays + 1) {
            //CELL DATA
            if (isCurrentDay($day, $month, $year)) {
                $calendar .= "<td class='danger'>";
            } else {
                $calendar .= "<td>";
            }
            $calendar .= $day++;
            $calendar .= "</td>";
        } else {
            //CELL DATA
            $calendar .= "<td>";
            $calendar .= "&nbsp;";
            $calendar .= "</td>";
        }
    }
    $calendar .= "</tr>";
    //------------------------------------------------------------------

    return $calendar;
}
