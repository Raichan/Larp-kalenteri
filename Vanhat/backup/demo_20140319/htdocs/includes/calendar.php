<table class="table table-hover table-bordered">
    <thead>
        <tr class="active">
            <th>
                MON
            </th>
            <th>
                TUE
            </th>
            <th>
                WED
            </th>
            <th>
                THU
            </th>
            <th>
                FRI
            </th>
            <th>
                SAT
            </th>
            <th>
                SUN
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