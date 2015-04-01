<div class="col-md-6 column">
    <h3>
        <?php
        /* Echo for month and year. */
        echo (getMonthAndYearString($date));
        ?>
    </h3>
</div>
<div class="col-md-6 column" style="text-align: right">
    <ul class="pagination pagination-sm">
        <li>
            <a href="index.php?date=<?php echo $prevDate; ?>">&laquo; Prev</a>
        </li>
        <li>
            <a href="index.php"><b>Now</b></a>
        </li>
        <li>
            <a href="index.php?date=<?php echo $nextDate; ?>">Next &raquo;</a>
        </li>
    </ul>
</div>