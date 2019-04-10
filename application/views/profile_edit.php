<div class="wrapper">
    <div class="form-wrapper m-4">
        <form class="card bg-light card-body mb-3 col-md-8 col-xl-6 m-auto"
              action='<?php echo $page_url; ?>profile/update_profile' method='post'>
            <fieldset>
                <div class="form-group text-center">
                    <img src="https://vignette.wikia.nocookie.net/uncyclopedia/images/0/03/200px-Super_Saiyan.jpg"
                         class="img-thumbnail m-auto" alt="profile pic">
                </div>
                <div class="row form-group">
                    <label class="col-md-4 col-xl-2 col-form-label">Icon</label>
                    <div class="col-md-8 col-xl-10 inputGroupContainer">
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="validatedCustomFile" name="icon"
                                   accept="image/jpeg">
                            <label class="custom-file-label" for="validatedCustomFile">Choose file...</label>
                            <div class="invalid-feedback">Only accept .JPG .JPEG</div>
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 col-xl-2 col-form-label">Full Name</label>
                    <div class="col-md-8 col-xl-10 inputGroupContainer">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i
                                            class="fa fa-user"></i></span>
                            </div>
                            <input id="first_name" name="first_name" placeholder="First Name" class="form-control"
                            ="true" value="<?php echo $user['db']->first_name; ?>" type="text">
                            <input id="last_name" name="last_name" placeholder="Last Name" class="form-control"
                            ="true" value="<?php echo $user['db']->last_name; ?>" type="text">
                        </div>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 col-xl-2 col-form-label">Password</label>
                    <div class="col-md-8 col-xl-10 inputGroupContainer">
                        <div class="input-group">
                            <div class="input-group-prepend"><span class="input-group-text"><i
                                            class="fa fa-eye-slash"></i></span>
                            </div>
                            <input type="password" name="password" id="password" class="form-control" value="" required>
                        </div>
                    </div>
                </div>
                <?php if ($user['usertype'] == 'student'): ?>
                    <div class="row form-group">
                        <label class="col-md-4 col-xl-2 col-form-label ">Interest</label>
                        <div class="col-md-8 col-xl-10 inputGroupContainer">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fa fa-soccer-ball-o"></i></span>
                                </div>
                                <input id="interest" name="interest" placeholder="What you like to do?"
                                       class="form-control" value="" type="text">
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 col-xl-2 col-form-label ">Birthday</label>
                        <div class="col-md-8 col-xl-10 inputGroupContainer">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fa fa-birthday-cake"></i></span>
                                </div>
                                <input id="birthday" name="birthday" class="form-control" type="text"
                                       value="<?php echo $user['db']->birthday; ?>"/>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <label class="col-md-4 col-xl-2 col-form-label ">Tel. Number</label>
                        <div class="col-md-8 col-xl-10 inputGroupContainer">
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i
                                                class="fa fa-phone"></i></span>
                                </div>
                                <input id="phoneNumber" name="phone" placeholder="Phone Number"
                                       class="form-control" value="" type="text">
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <div class="row form-group">
                    <label class="col-md-4 col-xl-2 col-form-label">Introduction</label>
                    <div class="col-md-8 col-xl-10 inputGroupContainer">
                    <textarea class="form-control" id="introduction" name="intro"
                              rows="3"><?php echo $user['db']->intro; ?></textarea>
                    </div>
                </div>
                <?php if ($user['usertype'] == 'coach'): ?>
                    <div class="row form-group">
                        <label class="col-md-4 col-xl-2 col-form-label">Experience</label>
                        <div class="col-md-8 col-xl-10 inputGroupContainer">
                        <textarea class="form-control" id="Experience" name="experience"
                                  rows="3"><?php echo $user['db']->experience; ?></textarea>
                        </div>
                    </div>
                <?php endif; ?>
            </fieldset>
            <button id="submit" type="submit" class="btn btn-primary">Save</button>
        </form>
    </div>
</div>

<script>
    $(function () {
        let birthday = moment($('#birthday').val(), 'YYYY-MM-DD');
        $('input[name="birthday"]').daterangepicker({
            startDate: birthday,
            singleDatePicker: true,
            showDropdowns: true,
            minYear: 1901,
            maxDate: moment().endOf('year').subtract(1, 'year').endOf('month')

        });
        $( "form" ).submit(function() {
            // Change format
            $('#birthday').val(moment($('#birthday').val(), 'MM/DD/YYYY').format('YYYY-MM-DD'));
        });
    });
</script>