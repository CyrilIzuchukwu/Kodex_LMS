<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/css/poppins.css') }}" />

    <!-- <link href="./output.css" rel="stylesheet" /> -->

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>signin</title>
</head>

<body class="m-0 p-0 box-border font-poppins">
    <div class=" my-30 lg:my-10 py-2 flex flex-col lg:flex-row items-center justify-center">
        <div class="flex flex-col lg:flex-row justify-center lg:flex-wrap items-center h-[100%] w-[100%] px-10">
            <div class="lg:w-[50%] flex justify-center">
                <img class=" lg:max-w-svw" src="{{ asset('assets/auth/main-auth-banner.png') }}"
                    alt="Side Image" />
            </div>

            <div class="flex flex-col items-center lg:w-[50%] gap-y-10">
                <div>
                    <div class="flex justify-center">
                        <img class="w-[110px]" src="{{ asset('assets/auth/Kodex-logo.png') }}" alt="logo" />
                    </div>

                    <div class="text-center mt-10">
                        <p class="font-[500]">Log in to your account</p>
                        <p class="text-[#767676]">Welcome back! Please enter your details.</p>
                    </div>

                    <form class="flex flex-col space-y-2 mt-6 " action="">
                        <label class="text-[#767676]" for="email" value="email">Email</label>
                        <input class="border-0 border-b-2 border-gray-700 focus:border-orange-500 focus:outline-none focus:ring-0 transition-all duration-300 w-[80vw] lg:w-[30vw] py-2 px-2" type="text"
                            placeholder="enter your e-mail" /><br>

                        <label class="text-[#767676]" for="Password" value="Password">Password</label>
                        <div class="relative w-[100%]">
                            <input class="border-0 border-b-2 border-gray-700 focus:border-orange-500 focus:outline-none focus:ring-0 transition-all duration-300 w-[80vw] lg:w-[30vw] py-2 px-2" type="password"
                                placeholder="enter your password" />
                            <span class="absolute right-12 top-3 text-[#767676]">
                                <i class="ri-eye-off-line mr-2 cursor-pointer absolute hidden"></i>
                                <i class="ri-eye-line cursor-pointer absolute"></i>
                            </span>
                        </div>

                        <br />

                        <div class="flex justify-between">
                            <span class="text-[14px] text-[#767676] cursor-pointer"><input type="checkbox" class="border-[#767676] border-2 focus:border-orange-500 focus:outline-none focus:ring-0 transition-all duration-300" value="remember me" name="rmembrMe"
                                    id="rmembrMe"> Remember me</span>
                            <p class="text-[#E68815] hover:text-gray-900  hover:transition-all duration-300 "><a href="../auth/forgotPassword.blade.php ">Forgot Password?</a></p>
                        </div>
                    </form>
                </div>



                <div class="flex flex-col items-center gap-1">
                    <button
                        class="border border-[#E68815] rounded-[50px] py-2 bg-[#E68815] w-[70vw] lg:w-[20vw] text-white cursor-pointer before:ease relative h-12 overflow-hidden before:absolute before:left-0 before:-ml-2 before:h-48 before:w-[70vw] before:origin-top-right before:-translate-x-full before:translate-y-12 before:-rotate-90 before:bg-gray-900 before:transition-all before:duration-300 hover:text-white hover:before:-rotate-180"><span class="relative z-10">Login</span>
                    <button
                        class="border-0 rounded-[50px] flex py-2 w-[0vw] place-content-center items-center bg-[#dfdddd] lg:w-[20vw] gap-x-3 cursor-pointer hover:before:bg-redborder-red-500 relative h-[50px] overflow-hidden px-3 transition-all before:absolute before:bottom-0 before:left-0 before:top-0 before:z-0 before:h-full before:w-0 before:bg-gray-900 before:transition-all before:duration-500 hover:text-white  hover:before:left-0 hover:before:w-full hover:animate-bounce"><span class="relative z-10 flex justify-center items-center gap-x-2"><img class="h-4 " src="{{ asset('assets/auth/logo-google.png') }}" alt="google" />Continue with
                        Google</span>
                    </button>
                </div>

                <div>
                    <p>
                        Don't have an account? <span class="text-[#E68815] hover:text-gray-900  hover:transition-all duration-300"><a href="">Sign up</a></span>
                    </p>
                </div>

            </div>
        </div>
    </div>

    <script>
        const eyeIcon = document.querySelector('.ri-eye-line');
        const eyeOffIcon = document.querySelector('.ri-eye-off-line');
        const passwordInput = document.querySelector('input[type="password"]');

        eyeIcon.addEventListener('click', () => {
            passwordInput.type = 'text';
            eyeIcon.classList.add('hidden');
            eyeOffIcon.classList.remove('hidden');
        });

        eyeOffIcon.addEventListener('click', () => {
            passwordInput.type = 'password';
            eyeOffIcon.classList.add('hidden');
            eyeIcon.classList.remove('hidden');
        });

        const rememberMeCheckbox = document.getElementById('rmembrMe');
        rememberMeCheckbox.addEventListener('change', () => {
            if (rememberMeCheckbox.checked) {
                console.log('Remember me checked');
            } else {
                console.log('Remember me unchecked');
            }
        });

    </script>
</body>

</html>

    </script>
</body>

</html>
