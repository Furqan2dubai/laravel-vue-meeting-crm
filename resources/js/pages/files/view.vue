
<script setup>
  import Msgbox from '@/pages/global/msgbox.vue';
import { UserStore } from '@/store/userStore.js';
import axios from 'axios';
import { ref } from 'vue';
import { useRoute } from 'vue-router';
  const route = useRoute();
  const store = UserStore();
  let data = ref({});  
  const id = route.params.id;
  axios.get(`/api/files/${id}`).then(res=>{
    if(res.data.success){ 
        data.value = res.data.data ;
        // console.log(data);
      } 
      else{
          store.setMsgbox({status:false, msg:"Failed to load data"}); 
      }
  }).catch(function (error) {
      store.setMsgbox({status:false, msg:error}); 
  });  
 
    // const k = route.params.id;
</script>

<template>  
<VRow>  
  <Msgbox />
  <VCol cols="12">
    <VCard title="View File">  
      <VCardText> 
        <a :href="data.path">
          <VImg :src="data.path" height="200"/>
        </a>
        <VTable > 
          <tbody>
            <tr v-for="val,index in data">
              <td class=" text-uppercase"><code>{{ index.replace("_"," ") }}</code> </td>
              <td> {{ val }} </td>   
            </tr>  
          </tbody>
        </VTable> 
      </VCardText> 
      <!-- back btn -->
      <VCardText>  
          <router-link to="/files" >
            <VBtn
              type="button"
              color="secondary"
              variant="tonal" 
            >
              Back
            </VBtn>
         </router-link> 
      </VCardText>
    </VCard>
  </VCol>  
</VRow>
  
</template>
