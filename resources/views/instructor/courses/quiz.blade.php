@extends('layouts.instructor')
@section('content')
    <div class="container">
        <!-- Header -->
        <div class="glass-effect header">
            <div class="header-content">
                <a href="{{ route('instructor.courses.manage', $course->id) }}" class="back-btn">
                    <i class="mdi mdi-arrow-left"></i>
                </a>
                <div style="flex: 1;">
                    <h1>Create New Quiz</h1>
                    <p>Module: {{ $module->title }}</p>
                </div>
            </div>
        </div>

        <!-- Main Form Container -->
        <div class="form-container">
            <!-- Main Form -->
            <div class="glass-effect main-form">
                <form id="quiz-form">
                    <!-- Quiz Details Section -->
                    <div class="form-section">
                        <h2 class="section-title">
                            <i class="mdi mdi-information section-icon"></i>
                            Quiz Details
                        </h2>

                        <div class="form-group">
                            <label for="quiz-title" class="form-label">Quiz Title</label>
                            <input type="text" id="quiz-title" name="title" class="form-input text-gray-900" placeholder="e.g., Advanced React Hooks Assessment" required>
                        </div>

                        <div class="form-group">
                            <label for="quiz-description" class="form-label">Description</label>
                            <textarea id="quiz-description" name="description" class="form-input text-gray-900 form-textarea" placeholder="Describe what this quiz covers and any important instructions for students..."></textarea>
                        </div>

                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                            <div class="form-group">
                                <label for="time-limit" class="form-label">Time Limit (minutes)</label>
                                <input type="number" id="time-limit" name="time_limit" class="text-gray-900 form-input" value="20" min="1" max="180">
                            </div>

                            <div class="form-group">
                                <label for="pass-percentage" class="form-label">Passing Score (%)</label>
                                <input type="number" id="pass-percentage" name="pass_percentage" class="text-gray-900 form-input" value="80" min="0" max="100" required>
                            </div>
                        </div>
                    </div>

                    <!-- Questions Section -->
                    <div class="form-section">
                        <h2 class="section-title">
                            <i class="mdi mdi-help-circle section-icon"></i>
                            Quiz Questions
                            <span id="question-count" class="stat-value">(0)</span>
                        </h2>

                        <!-- Questions Container -->
                        <div id="questions-container">
                            <!-- Empty State -->
                            <div id="empty-state" class="question-builder">
                                <div class="empty-state">
                                    <i class="mdi mdi-help-circle-outline"></i>
                                    <h3>No questions yet</h3>
                                    <p>Click "Add Question" to start building your quiz</p>
                                </div>
                            </div>
                        </div>

                        <!-- Add Question Button -->
                        <button type="button" onclick="addQuestion()" class="btn btn-outline btn-large" style="width: 100%;">
                            <i class="mdi mdi-plus"></i>
                            Add Question
                        </button>
                    </div>

                    <!-- Form Actions -->
                    <div style="display: flex; gap: 1rem; flex-wrap: wrap; justify-content: flex-end; margin-top: 2rem;">
                        <button type="submit" class="btn btn-primary btn-large">
                            <i class="mdi mdi-check"></i>
                            Publish Quiz
                        </button>
                    </div>
                </form>
            </div>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Quiz Statistics -->
                <div class="glass-effect sidebar-card">
                    <h3 class="sidebar-title">
                        <i class="mdi mdi-chart-bar"></i>
                        Quiz Statistics
                    </h3>

                    <div class="quiz-stats">
                        <div class="stat-item">
                            <span class="stat-label">Questions</span>
                            <span class="stat-value" id="total-questions">0</span>
                        </div>

                        <div class="stat-item">
                            <span class="stat-label">Estimated Time</span>
                            <span class="stat-value" id="estimated-time">0 min</span>
                        </div>

                        <div class="stat-item">
                            <span class="stat-label">Difficulty</span>
                            <span class="stat-value" id="difficulty-level">Easy</span>
                        </div>
                    </div>
                </div>

                <!-- Tips & Guidelines -->
                <div class="glass-effect sidebar-card">
                    <h3 class="sidebar-title">
                        <i class="mdi mdi-lightbulb-outline"></i>
                        Tips & Guidelines
                    </h3>

                    <ul class="tips-list">
                        <li>
                            <i class="mdi mdi-check-circle tip-icon"></i>
                            <span>Write clear, unambiguous questions that test specific learning objectives</span>
                        </li>
                        <li>
                            <i class="mdi mdi-clock-outline tip-icon"></i>
                            <span>Allow 1-2 minutes per question for multiple choice items</span>
                        </li>
                        <li>
                            <i class="mdi mdi-target tip-icon"></i>
                            <span>Include 4-5 answer options with only one clearly correct answer</span>
                        </li>
                        <li>
                            <i class="mdi mdi-shuffle tip-icon"></i>
                            <span>Randomize answer order to prevent pattern recognition</span>
                        </li>
                        <li>
                            <i class="mdi mdi-account-multiple tip-icon"></i>
                            <span>Consider the student's perspective when reviewing questions</span>
                        </li>
                    </ul>
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
            border-radius: 24px;
        }

        .header {
            padding: 2rem;
            margin-bottom: 2rem;
            animation: slideDown 0.8s ease-out;
        }

        .header-content {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .back-btn {
            padding: 0.5rem;
            color: #6b7280;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 12px;
            transition: all 0.3s;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
        }

        .back-btn:hover {
            color: #E68815;
            background: white;
            transform: translateX(-3px);
        }

        .header h1 {
            font-size: 2rem;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 0.5rem;
        }

        .header p {
            color: #6b7280;
            font-size: 1.1rem;
        }

        .form-container {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 2rem;
            animation: slideUp 0.8s ease-out 0.2s both;
        }

        .main-form {
            padding: 2rem;
        }

        .form-section {
            margin-bottom: 3rem;
        }

        .section-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .section-icon {
            color: #E68815;
            font-size: 1.2rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: block;
            font-weight: 600;
            color: #374151;
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-input {
            width: 100%;
            padding: 0.875rem 1rem;
            border: 2px solid #e5e7eb;
            border-radius: 12px;
            font-size: 0.95rem;
            transition: all 0.3s;
            background: white;
        }

        .form-input:focus {
            outline: none;
            border-color: #E68815;
            box-shadow: 0 0 0 3px rgba(230, 136, 21, 0.1);
            transform: translateY(-1px);
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .question-builder {
            border: 2px dashed #d1d5db;
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            background: rgba(249, 250, 251, 0.8);
            transition: all 0.3s;
        }

        .question-builder.active {
            border-color: #E68815;
            background: rgba(230, 136, 21, 0.05);
        }

        .question-card {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            border: 1px solid #e5e7eb;
            position: relative;
            transition: all 0.3s;
        }

        .question-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .question-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 1rem;
        }

        .question-number {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            color: #E68815;
        }

        .question-actions {
            display: flex;
            gap: 0.5rem;
        }

        .btn-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .btn-icon.danger {
            background: #fee2e2;
            color: #dc2626;
        }

        .btn-icon.danger:hover {
            background: #fecaca;
            transform: scale(1.1);
        }

        .option-input {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.75rem;
            padding: 0.75rem;
            background: #f9fafb;
            border-radius: 12px;
            transition: all 0.3s;
        }

        .option-input:hover {
            background: #f3f4f6;
        }

        .option-radio {
            width: 20px;
            height: 20px;
            accent-color: #E68815;
            cursor: pointer;
        }

        .option-text {
            flex: 1;
            border: none;
            background: transparent;
            font-size: 0.95rem;
            padding: 0.25rem;
        }

        .option-text:focus {
            outline: none;
            background: white;
            border-radius: 6px;
            box-shadow: 0 0 0 2px rgba(230, 136, 21, 0.2);
        }

        .btn-add-option {
            background: rgba(230, 136, 21, 0.1);
            color: #E68815;
            border: 2px dashed #E68815;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            justify-content: center;
        }

        .btn-add-option:hover {
            background: rgba(230, 136, 21, 0.2);
            transform: translateY(-1px);
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.875rem 2rem;
            border-radius: 16px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
            font-size: 0.95rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #E68815 0%, #f59e0b 100%);
            color: white;
            box-shadow: 0 10px 25px rgba(230, 136, 21, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 35px rgba(230, 136, 21, 0.4);
        }

        .btn-outline {
            background: transparent;
            color: #E68815;
            border: 2px solid #E68815;
        }

        .btn-outline:hover {
            background: #E68815;
            color: white;
            transform: translateY(-1px);
        }

        .btn-large {
            padding: 1.25rem 3rem;
            font-size: 1.1rem;
            border-radius: 20px;
        }

        .sidebar {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
        }

        .sidebar-card {
            padding: 1.5rem;
        }

        .sidebar-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .tips-list {
            list-style: none;
            padding: 0;
        }

        .tips-list li {
            display: flex;
            align-items: flex-start;
            gap: 0.75rem;
            margin-bottom: 1rem;
            font-size: 0.9rem;
            color: #6b7280;
        }

        .tip-icon {
            color: #E68815;
            margin-top: 2px;
            font-size: 1rem;
        }

        .quiz-stats {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .stat-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem;
            background: #f9fafb;
            border-radius: 12px;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #6b7280;
        }

        .stat-value {
            font-weight: 700;
            color: #E68815;
            font-size: 1.1rem;
        }

        .empty-state {
            text-align: center;
            padding: 3rem 2rem;
            color: #9ca3af;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        .empty-state h3 {
            font-size: 1.2rem;
            margin-bottom: 0.5rem;
            color: #6b7280;
        }

        .empty-state p {
            font-size: 0.9rem;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .form-container {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .header {
                padding: 1.5rem;
            }

            .header h1 {
                font-size: 1.5rem;
            }

            .main-form {
                padding: 1.5rem;
            }

            .question-actions {
                flex-direction: column;
                gap: 0.25rem;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        let questionCount = 0;

        // Initialize iziToast settings
        iziToast.settings({
            position: 'topRight',
            transitionIn: 'flipInX',
            transitionOut: 'flipOutX',
        });

        // Spinner HTML
        const SPINNER_HTML = `
            <span class="flex items-center justify-center gap-2 z-10 relative">
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                </svg>
                <span>Processing...</span>
            </span>
        `;

        // Add Question Function
        function addQuestion() {
            questionCount++;
            const questionId = `question-${questionCount}`;

            const questionHtml = `
                <div class="question-card" id="${questionId}">
                    <div class="question-header">
                        <div class="question-number">
                            <i class="mdi mdi-help-circle"></i>
                            <span>Question ${questionCount}</span>
                        </div>
                        <div class="question-actions">
                            <button type="button" class="btn-icon danger" onclick="confirmDeleteQuestion('${questionId}')" title="Delete Question">
                                <i class="mdi mdi-delete"></i>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Question Text</label>
                        <textarea class="form-input form-textarea text-gray-900" name="questions[${questionCount-1}][text]" placeholder="Enter your question here..." required oninput="updateStats()"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Answer Options</label>
                        <div class="options-container" id="options-${questionId}">
                            <div class="option-input">
                                <input type="radio" name="questions[${questionCount-1}][correct]" value="0" class="option-radio" required>
                                <input type="text" class="option-text text-gray-900" name="questions[${questionCount-1}][options][0]" placeholder="Option A" required>
                                <button type="button" class="btn-icon danger" onclick="confirmDeleteOption(this)" style="margin-left: auto;">
                                    <i class="mdi mdi-close" style="font-size: 14px;"></i>
                                </button>
                            </div>
                            <div class="option-input">
                                <input type="radio" name="questions[${questionCount-1}][correct]" value="1" class="option-radio">
                                <input type="text" class="option-text text-gray-900" name="questions[${questionCount-1}][options][1]" placeholder="Option B" required>
                                <button type="button" class="btn-icon danger" onclick="confirmDeleteOption(this)" style="margin-left: auto;">
                                    <i class="mdi mdi-close" style="font-size: 14px;"></i>
                                </button>
                            </div>
                            <div class="option-input">
                                <input type="radio" name="questions[${questionCount-1}][correct]" value="2" class="option-radio">
                                <input type="text" class="option-text text-gray-900" name="questions[${questionCount-1}][options][2]" placeholder="Option C" required>
                                <button type="button" class="btn-icon danger" onclick="confirmDeleteOption(this)" style="margin-left: auto;">
                                    <i class="mdi mdi-close" style="font-size: 14px;"></i>
                                </button>
                            </div>
                            <div class="option-input">
                                <input type="radio" name="questions[${questionCount-1}][correct]" value="3" class="option-radio">
                                <input type="text" class="option-text text-gray-900" name="questions[${questionCount-1}][options][3]" placeholder="Option D" required>
                                <button type="button" class="btn-icon danger" onclick="confirmDeleteOption(this)" style="margin-left: auto;">
                                    <i class="mdi mdi-close" style="font-size: 14px;"></i>
                                </button>
                            </div>
                        </div>
                        <button type="button" class="btn-add-option" onclick="addOption('options-${questionId}', ${questionCount-1})">
                            <i class="mdi mdi-plus"></i>
                            Add Option
                        </button>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Explanation (Optional)</label>
                        <textarea class="form-input text-gray-900" name="questions[${questionCount-1}][explanation]" placeholder="Provide an explanation for the correct answer..." rows="3"></textarea>
                    </div>
                </div>
            `;

            document.getElementById('empty-state').style.display = 'none';
            document.getElementById('questions-container').insertAdjacentHTML('beforeend', questionHtml);
            document.getElementById(questionId).scrollIntoView({ behavior: 'smooth', block: 'center' });
            updateStats();
        }

        // Confirm Delete Question
        function confirmDeleteQuestion(questionId) {
            iziToast.question({
                timeout: false,
                close: false,
                displayMode: 'once',
                id: `delete-question-${questionId}`,
                title: 'Are you sure?',
                message: 'Do you want to delete this question?',
                position: 'topRight',
                transitionIn: 'flipInX',
                transitionOut: 'flipOutX',
                buttons: [
                    ['<button><b>Yes, Delete</b></button>', function (instance, toast) {
                        document.getElementById(questionId).remove();
                        questionCount--;
                        if (questionCount === 0) {
                            document.getElementById('empty-state').style.display = 'block';
                        }
                        renumberQuestions();
                        updateStats();
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    }, true],
                    ['<button>No</button>', function (instance, toast) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    }]
                ]
            });
        }

        // Confirm Delete Option
        function confirmDeleteOption(button) {
            const container = button.closest('.options-container');
            const optionCount = container.querySelectorAll('.option-input').length;

            if (optionCount <= 2) {
                iziToast.error({
                    message: 'Minimum 2 options required per question.',
                    position: 'topRight',
                    transitionIn: 'flipInX',
                    transitionOut: 'flipOutX',
                });
                return;
            }

            iziToast.question({
                timeout: false,
                close: false,
                displayMode: 'once',
                id: 'delete-option',
                title: 'Are you sure?',
                message: 'Do you want to delete this option?',
                position: 'topRight',
                transitionIn: 'flipInX',
                transitionOut: 'flipOutX',
                buttons: [
                    ['<button><b>Yes, Delete</b></button>', function (instance, toast) {
                        button.closest('.option-input').remove();
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    }, true],
                    ['<button>No</button>', function (instance, toast) {
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                    }]
                ]
            });
        }

        // Add Option Function
        function addOption(containerId, questionIndex) {
            const container = document.getElementById(containerId);
            if (!container) {
                console.error(`Container with ID ${containerId} not found`);
                iziToast.error({
                    message: 'Failed to add option. Container not found.',
                    position: 'topRight',
                    transitionIn: 'flipInX',
                    transitionOut: 'flipOutX',
                });
                return;
            }

            const optionCount = container.querySelectorAll('.option-input').length;
            if (optionCount >= 4) {
                iziToast.error({
                    message: 'Maximum 4 options allowed per question.',
                    position: 'topRight',
                    transitionIn: 'flipInX',
                    transitionOut: 'flipOutX',
                });
                return;
            }

            const optionHtml = `
                <div class="option-input">
                    <input type="radio" name="questions[${questionIndex}][correct]" value="${optionCount}" class="option-radio">
                    <input type="text" class="option-text text-gray-900" name="questions[${questionIndex}][options][${optionCount}]" placeholder="Option ${String.fromCharCode(65 + optionCount)}" required>
                    <button type="button" class="btn-icon danger" onclick="confirmDeleteOption(this)" style="margin-left: auto;">
                        <i class="mdi mdi-close" style="font-size: 14px;"></i>
                    </button>
                </div>
            `;

            const addButton = container.querySelector('.btn-add-option');
            if (addButton) {
                addButton.insertAdjacentHTML('beforebegin', optionHtml);
            } else {
                container.insertAdjacentHTML('beforeend', optionHtml);
            }
        }

        // Renumber Questions
        function renumberQuestions() {
            const questionCards = document.querySelectorAll('.question-card');
            questionCards.forEach((card, index) => {
                const questionNumber = card.querySelector('.question-number span');
                questionNumber.textContent = `Question ${index + 1}`;

                const questionIndex = index;
                card.querySelectorAll('textarea[name$="[text]"]').forEach(input => {
                    input.name = `questions[${questionIndex}][text]`;
                });
                card.querySelectorAll('textarea[name$="[explanation]"]').forEach(input => {
                    input.name = `questions[${questionIndex}][explanation]`;
                });
                card.querySelectorAll('input[name$="[correct]"]').forEach(input => {
                    input.name = `questions[${questionIndex}][correct]`;
                });
                card.querySelectorAll('.option-input').forEach((option, optIndex) => {
                    option.querySelector('input[type="radio"]').value = optIndex;
                    option.querySelector('input[type="text"]').name = `questions[${questionIndex}][options][${optIndex}]`;
                });
            });
        }

        // Update Statistics
        function updateStats() {
            const totalQuestions = document.querySelectorAll('.question-card').length;
            const estimatedTime = Math.max(totalQuestions * 1.5, 5);

            document.getElementById('question-count').textContent = `(${totalQuestions})`;
            document.getElementById('total-questions').textContent = totalQuestions;
            document.getElementById('estimated-time').textContent = `${Math.round(estimatedTime)} min`;

            let difficulty = 'Easy';
            if (totalQuestions >= 10) difficulty = 'Medium';
            if (totalQuestions >= 20) difficulty = 'Hard';
            document.getElementById('difficulty-level').textContent = difficulty;
        }

        // Show Error Message with iziToast
        function showError(message, element = null) {
            iziToast.error({
                message: message,
                position: 'topRight',
                transitionIn: 'flipInX',
                transitionOut: 'flipOutX',
            });

            if (element) {
                element.scrollIntoView({ behavior: 'smooth', block: 'center' });
                element.focus();
            }
        }

        // Form Submission with Validation and AJAX
        const quizForm = document.getElementById('quiz-form');
        const submitBtn = quizForm.querySelector('button[type="submit"]');

        quizForm.addEventListener('submit', function(e) {
            e.preventDefault();
            console.log('Form submission triggered, setting spinner');

            // Set spinner immediately
            const originalBtnContent = submitBtn.innerHTML;
            submitBtn.innerHTML = SPINNER_HTML;
            submitBtn.disabled = true;

            // Validate Quiz Details
            const title = document.getElementById('quiz-title').value.trim();
            if (!title) {
                submitBtn.innerHTML = originalBtnContent;
                submitBtn.disabled = false;
                showError('Quiz title is required.', document.getElementById('quiz-title'));
                return;
            }

            const passPercentage = parseInt(document.getElementById('pass-percentage').value);
            if (isNaN(passPercentage) || passPercentage < 0 || passPercentage > 100) {
                submitBtn.innerHTML = originalBtnContent;
                submitBtn.disabled = false;
                showError('Passing score must be between 0 and 100.', document.getElementById('pass-percentage'));
                return;
            }

            const timeLimit = document.getElementById('time-limit').value;
            if (timeLimit && (isNaN(timeLimit) || timeLimit < 1 || timeLimit > 180)) {
                submitBtn.innerHTML = originalBtnContent;
                submitBtn.disabled = false;
                showError('Time limit must be between 1 and 180 minutes.', document.getElementById('time-limit'));
                return;
            }

            // Validate Questions
            const questions = document.querySelectorAll('.question-card');
            if (questions.length === 0) {
                submitBtn.innerHTML = originalBtnContent;
                submitBtn.disabled = false;
                showError('At least one question is required.');
                return;
            }

            for (let i = 0; i < questions.length; i++) {
                const question = questions[i];
                const questionText = question.querySelector('textarea[name$="[text]"]').value.trim();
                if (!questionText) {
                    submitBtn.innerHTML = originalBtnContent;
                    submitBtn.disabled = false;
                    showError(`Question ${i + 1} text is required.`, question.querySelector('textarea[name$="[text]"]'));
                    return;
                }

                const options = question.querySelectorAll('.option-input input[type="text"]');
                if (options.length < 2) {
                    submitBtn.innerHTML = originalBtnContent;
                    submitBtn.disabled = false;
                    showError(`Question ${i + 1} must have at least 2 options.`, question);
                    return;
                }

                for (let j = 0; j < options.length; j++) {
                    if (!options[j].value.trim()) {
                        submitBtn.innerHTML = originalBtnContent;
                        submitBtn.disabled = false;
                        showError(`Option ${String.fromCharCode(65 + j)} for Question ${i + 1} is required.`, options[j]);
                        return;
                    }
                }

                const correctAnswer = question.querySelector('input[type="radio"]:checked');
                if (!correctAnswer) {
                    submitBtn.innerHTML = originalBtnContent;
                    submitBtn.disabled = false;
                    showError(`Please select the correct answer for Question ${i + 1}.`, question);
                    return;
                }
            }

            // Prepare form data
            const formData = {
                title: title,
                description: document.getElementById('quiz-description').value.trim(),
                time_limit: timeLimit ? parseInt(timeLimit) : null,
                pass_percentage: passPercentage,
                questions: Array.from(questions).map((question) => {
                    const options = Array.from(question.querySelectorAll('.option-input input[type="text"]')).map(opt => opt.value.trim());
                    const correctIndex = parseInt(question.querySelector('input[type="radio"]:checked').value);
                    return {
                        text: question.querySelector('textarea[name$="[text]"]').value.trim(),
                        options: options,
                        correct: options[correctIndex], // Send the text of the selected option
                        explanation: question.querySelector('textarea[name$="[explanation]"]').value.trim()
                    };
                })
            };

            // Send AJAX request
            fetch('{{ route("instructor.courses.quizzes.store", [$course->id, $module->id]) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(formData)
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        iziToast.success({
                            message: 'Quiz published successfully! Students can now access this quiz.',
                            position: 'topRight',
                            transitionIn: 'flipInX',
                            transitionOut: 'flipOutX',
                        });
                        setTimeout(() => {
                            window.location.href = '{{ route("instructor.courses.manage", $course->id) }}';
                        }, 2000);
                    } else {
                        throw new Error(data.message || 'Failed to publish quiz.');
                    }
                })
                .catch(error => {
                    console.error('Submission error:', error);
                    showError(error.message || 'An error occurred while publishing the quiz.');
                })
                .finally(() => {
                    console.log('Restoring button content');
                    submitBtn.innerHTML = originalBtnContent;
                    submitBtn.disabled = false;
                });
        });

        // Ctrl+Enter to add question
        document.addEventListener('keydown', function(e) {
            if ((e.ctrlKey || e.metaKey) && e.key === 'Enter') {
                e.preventDefault();
                addQuestion();
            }
        });
    </script>
@endpush
