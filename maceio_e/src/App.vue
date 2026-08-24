<script setup>
import AppToast from "@/components/AppToast.vue";
import {computed, onMounted, onUnmounted, reactive, ref} from "vue";
import {syncStorage} from "@/helpers/global.js";
import words from '@/data/dictionary.json';
import AppIntro from "@/AppIntro.vue";
import {addToast} from "@/helpers/addToast.js";

const rowKeys = [
  [
    'Q',
    'W',
    'E',
    'R',
    'T',
    'Y',
    'U',
    'I',
    'O',
    'P',
  ],
  [
    'A',
    'S',
    'D',
    'F',
    'G',
    'H',
    'J',
    'K',
    'L',
    '«',
  ],
  [
    'Z',
    'X',
    'C',
    'V',
    'B',
    'N',
    'M',
    'ENTER',
  ]
]
const maxGuesses = 6;
const wordLength = 5;
const maxSeconds = 60 * 6;

// the game options object
const gameInfo = reactive({
  won: false,
  start: false,
  lose: false,
  seconds: maxSeconds,
})
const guesses = ref([]);
const submittedLetters = computed(() => {
  const guessesCopy = [...guesses.value];
  const letters = [];
  guessesCopy.forEach(guess => {
    for (let i = 0; i < guess.length; i++) {
      const letter = guess[i];
      const secretLetter = secretWord.value[i];
      let status = '';
      if (letter === secretLetter) {
        letters.push({
          letter,
          status: 'correct',
        })
      } else if (secretWord.value.includes(letter)) {
        letters.push({
          letter,
          status: 'present',
        })
      } else {
        letters.push({
          letter,
          status: 'absent',
        })
      }
    }
  })
  return letters;
})
// all submited correct letters
const correctLetters = computed(() => {
  const guessesCopy = [...submittedLetters.value];
  return guessesCopy.filter(letter => {
    return letter.status === 'correct';
  })
})
// all present correct letters
const presentLetters = computed(() => {
  const guessesCopy = [...submittedLetters.value];
  return guessesCopy.filter(letter => {
    return letter.status === 'present';
  })
})
// all absent correct letters
const absentLetters = computed(() => {
  const guessesCopy = [...submittedLetters.value];
  return guessesCopy.filter(letter => {
    return letter.status === 'absent';
  })
})
const typeGuess = ref('');
const secretWord = ref('');

// the key down event
function keydown(ev) {
  let {key} = ev;
  if (/^[a-z]$/i.test(key)) {
    addKey(key);
  } else if (key === 'Enter') {
    addKey(key);
  } else if (key === 'Backspace') {
    addKey('«')
  } else if (key === 'Escape') {
    startGame()
  } else if (key === 'Home') {
    console.log(secretWord.value);
  }
}

// restoring every property
function startGame() {
  guesses.value = [];
  typeGuess.value = '';
  generateWord();
  gameInfo.start = true;
  gameInfo.lose = false;
  gameInfo.won = false;
  gameInfo.seconds = maxSeconds;
  startTimer()
}

// what happers when we press a valid key
function addKey(key) {
  if (gameInfo.lose || !gameInfo.start) {
    if (gameInfo.lose) {
      addToast('This game has already been completed.', 'warning')
      return;
    }
    if (!gameInfo.start) {
      addToast('Please read the introduction first before starting the game.', 'warning')
    }
    return;
  }
  key = key.toUpperCase();
  if (key === 'ENTER') {
    submit()
  } else if (key === '«') {
    typeGuess.value = typeGuess.value.slice(0, typeGuess.value.length - 1);
  } else if (typeGuess.value.length < wordLength) {
    typeGuess.value += key;
  }
}

// submitting an answer
function submit() {
  // does nothing if string has less than 5 characters
  if (typeGuess.value.length < 5) {
    addToast('Words must contain exactly 5 letters.', 'warning')
    return;
  }
  const wordFound = words.find(w => {
    if (w.word === typeGuess.value) {
      return w.word;
    }
  })
  if (!wordFound) {
    addToast('The submitted word does not exist in the dictionary', 'warning');
    return;
  }
  guesses.value.push(typeGuess.value);
  typeGuess.value = '';
  checkIfWin();
  checkTime();
}

