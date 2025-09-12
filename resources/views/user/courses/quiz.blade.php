@extends('layouts.user')
@section('content')
    <script src="https://cdn.tailwindcss.com"></script>
    <div class="px-2 lg:p-8">
        <div class="mx-auto">
            <!-- Header -->
            <div class="glass-effect rounded-2xl p-6 mb-8">
                <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <a href="{{ route('user.course.watch', [$course->slug, $currentModule->id]) }}" class="p-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 rounded-lg transition-colors">
                            <i class="mdi mdi-arrow-left text-xl"></i>
                        </a>

                        <div>
                            <h1 class="text-2xl lg:text-3xl font-bold text-gray-800">Module {{ $currentModuleIndex + 1 }} Quiz</h1>
                            <p class="text-gray-600">{{ $currentModule->title }}</p>
                        </div>
                    </div>

                    <!-- Quiz Progress -->
                    <div class="flex items-center gap-4 bg-white rounded-full px-6 py-3 shadow-lg">
                        <div class="text-center">
                            <p class="text-sm font-medium text-gray-600">Progress</p>
                            <p class="text-xs text-gray-500" id="progress-text">1 of {{ count($questions) }}</p>
                        </div>
                        <div class="w-24 bg-gray-200 rounded-full h-2">
                            <div class="progress-bar bg-[#E68815] h-1.5 rounded-full" style="width: {{ 100 / count($questions) }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                <!-- Main Quiz Area -->
                <div class="col-span-1 md:col-span-4 lg:col-span-9">
                    <!-- Quiz Start Screen -->
                    <div id="quiz-start" class="glass-effect rounded-2xl p-8 shadow-lg text-center">
                        <div class="w-24 h-24 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-6">
                            <i class="mdi mdi-book-open-blank-variant-outline text-orange-600 text-4xl"></i>
                        </div>

                        <h2 class="text-3xl font-bold text-gray-800 mb-4">Ready to Test Your Knowledge?</h2>

                        <p class="text-gray-600 mb-8 max-w-2xl mx-auto">
                            {{ $quiz->description ?? 'This quiz covers the key concepts from Module ' . ($currentModule->order ?? ($currentModuleIndex + 1)) . ': ' . $currentModule->title . '.' }}
                            You'll have {{ count($questions) }} questions covering {{ $course->title }} topics.
                        </p>

                        <!-- Quiz Info Cards -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div class="bg-white rounded-xl p-6 shadow-sm border">
                                <i class="mdi mdi-clock-outline text-orange-500 text-3xl mb-3"></i>
                                <h3 class="font-semibold text-gray-800 mb-2">Time Limit</h3>
                                <p class="text-gray-600 text-sm">{{ $quiz->time_limit ?? 'No limit' }} {{ $quiz->time_limit ? 'minutes' : '' }}</p>
                            </div>

                            <div class="bg-white rounded-xl p-6 shadow-sm border">
                                <i class="mdi mdi-help-circle-outline text-blue-500 text-3xl mb-3"></i>
                                <h3 class="font-semibold text-gray-800 mb-2">Questions</h3>
                                <p class="text-gray-600 text-sm">{{ count($questions) }} multiple choice</p>
                            </div>

                            <div class="bg-white rounded-xl p-6 shadow-sm border">
                                <i class="mdi mdi-trophy-outline text-green-500 text-3xl mb-3"></i>
                                <h3 class="font-semibold text-gray-800 mb-2">Passing Score</h3>
                                <p class="text-gray-600 text-sm">{{ $quiz->pass_percentage }}% ({{ ceil(count($questions) * ($quiz->pass_percentage / 100)) }}/{{ count($questions) }})</p>
                            </div>
                        </div>

                        <!-- Previous Attempts -->
                        <div class="bg-white rounded-xl p-6 shadow-sm border mb-8">
                            @if($previousAttempts->count() > 0)
                                <h3 class="flex items-center gap-2 text-lg font-semibold text-gray-800 mb-4">
                                    <i class="mdi mdi-history text-orange-500 text-xl"></i>
                                    Previous Attempts
                                </h3>

                                <div class="space-y-3">
                                    @foreach($previousAttempts as $attempt)
                                        <div class="flex justify-between items-center text-sm p-3 rounded-lg hover:bg-orange-50 transition-colors" role="listitem" aria-label="Attempt {{$loop->iteration}} status">
                                            <div class="flex items-center gap-2">
                                                <i class="mdi mdi-numeric-{{ $loop->iteration }}-circle-outline text-gray-600"></i>
                                                <span class="text-gray-800">
                                                    Attempt {{ $loop->iteration }}
                                                    ({{ $attempt->completed_at ? $attempt->completed_at->format('M d, Y') : 'Incomplete' }})
                                                </span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <span class="{{ $attempt->passed ? 'text-green-600' : 'text-red-600' }} font-medium">
                                                    {{ $attempt->score }}/{{ $attempt->total_questions }} ({{ $attempt->percentage }}%)
                                                </span>
                                                <i class="mdi {{ $attempt->passed ? 'mdi-check-circle' : 'mdi-close-circle' }} {{ $attempt->passed ? 'text-green-600' : 'text-red-600' }} text-lg"></i>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center text-gray-600 text-sm">
                                    <i class="mdi mdi-information-outline text-orange-500 text-xl mb-2"></i>
                                    <p>No previous attempts yet. Start the quiz to track your progress!</p>
                                </div>
                            @endif
                        </div>

                        <button onclick="startQuiz()" class="btn-primary text-white px-12 py-4 rounded-full text-lg font-medium transition-all duration-300">
                            Start Quiz
                        </button>
                    </div>

                    <!-- Quiz Question Screen -->
                    <div id="quiz-question" class="hidden glass-effect rounded-2xl p-8 shadow-lg">
                        <!-- Timer -->
                        <div class="flex items-center justify-between mb-8">
                            <div class="flex items-center gap-3">
                                <span class="text-sm font-medium text-gray-600">Question <span id="current-question">1</span> of {{ count($questions) }}</span>
                            </div>

                            <div class="flex items-center gap-2 bg-orange-50 px-4 py-2 rounded-full">
                                <i class="mdi mdi-timer text-orange-600"></i>
                                <span id="timer" class="font-medium text-orange-800">{{ $quiz->time_limit ? sprintf('%02d:%02d', $quiz->time_limit, 0) : 'No limit' }}</span>
                            </div>
                        </div>

                        <!-- Question -->
                        <div class="mb-8">
                            <h2 id="question-text" class="text-2xl font-bold text-gray-800 mb-6 leading-relaxed"></h2>

                            <!-- Answer Options -->
                            <div class="space-y-4" id="answer-options"></div>
                        </div>

                        <!-- Navigation Buttons -->
                        <div class="flex items-center justify-between">
                            <button id="prev-btn" onclick="previousQuestion()" class="btn-secondary text-gray-900 px-8 py-3 rounded-full font-medium transition-all duration-300 opacity-50" disabled>
                                <i class="mdi mdi-arrow-left mr-2 text-gray-900"></i>Previous
                            </button>

                            <button id="next-btn" onclick="nextQuestion()" class="btn-primary text-white px-8 py-3 rounded-full font-medium transition-all duration-300 opacity-50" disabled>
                                Next<i class="mdi mdi-arrow-right ml-2"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Quiz Results Screen -->
                    <div id="quiz-results" class="hidden glass-effect rounded-2xl p-8 shadow-lg text-center">
                        <div class="celebration">
                            <div id="results-icon" class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                                <i class="mdi mdi-trophy text-green-600 text-4xl"></i>
                            </div>
                            <h2 id="results-title" class="text-3xl font-bold text-gray-800 mb-4">Congratulations!</h2>
                            <p id="results-message" class="text-gray-600 mb-8 text-lg">
                                You passed the quiz with flying colors!
                            </p>
                        </div>

                        <!-- Score Display -->
                        <div class="bg-white rounded-xl p-8 shadow-sm border mb-8 max-w-md mx-auto">
                            <div class="text-6xl font-bold text-orange-600 mb-2" id="final-score">0/{{ count($questions) }}</div>
                            <p class="text-gray-600 mb-4">Final Score</p>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div id="final-progress" class="progress-bar bg-[#E68815] h-2 rounded-full" style="width: 0"></div>
                            </div>
                            <p class="text-sm text-gray-500 mt-2" id="percentage-score">0%</p>
                        </div>

                        <!-- Detailed Results -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                            <div class="bg-white rounded-xl p-6 shadow-sm border">
                                <div class="text-2xl font-bold text-green-600 mb-2" id="correct-count">0</div>
                                <p class="text-gray-600">Correct Answers</p>
                            </div>
                            <div class="bg-white rounded-xl p-6 shadow-sm border">
                                <div class="text-2xl font-bold text-red-500 mb-2" id="incorrect-count">0</div>
                                <p class="text-gray-600">Incorrect Answers</p>
                            </div>
                            <div class="bg-white rounded-xl p-6 shadow-sm border">
                                <div class="text-2xl font-bold text-blue-600 mb-2" id="time-taken">0:00</div>
                                <p class="text-gray-600">Time Taken</p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <button onclick="reviewAnswers()" class="btn-secondary text-gray-900 px-8 py-3 rounded-full font-medium transition-all duration-300">
                                <i class="mdi mdi-eye mr-2 text-gray-900"></i>Review Answers
                            </button>

                            <button onclick="retakeQuiz()" class="btn-primary text-white px-8 py-3 rounded-full font-medium transition-all duration-300">
                                <i class="mdi mdi-refresh mr-2"></i>Retake Quiz
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="col-span-1 md:col-span-8 lg:col-span-3">
                    <!-- Question Navigation -->
                    <div class="glass-effect rounded-2xl p-6 shadow-lg mb-10">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Question Navigation</h3>
                        <div class="grid grid-cols-5 gap-2" id="question-nav">
                            <!-- Question nav buttons will be generated here -->
                        </div>
                        <div class="mt-4 text-center">
                            <button onclick="submitQuiz()" id="submit-btn" class="w-full btn-primary text-white py-3 rounded-full font-medium transition-all duration-300 opacity-50" disabled>
                                Submit Quiz
                            </button>
                        </div>
                    </div>

                    <!-- Quiz Tips -->
                    <div class="glass-effect rounded-2xl p-6 shadow-lg">
                        <h3 class="text-lg font-bold text-gray-800 mb-4">Quiz Tips</h3>
                        <div class="space-y-3 text-sm">
                            <div class="flex items-start gap-3">
                                <i class="mdi mdi-lightbulb text-yellow-500 mt-1"></i>
                                <p class="text-gray-600">Read each question carefully before selecting an answer.</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i class="mdi mdi-clock text-blue-500 mt-1"></i>
                                <p class="text-gray-600">You can navigate between questions using the sidebar.</p>
                            </div>
                            <div class="flex items-start gap-3">
                                <i class="mdi mdi-check-circle text-green-500 mt-1"></i>
                                <p class="text-gray-600">Make sure to answer all questions before submitting.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-primary {
            background: linear-gradient(135deg, #E68815 0%, #f59e0b 100%);
            box-shadow: 0 10px 25px rgba(230, 136, 21, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(230, 136, 21, 0.4);
        }

        .btn-secondary {
            background: rgba(255, 255, 255, 0.9);
            border: 2px solid #e5e7eb;
        }

        .btn-secondary:hover {
            border-color: #E68815;
            background: rgba(255, 255, 255, 1);
        }

        .answer-option {
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .answer-option:hover {
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            border-color: #E68815;
        }

        .answer-option.selected {
            border-color: #E68815;
            background: rgba(230, 136, 21, 0.1);
        }

        .answer-option.correct {
            border-color: #10b981;
            background: rgba(16, 185, 129, 0.1);
        }

        .answer-option.incorrect {
            border-color: #ef4444;
            background: rgba(239, 68, 68, 0.1);
        }

        .question-nav {
            transition: all 0.3s ease;
            color: #000000;
        }

        .question-nav:hover {
            transform: scale(1.05);
        }

        .question-nav.completed {
            background: #10b981;
            color: white;
        }

        .question-nav.current {
            background: #E68815;
            color: white;
        }

        .progress-bar {
            transition: width 0.5s ease;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .celebration {
            animation: celebration 0.6s ease-out;
        }

        @keyframes celebration {
            0% { transform: scale(0.8); opacity: 0; }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>
@endpush

@push('scripts')
    <script>
        let currentQuestion = 0;
        let selectedAnswers = {};
        let quizStartTime;
        let timerInterval;
        let timeRemaining = {{ $quiz->time_limit ? $quiz->time_limit * 60 : 999999 }};
        let reviewMode = false;
        const questions = @json($questions);
        const quizId = {{ $quiz->id }};
        const submitUrl = "{{ route('user.course.quiz.submit', [$course->slug, $currentModule->id]) }}";
        const passPercentage = {{ $quiz->pass_percentage }};
        let correctAnswers = [];

        const showError = (message) => {
            iziToast.error({ ...iziToastSettings, message });
        };

        function startQuiz() {
            document.getElementById('quiz-start').classList.add('hidden');
            document.getElementById('quiz-question').classList.remove('hidden');
            quizStartTime = new Date();
            generateQuestionNavigation();
            startTimer();
            showQuestion(0);
        }

        function generateQuestionNavigation() {
            const nav = document.getElementById('question-nav');
            nav.innerHTML = '';
            for (let i = 0; i < questions.length; i++) {
                const btn = document.createElement('button');
                btn.className = 'question-nav w-8 h-8 rounded-full border-2 border-gray-300 text-sm font-medium hover:border-orange-500 transition-colors';
                btn.textContent = i + 1;
                btn.onclick = () => showQuestion(i);
                nav.appendChild(btn);
            }
        }

        function showQuestion(index) {
            currentQuestion = index;

            // Update navigation
            updateQuestionNavigation();

            // Update question content
            if (questions[index]) {
                document.getElementById('question-text').textContent = questions[index].question;
                renderAnswerOptions(index);
            }

            // Update current question display
            document.getElementById('current-question').textContent = index + 1;

            // Update progress bar
            const progress = ((index + 1) / questions.length) * 100;
            document.querySelector('.progress-bar').style.width = progress + '%';
            document.getElementById('progress-text').textContent = `${index + 1} of ${questions.length}`;

            // Update navigation buttons
            updateNavigationButtons();

            // Update submit button
            updateSubmitButton();
        }

        function updateQuestionNavigation() {
            const navButtons = document.querySelectorAll('.question-nav');
            navButtons.forEach((btn, i) => {
                btn.classList.remove('current', 'completed');
                if (i === currentQuestion) {
                    btn.classList.add('current');
                } else if (selectedAnswers[i] !== undefined) {
                    btn.classList.add('completed');
                }
            });
        }

        function renderAnswerOptions(questionIndex) {
            const optionsContainer = document.getElementById('answer-options');
            optionsContainer.innerHTML = '';

            const options = questions[questionIndex].options || [];

            options.forEach((option, i) => {
                const optionDiv = document.createElement('div');
                optionDiv.className = `answer-option bg-white border-2 border-gray-200 rounded-xl p-6 flex items-start gap-4`;

                if (!reviewMode) {
                    optionDiv.onclick = () => selectAnswer(i);
                } else {
                    // In review mode: Highlight based on user's selection and correct answer
                    if (selectedAnswers[questionIndex] === i) {
                        optionDiv.classList.add('selected');
                        if (correctAnswers[questionIndex] !== undefined && i === correctAnswers[questionIndex]) {
                            optionDiv.classList.add('correct');
                        } else {
                            optionDiv.classList.add('incorrect');
                        }
                    } else if (correctAnswers[questionIndex] !== undefined && i === correctAnswers[questionIndex]) {
                        optionDiv.classList.add('correct');
                    }
                }

                optionDiv.innerHTML = `
                        <div class="w-6 h-6 border-2 border-gray-300 rounded-full flex items-center justify-center mt-1">
                            <div class="w-3 h-3 bg-orange-500 rounded-full ${selectedAnswers[questionIndex] === i ? '' : 'hidden'}"></div>
                        </div>
                        <div class="flex-1">
                            <p class="font-medium text-gray-800 mb-2">${i + 1}) ${option.text}</p>
                            <p class="text-gray-600 text-sm">${option.explanation || ''}</p>
                        </div>
                    `;
                optionsContainer.appendChild(optionDiv);
            });

            // Restore selected state if answer was previously selected
            if (selectedAnswers[questionIndex] !== undefined && !reviewMode) {
                selectAnswerVisual(selectedAnswers[questionIndex]);
            }
        }

        function updateNavigationButtons() {
            const prevBtn = document.getElementById('prev-btn');
            const nextBtn = document.getElementById('next-btn');

            // Previous button
            if (currentQuestion === 0) {
                prevBtn.disabled = true;
                prevBtn.classList.add('opacity-50');
            } else {
                prevBtn.disabled = false;
                prevBtn.classList.remove('opacity-50');
            }

            // Next button
            if (reviewMode) {
                if (currentQuestion === questions.length - 1) {
                    nextBtn.disabled = true;
                    nextBtn.classList.add('opacity-50');
                } else {
                    nextBtn.disabled = false;
                    nextBtn.classList.remove('opacity-50');
                }
            } else {
                if (selectedAnswers[currentQuestion] !== undefined) {
                    nextBtn.disabled = false;
                    nextBtn.classList.remove('opacity-50');
                } else {
                    nextBtn.disabled = true;
                    nextBtn.classList.add('opacity-50');
                }
            }
        }

        function selectAnswer(answerIndex) {
            if (!reviewMode) {
                selectedAnswers[currentQuestion] = answerIndex;
                selectAnswerVisual(answerIndex);
                updateNavigationButtons();
                updateQuestionNavigation();
                updateSubmitButton();
            }
        }

        function selectAnswerVisual(answerIndex) {
            const options = document.querySelectorAll('.answer-option');
            options.forEach((option, i) => {
                const circle = option.querySelector('div div');
                if (i === answerIndex) {
                    option.classList.add('selected');
                    circle.classList.remove('hidden');
                } else {
                    option.classList.remove('selected');
                    circle.classList.add('hidden');
                }
            });
        }

        function nextQuestion() {
            if (currentQuestion < questions.length - 1) {
                showQuestion(currentQuestion + 1);
            }
        }

        function previousQuestion() {
            if (currentQuestion > 0) {
                showQuestion(currentQuestion - 1);
            }
        }

        function updateSubmitButton() {
            const submitBtn = document.getElementById('submit-btn');
            const answeredCount = Object.keys(selectedAnswers).length;

            if (answeredCount === questions.length && !reviewMode) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50');
            } else {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50');
            }
        }

        function startTimer() {
            if (timeRemaining === 999999) return;
            timerInterval = setInterval(() => {
                timeRemaining--;
                const minutes = Math.floor(timeRemaining / 60);
                const seconds = timeRemaining % 60;
                document.getElementById('timer').textContent =
                    `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                if (timeRemaining <= 0) {
                    clearInterval(timerInterval);
                    submitQuiz();
                }
            }, 1000);
        }

        function submitQuiz() {
            clearInterval(timerInterval);

            const submitBtn = document.getElementById('submit-btn');
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50');
            submitBtn.innerHTML = `
                    <span class="flex items-center justify-center gap-2 z-10 relative">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span>Processing...</span>
                    </span>
                `;

            const startTime = quizStartTime.getTime();
            const endTime = new Date().getTime();
            const timeTakenSeconds = Math.floor((endTime - startTime) / 1000);
            const answers = Object.values(selectedAnswers);

            fetch(submitUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                },
                body: JSON.stringify({
                    answers: answers,
                    time_taken: timeTakenSeconds,
                }),
            })
                .then(response => response.json())
                .then(data => {
                    submitBtn.innerHTML = 'Submit Quiz';
                    submitBtn.disabled = false;
                    updateSubmitButton();

                    if (data.success) {
                        correctAnswers = data.correct_answers || [];

                        document.getElementById('final-score').textContent = `${data.score}/${data.total_questions}`;
                        document.getElementById('percentage-score').textContent = `${data.percentage}%`;
                        document.getElementById('correct-count').textContent = data.score;
                        document.getElementById('incorrect-count').textContent = data.total_questions - (data.score || 0);

                        const minutes = Math.floor(data.time_taken / 60);
                        const seconds = data.time_taken % 60;
                        document.getElementById('time-taken').textContent = `${minutes}:${seconds.toString().padStart(2, '0')}`;

                        document.getElementById('final-progress').style.width = `${data.percentage}%`;

                        const resultsIcon = document.getElementById('results-icon');
                        const resultsTitle = document.getElementById('results-title');
                        const resultsMessage = document.getElementById('results-message');
                        const finalProgress = document.getElementById('final-progress');

                        if (data.passed) {
                            resultsIcon.innerHTML = '<i class="mdi mdi-trophy text-green-600 text-4xl"></i>';
                            resultsIcon.className = 'w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6';
                            resultsTitle.textContent = 'Congratulations!';
                            resultsMessage.textContent = 'You passed the quiz with flying colors!';
                            finalProgress.className = 'progress-bar bg-[#E68815] h-2 rounded-full';
                        } else {
                            resultsIcon.innerHTML = '<i class="mdi mdi-close-circle text-red-600 text-4xl"></i>';
                            resultsIcon.className = 'w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-6';
                            resultsTitle.textContent = 'Try Again!';
                            resultsMessage.textContent = 'You didn\'t quite pass this time. Review the material and try again!';
                            finalProgress.className = 'progress-bar bg-[#E68815] h-2 rounded-full';
                        }

                        document.getElementById('quiz-question').classList.add('hidden');
                        document.getElementById('quiz-results').classList.remove('hidden');
                        document.getElementById('submit-btn').classList.add('hidden');
                    } else {
                        showError('Error submitting quiz. Please try again.');
                    }
                })
                .catch(error => {
                    submitBtn.innerHTML = 'Submit Quiz';
                    submitBtn.disabled = false;
                    updateSubmitButton();
                    console.error('Error:', error);
                    showError('Error submitting quiz. Please try again.');
                });
        }

        function reviewAnswers() {
            reviewMode = true;
            document.getElementById('quiz-results').classList.add('hidden');
            document.getElementById('quiz-question').classList.remove('hidden');
            document.getElementById('submit-btn').textContent = 'Back to Results';
            document.getElementById('submit-btn').disabled = false;
            document.getElementById('submit-btn').classList.remove('opacity-50');
            document.getElementById('submit-btn').classList.remove('hidden');
            document.getElementById('submit-btn').onclick = () => {
                document.getElementById('quiz-question').classList.add('hidden');
                document.getElementById('quiz-results').classList.remove('hidden');
                reviewMode = false;
                document.getElementById('submit-btn').textContent = 'Submit Quiz';
                document.getElementById('submit-btn').onclick = submitQuiz;
                document.getElementById('submit-btn').classList.remove('hidden');
                updateSubmitButton();
            };
            showQuestion(0);
        }

        function retakeQuiz() {
            currentQuestion = 0;
            selectedAnswers = {};
            correctAnswers = [];
            timeRemaining = {{ $quiz->time_limit ? $quiz->time_limit * 60 : 999999 }};
            reviewMode = false;
            clearInterval(timerInterval);
            document.getElementById('quiz-results').classList.add('hidden');
            document.getElementById('quiz-question').classList.add('hidden');
            document.getElementById('quiz-start').classList.remove('hidden');
            document.getElementById('submit-btn').classList.remove('hidden');
            document.getElementById('submit-btn').textContent = 'Submit Quiz';
            document.getElementById('submit-btn').onclick = submitQuiz;
            updateSubmitButton();

            document.querySelector('.progress-bar').style.width = (100 / questions.length) + '%';
            document.getElementById('progress-text').textContent = `1 of ${questions.length}`;

            if (timeRemaining === 999999) {
                document.getElementById('timer').textContent = 'No limit';
            } else {
                const minutes = Math.floor(timeRemaining / 60);
                const seconds = timeRemaining % 60;
                document.getElementById('timer').textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }
        }
    </script>
@endpush
