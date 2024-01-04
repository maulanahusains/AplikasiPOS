<script setup>
import { ref, onMounted } from 'vue';

const props = defineProps(['categories', 'error', 'success']);

const displayError = () => {
  if (props.error) {
    console.error(props.error);
  }
};

onMounted(displayError);
</script>

<template>
    hi
</template>