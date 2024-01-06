<script setup>
import { ref, onMounted } from 'vue';

const props = defineProps({ 
  categories: Object,
  error: String, 
  success: String, 
  errors: Object
});

const displayError = () => {
  if (props.error) {
    console.error(props.error);
  } else if(props.errors) {
    console.error(props.errors);
  }
};

onMounted(displayError);
</script>

<template>
    hi
</template>