function checkTime() {
  const lastGuess = guesses.value[guesses.value.length - 1];
  let status = '';
  for (let i = 0; i < lastGuess.length; i++) {
    const letter = lastGuess[i];
    const secretLetter = secretWord.value[i];
    if (letter === secretLetter) {
      status = 'correct';
      break;
    }
  }
  if (status !== 'correct') {
    for (let i = 0; i < lastGuess.length; i++) {
      const letter = lastGuess[i];
      if (secretWord.value.includes(letter)) {
        status = 'present';
        break;
      }
    }
  }
  if (!status) {
    status === 'absent';
  }
  if (status === 'correct') {
    gameInfo.seconds += 30;
  } else if (status === 'present') {
    gameInfo.seconds += 10;
  } else {
    gameInfo.seconds -= 60;
  }
}

// check if user win or lose base on attempts
function checkIfWin() {
  let recentGuess = guesses.value[guesses.value.length - 1];
  if (recentGuess === secretWord.value) {
    gameInfo.won = true;
    gameInfo.lose = true;
  } else if (guesses.value.length === maxGuesses) {
    gameInfo.lose = true;
  }
}


let timerId;

function startTimer() {
  clearInterval(timerId);
  timerId = setInterval(() => {
    gameInfo.seconds--;
    if (gameInfo.seconds <= 0) {
      clearInterval(timerId);
      gameInfo.lose = true;
    }
  }, 1000)
}

//formating the total time in minutes and seconds
function formatTimer(total) {
  const min = Math.floor(total / 60);
  const sec = total % 60;
  return String(min).padStart(2, '0') + ':' + String(sec).padStart(2, '0');
}

onMounted(() => {
  window.addEventListener('keydown', keydown);
  syncStorage(guesses, 'guesses')
  syncStorage(typeGuess, 'type_guess');
  syncStorage(secretWord, 'secret_word');
  if (guesses.value.length !== 0) {
    gameInfo.start = true;
    checkIfWin()
  }
})

function generateWord() {
  let randomIndex = Math.floor(Math.random() * words.length)
  let randomWord = words[randomIndex].word;
  secretWord.value = randomWord;
}

onUnmounted(() => {
  window.removeEventListener('keydown', keydown);
})

// functoins
function getGuessClass(rowIndex, colIndex) {
  if (guesses.value.length > rowIndex) {
    return 'guessed';
  }
  if (guesses.value.length === rowIndex) {
    return 'active-guess'
  }
}

function getRowWon(row, col) {
  if (guesses.value.length === row && gameInfo.won) {
    return 'guess-won';
  }
}

function shouldTap(rowIndex, colIndex) {
  if (guesses.value.length === rowIndex) {
    if (typeGuess.value[colIndex]) {
      return 'guess-tap';
    }
  }
}

function getLetterGuess(rowIndex, colIndex) {
  if (guesses.value.length > rowIndex) {
    return guesses.value[rowIndex][colIndex];
  }
  if (guesses.value.length === rowIndex) {
    return typeGuess.value[colIndex]
  }
}

function getLetterGuessClass(row, col) {
  if (row < guesses.value.length) {
    const word = guesses.value[row];
    const letter = word[col];
    const secretLetter = secretWord.value[col];
    if (letter === secretLetter) {
      return 'correct';
    } else if (secretWord.value.includes(letter)) {
      return 'present';
    }
    return 'absent'
  }
  return '';
}

function showButtonClass(key) {
  let correctFound = correctLetters.value.find(c => {
    return c.letter === key;
  })
  if (correctFound) {
    return 'correct';
  }
  let present = presentLetters.value.find(c => {
    return c.letter === key;
  })
  if (present) {
    return 'present';
  }
  let absent = absentLetters.value.find(c => {
    return c.letter === key;
  })
  if (absent) {
    return 'absent';
  }
  return '';
}
</script>

