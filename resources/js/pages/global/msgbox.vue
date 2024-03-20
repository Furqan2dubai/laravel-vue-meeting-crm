<template>  
  <VAlert
      v-if="store.msgbox" 
      :color="`${store.msgbox.color ? store.msgbox.color :store.msgbox.status?'primary':'error'}`"  
      class="mx-3" 
  > {{ store.msgbox.msg }} </VAlert>
</template>

<script setup>
 import { UserStore } from '@/store/userStore.js';
const store = UserStore();
// store.setMsgbox({status:true,msg:"Success"});
// console.log("msg", store.msgbox.status); 
</script> 

