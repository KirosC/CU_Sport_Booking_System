<form action='<?php echo $page_url; ?>court_booking/check_booking' method='post'>

    Select College:<br>
    <select name="college">
      <?php foreach ($colleges as $college) : ?>
        <option value="<?php echo $college->college_id; ?>"><?php echo $college->name; ?></option>
      <?php endforeach; ?>
    </select><br>

    Select Sport:<br>
    <select name="sport">
      <?php foreach ($sports as $sport) : ?>
        <option value="<?php echo $sport->sports_id; ?>"><?php echo $sport->name; ?></option>
      <?php endforeach; ?>
    </select><br>


    <br>//here is base on the chosen college and sport shown related venue<br>
    Select Venue:<br>
    <select name="venue">
      <?php foreach ($venues as $venue) : ?>
        <option value="<?php echo $venue->venue_id; ?>"><?php echo $venue->venue; ?></option>
      <?php endforeach; ?>
    </select><br>

    <br>//here is base on the chosen venue shown related session<br>
    Select Session:<br>
    <select name="session">
      <?php foreach ($sessions as $session) : ?>
        <option value="<?php echo $session->session_id; ?>"><?php echo $session->start_time." - ".$session->end_time; ?></option>
      <?php endforeach; ?>
    </select><br>

    Share this session?<br>
    <input type="radio" name="is_share" value="1"> Yes
    <input type="radio" name="is_share" value="0" checked> No<br>

    <br>//if is_share == 1 those below will show up<br>
    Available Seats:<br>
    <input type="number" name="seat"><br>

    Description:<br>
    <textarea rows="4" name="description"></textarea><br>

    <input type="submit">
</form>

<a href="<?php echo $page_url; ?>court_booking/test">test</a>