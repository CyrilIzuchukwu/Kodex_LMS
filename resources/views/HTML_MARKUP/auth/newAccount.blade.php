<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('assets/css/poppins.css') }}" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <title>Create Your Account</title>
</head>

<body class="m-0 p-0 box-border font-poppins">
    <div class="my-30 lg:my-10 py-2  flex flex-col lg:flex-row items-center justify-center ">
        <div class="flex flex-col lg:flex-row justify-center lg:flex-wrap items-center h-[100%] w-[100%] px-10">
            <div class="lg:w-[50%] flex justify-center">
                <img class=" lg:max-w-svw " src="{{ asset('assets/auth/main-auth-banner.png') }}"
                    alt="pic" />
            </div>

            <div class="flex flex-col items-center lg:w-[50%] ">
                <div class="flex flex-col ">
                    <div class="flex flex-col justify-center items-center">
                        <img class="w-[110px]" src="{{ asset('assets/auth/Kodex-logo.png') }}" alt="logo" />
                        <img class="w-[80px] mt-10" src="{{ asset('assets/auth/person.png') }}" alt="person">
                    </div>

                    <div class="text-center ">
                        <p class="text-[#1B1B1B] text-[18px] font-[500]">Create Your Account</p>
                        <p class="text-[#767676]">Set a password and tell us a bit about yourself.</p>
                    </div>

                    <form class="flex flex-col gap-y-5 mt-6 justify-center" action="">

                        <div class="flex flex-col">
                            <label class="text-[#767676]" for="name" value="name">Full Name</label>
                            <input
                                class="border-0 border-b-2 border-gray-700 focus:border-orange-500 focus:outline-none focus:ring-0 transition-all duration-300 w-[80vw] lg:w-[30vw] py-2 px-2"
                                type="text" placeholder="Enter your full-name" />
                        </div>

                        <div>
                            <label class="text-[#767676]" for="password" value="password">Create Password</label>
                            <div class="relative w-[100%]">
                                <input
                                    class="border-0 border-b-2 border-gray-700 focus:border-orange-500 focus:outline-none focus:ring-0 transition-all duration-300 w-[80vw] lg:w-[30vw] py-2 px-2"
                                    type="password" id="password" placeholder="Enter your password" />
                                <span class="absolute right-12 top-3 text-[#767676]">
                                    <i class="ri-eye-off-line mr-2 cursor-pointer absolute hidden" id="eyeclose"></i>
                                    <i class="ri-eye-line cursor-pointer absolute" id="eyeopen"></i>
                                </span>
                            </div>
                        </div>


                        <div>
                            <label class="text-[#767676]" for="Password" value="Password">Confirm Password</label>
                            <div class="relative w-[100%]">
                                <input
                                    class="border-0 border-b-2 border-gray-700 focus:border-orange-500 focus:outline-none focus:ring-0 transition-all duration-300 w-[80vw] lg:w-[30vw] py-2 px-2"
                                    type="password" id="confirmPassword" placeholder="Confirm your new password" />
                                <span class="absolute right-12 top-3 text-[#767676]">
                                    <i class="ri-eye-off-line mr-2 cursor-pointer absolute hidden" id="eyeclose1"></i>
                                    <i class="ri-eye-line cursor-pointer absolute" id="eyeopen1"></i>
                                </span>
                            </div>
                        </div>

                    </form>
                </div>



                <div class="flex flex-col items-center my-10">
                    <div x-data="{ open: false }">

                        <!-- Modal Trigger Button -->
                        <button @click="open = true"
                            class="border border-[#E68815] rounded-[50px] py-2 bg-[#E68815] w-[70vw] lg:w-[20vw] text-white cursor-pointer before:ease relative h-12 overflow-hidden before:absolute before:left-0 before:-ml-2 before:h-48 before:w-[70vw] before:origin-top-right before:-translate-x-full before:translate-y-12 before:-rotate-90 before:bg-gray-900 before:transition-all before:duration-300 hover:text-white hover:before:-rotate-180"><span
                                class="relative z-10">Create Account</span>
                        </button>

                        <!-- Modal -->
                        <div x-show="open"
                            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

                            <div @click.away="open = false"
                                class="bg-white rounded-[30px] shadow-lg p-4 lg:p-6 lg:w-[34.72vw] flex flex-col items-center text-center gap-y-5 h-auto lg:h-[34.72vw] relative overflow-hidden">

                                <!-- 🍻 Animated Party Beer GIF -->
                                <img src="{{ asset('assets/auth/party-beer.png') }}" alt="Party"
                                    class="absolute top-[-40px] right-[-40px] w-24 h-24 animate-bounce z-0 opacity-90 pointer-events-none" />

                                <!-- 🌟 Modal Content -->
                                <div class="z-10">
                                    <img src="{{ asset('assets/auth/good.png') }}" alt="good">
                                </div>
                                <div class="mb-5 z-10">
                                    <h2 class="text-xl font-[500]">Welcome Aboard!</h2>
                                    <p class="text-[#767676]">Your account has been created. Start exploring courses and
                                        learning!</p>
                                </div>
                                <div class="z-10">
                                    <button @click="open = false"
                                        class="border border-[#E68815] rounded-[50px] py-2 bg-[#E68815] w-[70vw] lg:w-[20vw] text-white cursor-pointer relative h-[50px] overflow-hidden px-3 transition-all before:absolute before:bottom-0 before:left-0 before:top-0 before:z-0 before:h-full before:w-0 before:bg-gray-900 before:transition-all before:duration-500 hover:text-white hover:before:left-0 hover:before:w-full hover:animate-bounce">
                                        <span class="relative z-10">Start Learning</span>
                                    </button>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

                <div class="flex gap-2">
                    <div class="bg-[#E68815] h-0.5 w-20"></div>
                    <div class="bg-[#E68815] h-0.5 w-20"></div>
                    <div class="bg-[#E68815] h-0.5 w-20"></div>
                </div>

            </div>
        </div>
    </div>


    <script>
    document.addEventListener('click', function() {
        const eyeIcon = document.getElementById('eyeopen');
        const eyeOffIcon = document.getElementById('eyeclose');
        const passwordInput = document.getElementById('password');

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
    });



    document.addEventListener('click', function() {
        const eyeIcon1 = document.getElementById('eyeopen1');
        const eyeOffIcon1 = document.getElementById('eyeclose1');
        const passwordInput1 = document.getElementById('confirmPassword');

        eyeIcon1.addEventListener('click', () => {
            passwordInput1.type = 'text';
            eyeIcon1.classList.add('hidden');
            eyeOffIcon1.classList.remove('hidden');
        });

        eyeOffIcon1.addEventListener('click', () => {
            passwordInput1.type = 'password';
            eyeOffIcon1.classList.add('hidden');
            eyeIcon1.classList.remove('hidden');
        });
    })
    </script>
</body>

</html>