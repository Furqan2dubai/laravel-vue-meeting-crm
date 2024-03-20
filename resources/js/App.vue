<script setup>
// import UpgradeToPro from '@/components/UpgradeToPro.vue';
import { hexToRgb } from '@layouts/utils';
import { useTheme } from 'vuetify';
const { global } = useTheme(); 

</script>
<script>
  // export default {
  //   computed: {
  //       ...mapState(UserStore, ['token', 'name'])
  //   } 
  // }
</script>

<template>
  <VApp :style="`--v-global-theme-primary: ${hexToRgb(global.current.value.colors.primary)}`">
    <RouterView />
    <!-- <UpgradeToPro /> -->
  </VApp>
  
</template>
