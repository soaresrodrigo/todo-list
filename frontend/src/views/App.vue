<template>
    <div class="container bg-light">
        <TarefaList/>
    </div>
</template>

<style lang="scss" src="@/assets/app.scss"></style>

<script lang="ts">
import TarefaList from '@/components/TarefaList.vue';

export default {
  components: {
    TarefaList
  }
}
</script>
