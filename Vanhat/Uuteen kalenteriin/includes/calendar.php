<table class="table table-hover table-bordered">
    <thead>
        <tr class="active">
            <th>
                <?php echo $cal_mon; ?>
            </th>
            <th>
                <?php echo $cal_tue; ?>
            </th>
            <th>
                <?php echo $cal_wed; ?>
            </th>
            <th>
                <?php echo $cal_thu; ?>
            </th>
            <th>
                <?php echo $cal_fri; ?>
            </th>
            <th>
                <?php echo $cal_sat; ?>
            </th>
            <th>
                <?php echo $cal_sun; ?>
            </th>
        </tr>
    </thead>
    <tbody>
        <?php
        /* Echo for calendar table rows. */
        echo getCalendarRows($date);
        ?>
    </tbody>
</table>