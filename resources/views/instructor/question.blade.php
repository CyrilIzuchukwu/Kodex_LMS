@extends('layouts.instructor')
@section('content')
    <div class="">

        <!-- Add Question -->
        <div class="quiz-builder">
            <button id="addQuestionBtn" class="add-question-btn text-[#E68815] font-medium text-sm flex items-center gap-1">
                <span class="text-lg">＋</span> Add question
            </button>

            <!-- Question Card -->
            <div class="question-card mt-2 border bg-[#F9F8F7] p-6 rounded-[18px]" data-question-id="1">
                <!-- Question Input -->
                <div class="mb-4">
                    <label class="flex items-center justify-between text-gray-800 font-medium mb-1">
                        <span>Question 1</span>
                        <span>
                            <i
                                class="toggle-arrow uil uil-angle-down text-2xl cursor-pointer transition-transform ease-in-out duration-500"></i>
                        </span>
                    </label>
                    <input type="text" name="questions[1][text]" placeholder="Enter your question"
                        class="question-input w-full border h-[45px] text-sm text-[#1B1B1B] border-gray-300 rounded-md p-2 focus:ring-1 focus:ring-[#E68815] focus:border-none focus:outline-none">
                </div>

                <!-- Option Container -->
                <div id="optionCard-1"
                    class="option-container transition-all duration-500 ease-in-out overflow-hidden max-h-[1000px]">
                    <!-- Add this single label here -->
                    <label class="option-label block text-[#1B1B1B] text-sm mb-2">Options (checked option is
                        correct)</label>

                    <!-- Option Input -->
                    <div class="option-item flex items-center mb-2 gap-2">
                        <input type="radio" name="questions[1][correct_option]" value="0"
                            class="option-radio w-4 h-4 text-[#E68815] focus:ring-[#E68815]" checked>
                        <div class="option-input-container flex-1">
                            <!-- Remove the label from here -->
                            <input type="text" name="questions[1][options][0]" placeholder="Enter option"
                                class="option-input w-full border h-[45px] text-sm text-[#1B1B1B] border-gray-300 rounded-md p-2 focus:ring-1 focus:ring-[#E68815] focus:border-none focus:outline-none">
                        </div>
                        <button class="delete-option-btn hidden">
                            <i class="uil uil-times text-red-500"></i>
                        </button>
                    </div>

                    <!-- Add Option -->
                    <button class="add-option-btn text-[#E68815] font-medium text-sm flex items-center gap-1">
                        <span class="text-lg">＋</span> Add option
                    </button>
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let questionCount = 1;
            const quizBuilder = document.querySelector('.quiz-builder');

            // Add question button functionality
            document.getElementById('addQuestionBtn').addEventListener('click', function() {
                questionCount++;

                // Clone the first question card
                const firstCard = document.querySelector('.question-card');
                const newCard = firstCard.cloneNode(true);

                // Update question ID and attributes
                newCard.dataset.questionId = questionCount;

                // Update question label
                const questionLabel = newCard.querySelector('label span:first-child');
                questionLabel.textContent = `Question ${questionCount}`;

                // Update question input name
                const questionInput = newCard.querySelector('.question-input');
                questionInput.name = `questions[${questionCount}][text]`;
                questionInput.value = '';

                // Update option container ID
                const optionContainer = newCard.querySelector('.option-container');
                optionContainer.id = `optionCard-${questionCount}`;

                // Clear all options except the first one
                const optionItems = newCard.querySelectorAll('.option-item');
                for (let i = 1; i < optionItems.length; i++) {
                    optionItems[i].remove();
                }

                // Update the first option
                const firstOption = newCard.querySelector('.option-item');
                const firstOptionRadio = firstOption.querySelector('.option-radio');
                firstOptionRadio.name = `questions[${questionCount}][correct_option]`;
                firstOptionRadio.value = '0';
                firstOptionRadio.checked = true;

                const firstOptionInput = firstOption.querySelector('.option-input');
                firstOptionInput.name = `questions[${questionCount}][options][0]`;
                firstOptionInput.value = '';

                // Show delete button if hidden
                const deleteBtn = firstOption.querySelector('.delete-option-btn');
                if (deleteBtn.classList.contains('hidden')) {
                    deleteBtn.classList.remove('hidden');
                }

                // Add event listeners to the new card
                addCardEventListeners(newCard);

                // Insert the new card
                quizBuilder.appendChild(newCard);

                // Initialize toggle state for the new card
                initToggleState(optionContainer.id);
            });

            // Add event listeners to the initial question card
            addCardEventListeners(document.querySelector('.question-card'));

            // Initialize toggle state for the first card
            initToggleState('optionCard-1');

            // Function to add event listeners to a question card
            function addCardEventListeners(card) {
                const questionId = card.dataset.questionId;
                const toggleArrow = card.querySelector('.toggle-arrow');
                const optionContainer = card.querySelector('.option-container');
                const addOptionBtn = card.querySelector('.add-option-btn');

                // Toggle arrow functionality
                toggleArrow.addEventListener('click', function() {
                    toggleOptions(optionContainer.id);
                });

                // Add option functionality
                addOptionBtn.addEventListener('click', function() {
                    addOptionToQuestion(questionId);
                });

                // Delete option functionality (event delegation)
                card.addEventListener('click', function(e) {
                    if (e.target.closest('.delete-option-btn')) {
                        const optionItem = e.target.closest('.option-item');
                        if (card.querySelectorAll('.option-item').length > 1) {
                            optionItem.remove();
                            // Ensure at least one radio is checked
                            const remainingRadios = card.querySelectorAll('.option-radio');
                            if (!card.querySelector('.option-radio:checked') && remainingRadios.length >
                                0) {
                                remainingRadios[0].checked = true;
                            }
                        }
                    }
                });
            }

            // Function to toggle options visibility
            function toggleOptions(optionContainerId) {
                const optionContainer = document.getElementById(optionContainerId);
                const toggleArrow = optionContainer.closest('.question-card').querySelector('.toggle-arrow');

                if (optionContainer.classList.contains('max-h-0')) {
                    optionContainer.classList.remove('max-h-0');
                    optionContainer.classList.add('max-h-[1000px]');
                    toggleArrow.classList.remove('rotate-180');
                    localStorage.setItem(optionContainerId, 'open');
                } else {
                    optionContainer.classList.remove('max-h-[1000px]');
                    optionContainer.classList.add('max-h-0');
                    toggleArrow.classList.add('rotate-180');
                    localStorage.setItem(optionContainerId, 'closed');
                }
            }

            // Function to initialize toggle state from localStorage
            function initToggleState(optionContainerId) {
                const optionContainer = document.getElementById(optionContainerId);
                const toggleArrow = optionContainer.closest('.question-card').querySelector('.toggle-arrow');
                const isOpen = localStorage.getItem(optionContainerId) === 'open';

                if (isOpen) {
                    optionContainer.classList.add('max-h-[1000px]');
                    optionContainer.classList.remove('max-h-0');
                    toggleArrow.classList.remove('rotate-180');
                } else {
                    optionContainer.classList.add('max-h-0');
                    optionContainer.classList.remove('max-h-[1000px]');
                    toggleArrow.classList.add('rotate-180');
                }
            }

            // Function to add a new option to a question
            function addOptionToQuestion(questionId) {
                const card = document.querySelector(`.question-card[data-question-id="${questionId}"]`);
                const optionContainer = card.querySelector('.option-container');
                const optionItems = card.querySelectorAll('.option-item');
                const optionCount = optionItems.length;

                // Clone the first option item
                const firstOption = optionItems[0];
                const newOption = firstOption.cloneNode(true);

                // Update the radio button
                const radio = newOption.querySelector('.option-radio');
                radio.name = `questions[${questionId}][correct_option]`;
                radio.value = optionCount;
                radio.checked = false;

                // Update the input
                const input = newOption.querySelector('.option-input');
                input.name = `questions[${questionId}][options][${optionCount}]`;
                input.value = '';

                // Show delete button
                const deleteBtn = newOption.querySelector('.delete-option-btn');
                deleteBtn.classList.remove('hidden');

                // Insert before the add option button
                const addOptionBtn = card.querySelector('.add-option-btn');
                optionContainer.insertBefore(newOption, addOptionBtn);
            }

            // Function to collect all form data for backend processing
            window.getQuizData = function() {
                const questions = [];
                const questionCards = document.querySelectorAll('.question-card');

                questionCards.forEach(card => {
                    const questionId = card.dataset.questionId;
                    const questionText = card.querySelector('.question-input').value;
                    const options = [];
                    let correctOption = null;

                    const optionItems = card.querySelectorAll('.option-item');
                    optionItems.forEach((item, index) => {
                        const optionText = item.querySelector('.option-input').value;
                        const isCorrect = item.querySelector('.option-radio').checked;

                        options.push(optionText);

                        if (isCorrect) {
                            correctOption = index;
                        }
                    });

                    questions.push({
                        id: questionId,
                        text: questionText,
                        options: options,
                        correct_option: correctOption
                    });
                });

                return {
                    questions: questions
                };
            };
        });
    </script>

    {{-- it might be helpful  --}}

    {{-- public function store(Request $request)
{
    $data = $request->validate([
        'questions' => 'required|array',
        'questions.*.text' => 'required|string',
        'questions.*.options' => 'required|array',
        'questions.*.options.*' => 'required|string',
        'questions.*.correct_option' => 'required|integer'
    ]);

    foreach ($data['questions'] as $questionData) {
        $question = Question::create([
            'text' => $questionData['text']
        ]);

        foreach ($questionData['options'] as $index => $optionText) {
            $isCorrect = $index == $questionData['correct_option'];

            Option::create([
                'question_id' => $question->id,
                'text' => $optionText,
                'is_correct' => $isCorrect
            ]);
        }
    }

} --}}
@endsection
