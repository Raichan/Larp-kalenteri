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
            <a href="index.php?<?php echo "&eventId=" . $eventId; ?>"><b><?php echo $button_today; ?></b></a>
        </li>
    </ul>
    <ul class="pagination pagination-sm">
        <li>
            <a href="index.php?<?php echo "date=" . $prevDate . "&eventId=" . $eventId; ?>">&laquo; <?php echo $button_prev; ?></a>
        </li>
        <li>
            <a href="index.php?<?php echo "date=" . $nextDate . "&eventId=" . $eventId; ?>"><?php echo $button_next; ?> &raquo;</a>
        </li>
    </ul>
</div>