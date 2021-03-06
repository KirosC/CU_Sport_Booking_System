<div class="container-fluid">
    <div class="row">
        <!--    Login form    -->
        <div class="container-login100">
            <div class="wrap-login100 col-md-8 col-lg-4 col-xl-4">
                <form class="login100-form validate-form" id="login-form"
                      action='<?php echo $page_url; ?>login/login_check' method='post'>
					<span class="login100-form-title p-b-26">
						Welcome
					</span>
                    <div class="wrap-input100 validate-input" data-validate="Enter username">
                        <input class="input100" type="text" name="user_name">
                        <span class="focus-input100" data-placeholder="Username"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Enter password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
                        <input class="input100" type="password" name="password">
                        <span class="focus-input100" data-placeholder="Password"></span>
                    </div>

                    <div class="container-login100-form-btn">
                        <div class="wrap-login100-form-btn">
                            <div class="login100-form-bgbtn"></div>
                            <button class="login100-form-btn" form="login-form">
                                Login
                            </button>
                        </div>
                    </div>

                    <div class="text-center p-t-90">
                        <span class="txt1">
							Can't login?
						</span>
                        <a class="txt2" href="<?php echo $page_url; ?>login/forgot_main">
                            Forgot Password
                        </a>
                    </div>

                    <div class="text-center p-t-10">
						<span class="txt1">
							Don’t have an account?
						</span>
                        <a class="txt2" href="<?php echo $page_url; ?>login/register_main">
                            Sign Up
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>