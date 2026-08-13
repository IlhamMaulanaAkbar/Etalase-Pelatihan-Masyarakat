<script>
    document.addEventListener("DOMContentLoaded", function() {
        let currentIndex = 0;
        const storageKey = @json($storageKey);
        const durationSeconds = @json($durationSeconds ?? 900);
        const formElement = document.getElementById("assessmentForm");
        const questions = document.querySelectorAll(".question-block");
        const navButtons = document.querySelectorAll(".nav-button");
        const prevBtn = document.getElementById("prevBtn");
        const nextBtn = document.getElementById("nextBtn");
        const submitBtn = document.getElementById("submitBtn");
        const submitWrapper = document.getElementById("submitWrapper");
        const countdownElement = document.getElementById("countdown");
        const totalQuestions = questions.length;

        function readState() {
            try {
                return JSON.parse(localStorage.getItem(storageKey)) || {};
            } catch (error) {
                return {};
            }
        }

        function writeState(nextState) {
            const currentState = readState();
            localStorage.setItem(storageKey, JSON.stringify({
                ...currentState,
                ...nextState,
            }));
        }

        function answerState() {
            const answers = {};

            document.querySelectorAll(".answer-option:checked").forEach(input => {
                answers[input.dataset.questionId] = input.value;
            });

            return answers;
        }

        function restoreAnswers(savedAnswers = {}) {
            document.querySelectorAll(".answer-option").forEach(input => {
                input.checked = savedAnswers[input.dataset.questionId] === input.value;
            });
        }

        function updateNavAnsweredState() {
            const answeredQuestionIds = new Set();

            document.querySelectorAll(".answer-option:checked").forEach(input => {
                answeredQuestionIds.add(input.dataset.questionId);
            });

            navButtons.forEach(btn => {
                btn.classList.toggle("is-answered", answeredQuestionIds.has(btn.dataset.questionId));
            });
        }

        function updateView(index) {
            currentIndex = Math.max(0, Math.min(index, totalQuestions - 1));

            questions.forEach((question, questionIndex) => {
                question.classList.toggle("d-none", questionIndex !== currentIndex);
            });

            navButtons.forEach((btn, btnIndex) => {
                btn.classList.toggle("is-active", btnIndex === currentIndex);
                btn.classList.toggle("btn-dark", btnIndex === currentIndex);
                btn.classList.toggle("text-white", btnIndex === currentIndex);
                btn.classList.toggle("btn-outline-secondary", btnIndex !== currentIndex);
            });

            prevBtn.classList.toggle("d-none", currentIndex === 0);
            nextBtn.classList.toggle("d-none", currentIndex === totalQuestions - 1);
            submitWrapper.classList.toggle("d-none", currentIndex !== totalQuestions - 1);
            writeState({
                currentIndex
            });
        }

        function checkAllAnswered() {
            const answered = new Set();

            document.querySelectorAll(".answer-option:checked").forEach(input => {
                answered.add(input.name);
            });

            if (answered.size === totalQuestions) {
                submitBtn.disabled = false;
                submitBtn.classList.remove("disabled");
                submitWrapper.removeAttribute("data-bs-toggle");
                submitWrapper.removeAttribute("data-bs-placement");
                submitWrapper.removeAttribute("title");

                const tooltip = bootstrap.Tooltip.getInstance(submitWrapper);
                if (tooltip) {
                    tooltip.dispose();
                }
            } else {
                submitBtn.disabled = true;
                submitBtn.classList.add("disabled");
                submitWrapper.setAttribute("data-bs-toggle", "tooltip");
                submitWrapper.setAttribute("data-bs-placement", "left");
                submitWrapper.setAttribute("title", "Pastikan semua jawaban telah terisi.");

                bootstrap.Tooltip.getOrCreateInstance(submitWrapper);
            }
        }

        function submitAssessment() {
            document.getElementById("hiddenSubmitBtn").click();
        }

        function startTimer(deadlineAt) {
            const timerInterval = setInterval(() => {
                const remainingSeconds = Math.max(0, Math.ceil((deadlineAt - Date.now()) / 1000));
                const minutes = Math.floor(remainingSeconds / 60);
                const seconds = remainingSeconds % 60;

                countdownElement.textContent =
                    `${minutes.toString().padStart(2, "0")}m:${seconds.toString().padStart(2, "0")}s`;

                if (remainingSeconds <= 0) {
                    clearInterval(timerInterval);
                    submitAssessment();
                }
            }, 1000);
        }

        const savedState = readState();
        const deadlineAt = savedState.deadlineAt || Date.now() + (durationSeconds * 1000);

        writeState({
            deadlineAt
        });
        restoreAnswers(savedState.answers || {});
        currentIndex = Number.isInteger(savedState.currentIndex) ? savedState.currentIndex : 0;

        navButtons.forEach(btn => {
            btn.addEventListener("click", () => updateView(parseInt(btn.dataset.index, 10)));
        });

        prevBtn.addEventListener("click", () => {
            if (currentIndex > 0) {
                updateView(currentIndex - 1);
            }
        });

        nextBtn.addEventListener("click", () => {
            if (currentIndex < totalQuestions - 1) {
                updateView(currentIndex + 1);
            }
        });

        document.querySelectorAll(".answer-option").forEach(input => {
            input.addEventListener("change", () => {
                writeState({
                    answers: answerState()
                });
                updateNavAnsweredState();
                checkAllAnswered();
            });
        });

        formElement.addEventListener("submit", () => {
            localStorage.removeItem(storageKey);
        });

        updateNavAnsweredState();
        updateView(currentIndex);
        checkAllAnswered();

        if (deadlineAt <= Date.now()) {
            submitAssessment();
            return;
        }

        startTimer(deadlineAt);

        setInterval(() => {
            fetch("{{ url('/keep-alive') }}", {
                method: "GET",
                credentials: "same-origin"
            });
        }, 60000);
    });
</script>
