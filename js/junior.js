const questions = [
  {
    question: "In 'Toy Story', what is the name of Andy's cowboy doll?",
    options: ["Buzz", "Rex", "Woody", "Hamm"],
    correctAnswer: "Woody",
  },
  {
    question: "Which magical school does Harry Potter attend?",
    options: ["Beauxbatons", "Durmstrang", "Hogwarts", "Ilvermorny"],
    correctAnswer: "Hogwarts",
  },
  {
    question: "In 'Finding Nemo', what kind of fish is Nemo?",
    options: ["Clownfish", "Angelfish", "Blue Tang", "Starfish"],
    correctAnswer: "Clownfish",
  },
  {
    question: "What does Olaf from 'Frozen' love most?",
    options: ["Ice Skating", "Warm Hugs", "Cold Weather", "Swimming"],
    correctAnswer: "Warm Hugs",
  },
  {
    question: "In 'The Lion King', who is Simba's father?",
    options: ["Scar", "Mufasa", "Rafiki", "Timon"],
    correctAnswer: "Mufasa",
  },
  {
    question: "What is the name of Shrek's donkey friend in 'Shrek'?",
    options: ["Jack", "Donkey", "Eddie", "Max"],
    correctAnswer: "Donkey",
  },
];

class Quiz {
  constructor(questions, container) {
    this.questions = questions;
    this.container = container;
    this.currentQuestion = 0;
    this.score = 0;
    this.showResult = false;
    this.quizCompleted = false;
    this.selectedAnswer = null;

    this.init();
  }

  init() {
    this.render();
  }

  handleAnswerSelect(answer) {
    if (this.showResult) return;

    this.showResult = true;
    this.selectedAnswer = answer;
    const correct =
      answer === this.questions[this.currentQuestion].correctAnswer;
    if (correct) this.score++;

    this.render();
  }

  handleNextQuestion() {
    this.showResult = false;
    this.selectedAnswer = null;

    if (this.currentQuestion < this.questions.length - 1) {
      this.currentQuestion++;
    } else {
      this.quizCompleted = true;
    }

    this.render();
  }

  restartQuiz() {
    this.currentQuestion = 0;
    this.score = 0;
    this.showResult = false;
    this.quizCompleted = false;
    this.selectedAnswer = null;
    this.render();
  }

  render() {
    if (this.quizCompleted) {
      this.renderCompletionScreen();
    } else {
      this.renderQuestion();
    }
  }

  renderQuestion() {
    const question = this.questions[this.currentQuestion];
    const html = `
            <div class="quiz-progress">
                Question ${this.currentQuestion + 1} of ${this.questions.length}
            </div>
            <div class="quiz-question">
                ${question.question}
            </div>
            <div class="quiz-options">
                ${question.options
                  .map(
                    (option) => `
                    <div class="quiz-option ${
                      this.showResult ? "quiz-disabled" : ""
                    } ${
                      this.showResult && option === question.correctAnswer
                        ? "quiz-correct"
                        : ""
                    } ${
                      this.showResult && option !== question.correctAnswer
                        ? "quiz-incorrect"
                        : ""
                    }" onclick="quiz.handleAnswerSelect('${option}')">
                        ${option}
                        ${
                          this.showResult && option === question.correctAnswer
                            ? '<span class="quiz-icon">✓</span>'
                            : this.showResult &&
                              option !== question.correctAnswer
                            ? '<span class="quiz-icon">✗</span>'
                            : ""
                        }
                    </div>
                `
                  )
                  .join("")}
            </div>
            ${
              this.showResult
                ? `
                <div class="quiz-result">
                    <p class="quiz-feedback">
                        ${
                          this.selectedAnswer === question.correctAnswer
                            ? "Correct! 🎉"
                            : `Wrong! The correct answer is ${question.correctAnswer}`
                        }
                    </p>
                    <button class="quiz-button" onclick="quiz.handleNextQuestion()">
                        ${
                          this.currentQuestion === this.questions.length - 1
                            ? "Finish Quiz"
                            : "Next Question"
                        }
                    </button>
                </div>
            `
                : ""
            }
        `;

    this.container.innerHTML = html;
  }

  renderCompletionScreen() {
    const html = `
            <div class="quiz-completion">
                <h2>Quiz Completed!</h2>
                <p>Your score: ${this.score} out of ${this.questions.length}</p>
                <button class="quiz-button" onclick="quiz.restartQuiz()">
                    Restart Quiz
                </button>
            </div>
        `;

    this.container.innerHTML = html;
  }
}

// Initialize the quiz
const quiz = new Quiz(questions, document.getElementById("quiz-container"));
