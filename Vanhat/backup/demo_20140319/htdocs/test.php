<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset = "UTF-8">
        <meta name = "viewport" content = "width=device-width">
    </head>
    <body>
        <?php

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
            $calendar = "<table>";
            $calendar .= "<tr>";
            //------------------------------------------------------------------
            //Write blanks for the first days until indexOfFirstDay.
            for ($r = 1; $r < $indexOfFirstDay; $r++) {
                $calendar .= "<td>";
                $calendar .= "</td>";
            }
            //Write the rest of days starting from where previous for ended.
            for ($rem = $r; $rem <= 7; $rem++) {
                $calendar .= "<td>";
                $calendar .= $day++ . " ";
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
                        $calendar .= "<td>";
                        $calendar .= $day++ . " ";
                        $calendar .= "</td>";
                    } else {
                        $calendar .= "<td>";
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
                    $calendar .= "<td>";
                    $calendar .= $day++ . " ";
                    $calendar .= "</td>";
                } else {
                    $calendar .= "<td>";
                    $calendar .= "</td>";
                }
            }
            $calendar .= "</tr>";
            //------------------------------------------------------------------
            $calendar .= "</table>";

            return $calendar;
        }

        $date = strtotime(date("Y-m"));
        getCalendarRows($date);
        ?>
    </body>
</html>
