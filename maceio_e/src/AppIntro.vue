<script setup>
const emits = defineEmits(['btnPress'])
</script>

<template>
  <div class="container-intro">
    <div class="p-3 px-5 rounded-4 bg-brown-dark text-center">
      <p>Guess the word in 6 attempts. After each attempt, the tiles <br> show how close you are to the solution.</p>
      <div class="example">
        <div class="key-example">A</div>
        <div class="key-example">B</div>
        <div class="key-example">O</div>
        <div class="key-example">U</div>
        <div class="key-example key-correct">T</div>
      </div>
      <p>The letter <span class="small-key small-key-correct">T</span> is part of the word and is in the correct
        position.</p>
      <div class="example">
        <div class="key-example">A</div>
        <div class="key-example">B</div>
        <div class="key-example key-present">O</div>
        <div class="key-example">V</div>
        <div class="key-example">E</div>
      </div>
      <p>The letter <span class="small-key small-key-present">O</span> is part of the word but in a different position.
      </p>
      <div class="example">
        <div class="key-example">A</div>
        <div class="key-example key-absent">G</div>
        <div class="key-example">R</div>
        <div class="key-example">E</div>
        <div class="key-example">E</div>
      </div>
      <p>The letter <span class="small-key small-key-absent">G</span> is not part of the word.</p>
      <p>Accents are filled in automatically and are not considered <br> in the hints.</p>
      <p>Words may contain repeated letters.</p>
      <button class="btn-start" @click="emits('btnPress')">Start</button>
    </div>
  </div>
</template>

<style scoped>
.container-intro {
  position: fixed;
  top: 0;
  left: 0;
  display: flex;
  justify-content: center;
  align-items: center;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, .3);
  z-index: 2;
}

.example {
  display: flex;
  gap: .5rem;
  justify-content: center;
  align-items: center;
}

.key-example {
  width: 60px;
  height: 60px;
  display: flex;
  justify-content: center;
  align-items: center;
  border: 2px solid var(--brown-light);
  font-size: 1.5rem;
  font-weight: bolder;
  border-radius: .5rem;
  margin-bottom: 2rem;
}

.key-correct {
  background: var(--green);
  border-color: var(--green);
}

.key-present {
  background: var(--sand);
  border-color: var(--sand);
}

.key-absent {
  background: #191516;
  border-color: #191516;
}

.small-key {
  color: white;
  display: inline-block;
  width: 40px;
  aspect-ratio: 1;
  padding: .5rem;
  border-radius: .5rem;
}

.small-key-correct {
  background: var(--green);
}

.small-key-present {
  background: var(--sand);
}

.small-key-absent {
  background: var(--sand);
  background: #191516;
}
</style>