<template>
  <div class="w-100 vh-100 bg-brown-light text-light py-5">
    <AppIntro v-if="!gameInfo.start" @btnPress="startGame"/>

    <div class="position-fixed top-0 end-0 m-5 rounded-3 bg-brown-dark py-2 px-4 font-bold">
      {{ formatTimer(gameInfo.seconds) }}
    </div>
    <div class="container">
      <h1 class="text-center">WGUESSER</h1>
      <div v-if="gameInfo.lose" class="text-center">
        <div v-if="gameInfo.won">
          <h1>Congratulations! You won!</h1>
        </div>
        <div v-else>
          <h1>You lose! The secret word was {{ secretWord }}</h1>
        </div>
        <button class="btn-start" @click="startGame(); gameInfo.start = false">Restart Game</button>
      </div>
      <div class="container-guesses">
        <div class="row-guess" v-for="(row, rowIndex) in maxGuesses">
          <div
              v-for="(col, colIndex) in wordLength"
              class="letter-guess"
              :class="[
                  getRowWon(row, col)
              ]"
              :style="{
                  animationDelay: (colIndex* .1) + (.2*wordLength + .2) + 's'
                }"
          >
            <div
                class="letter-wrapper"
                :class="[
                  getGuessClass(rowIndex,colIndex)
              ]"
                :style="{
                  animationDelay: (colIndex* .2) + 's'
                }"
            >
              <div
                  class="letter-half front"
                  :class="[
                      shouldTap(rowIndex,colIndex)
                  ]"
              >
                {{ getLetterGuess(rowIndex, colIndex) }}
              </div>
              <div
                  class="letter-half back"
                  :class="[
                    getLetterGuessClass(rowIndex, colIndex)
                  ]"
              >
                {{ getLetterGuess(rowIndex, colIndex) }}
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="container-keys">
        <div class="row-keys" v-for="row in rowKeys">
          <button class="key-cap" v-for="key in row"
                  :class="[
                      key === 'ENTER' && 'key-enter',
                      showButtonClass(key)
                      ]"
                  @click="addKey(key)"
          >
            {{ key }}
          </button>
        </div>
      </div>
    </div>
  </div>
  <app-toast></app-toast>
</template>

<style scoped>
.container-keys {
  margin: 0 auto;
  width: clamp(300px, 100%, 700px);
  display: flex;
  flex-direction: column;
  gap: .5rem;
}

.row-keys {
  display: flex;
  align-items: center;
  gap: .5rem;
}

.key-cap {
  width: 60px;
  height: 60px;
  flex-grow: 1;
  display: flex;
  justify-content: center;
  align-items: center;
  background: var(--brown-dark);
  border-radius: .5rem;
  font-size: 1.25rem;
  font-weight: bold;
  border: none;
  color: white;
}

.key-enter {
  flex-grow: 1;
  width: 200px;
}

.container-guesses {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  gap: .25rem;
  margin: 2rem 0;
}

.row-guess {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: .25rem;
}

.letter-guess {
  width: 70px;
  height: 70px;
  font-size: 1.75rem;
  font-weight: bolder;
  perspective: 200px;
}

.letter-wrapper {
  position: relative;
  width: 100%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-items: center;
  transform-style: preserve-3d;
}

.letter-half {
  position: absolute;
  left: 0;
  top: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100%;
  backface-visibility: hidden;
  border-radius: .5rem;
}

.front {
  background: var(--brown);
}

.back {
  transform: rotateY(180deg);
  background: var(--brown-dark);
}

.active-guess .front {
  background: var(--brown-light);
  border: 5px solid var(--brown);
}

.guessed {
  animation: show-guess .5s 1 linear forwards;
  border-color: transparent;
}

@keyframes show-guess {
  from {
    transform: rotateY(0deg);
  }
  to {
    transform: rotateY(180deg);
  }
}

.guess-tap {
  animation: show-tap .1s linear;
}

@keyframes show-tap {
  from, to {
    transform: scale(1);
  }
  50% {
    transform: scale(1.2);
  }
}

.correct {
  background: var(--green);
}

.present {
  background: var(--sand);
}

.absent {
  background: var(--brown-dark);
  opacity: .15;
}

.guess-won {
  animation: won .3s 1 ease-out;
}

@keyframes won {
  from, to {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-30px);
  }
}
</style>