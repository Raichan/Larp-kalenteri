<h3>
    Upcoming events
</h3>
<div class="row">

    <?php
    include (__DIR__ . "./../includes/data.php");
    /* Get events as an array. */
    $newEvents = getUpcomingEvents();
    /* Go through array and write each event as a thumbnail. */
    foreach ($newEvents as $event) {
        echo $event->getEventHTMLThumbnail();
    }
    ?>

</div>

<!--<div class="col-md-4">
    <div class="thumbnail">
        <img width="100" heigth="100" src="http://vt.tuned-cars.cz/download/file.php?avatar=61658_1370350849.png" class="img-circle" />
        <div class="caption">
            <h4>
                The best event ever
            </h4>
            <h5>
                14. 4. 2014, Helsinki
            </h5>
            <p>
                Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.
            </p>
            <p>
                <a class="btn btn-primary" href="#">See more</a>
            </p>
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="thumbnail">
        <img width="100" heigth="100" src="http://upload.wikimedia.org/wikipedia/commons/8/81/Wikimedia-logo.svg" class="img-circle" />
        <div class="caption">
            <h3>
                Thumbnail label
            </h3>
            <p>
                Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.
            </p>
            <p>
                <a class="btn btn-primary" href="#">Action</a> <a class="btn" href="#">Action</a>
            </p>
        </div>
    </div>
</div>
<div class="col-md-4">
    <div class="thumbnail">
        <img width="100" heigth="100" src="images/noimageCircle.png" class="img-circle" />
        <div class="caption">
            <h3>
                Thumbnail label
            </h3>
            <p>
                Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.
            </p>
            <p>
                <a class="btn btn-primary" href="#">Action</a> <a class="btn" href="#">Action</a>
            </p>
        </div>
    </div>
</div>-->
