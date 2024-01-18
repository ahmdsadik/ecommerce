<x-front title="Login">


    <x-slot:breadcrumb>
        <!-- Start Breadcrumbs -->
        <div class="breadcrumbs">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 col-md-6 col-12">
                        <div class="breadcrumbs-content">
                            <h1 class="page-title">Login</h1>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-12">
                        <ul class="breadcrumb-nav">
                            <li><a href="index.html"><i class="lni lni-home"></i> Home</a></li>
                            <li>Login</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Breadcrumbs -->
    </x-slot:breadcrumb>


    <!-- Start Account Login Area -->
    <div class="account-login section">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 offset-lg-3 col-md-10 offset-md-1 col-12">
                    <form class="card login-form" method="post">
                        <div class="card-body">
                            <x-session-msg key="error" />
                            <div class="title">
                                <h3>Login Now</h3>
                                <p>You can login using your social media account or email address.</p>
                            </div>
                            <div class="social-login">
                                <div class="row">
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <a class="btn facebook-btn" href="{{ route('front.social.login','facebook') }}"><i class="lni lni-facebook-filled"></i> Facebook
                                            login</a></div>
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <a class="btn twitter-btn" href="{{ route('front.social.login','twitter') }}"><i class="lni lni-twitter-original"></i> Twitter
                                            login</a></div>
                                    <div class="col-lg-4 col-md-4 col-12">
                                        <a class="btn google-btn" href="{{ route('front.social.login','google') }}"><i class="lni lni-google"></i> Google login</a>
                                    </div>
                                </div>
                            </div>
                            <div class="alt-option">
                                <span>Or</span>
                            </div>
                            <form action="{{ route('login') }}" method="post">
                                @csrf
                                <div class="form-group input-group">
                                    <label for="check">Email/username/phone_number</label>
                                    <input class="form-control" name="check" type="text" id="check" required>
                                    <x-input-error key="check" />
                                </div>
                                <div class="form-group input-group">
                                    <label for="reg-pass">Password</label>
                                    <input class="form-control" name="password" type="password" id="reg-pass" required>
                                </div>
                                <div class="d-flex flex-wrap justify-content-between bottom-content">
                                    <div class="form-check">
                                        <label class="form-check-label">
                                        <input type="checkbox" name="remember" class="form-check-input width-auto" id="exampleCheck1">
                                        Remember me</label>
                                    </div>
                                    <a class="lost-pass" href="account-password-recovery.html">Forgot password?</a>
                                </div>
                                <div class="button">
                                    <button class="btn" type="submit">Login</button>
                                </div>
                            </form>
                            <p class="outer-link">Don't have an account? <a href="{{route('register')}}">Register here </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- End Account Login Area -->


</x-front>
