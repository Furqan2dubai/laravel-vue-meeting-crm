
<script setup>
  import Msgbox from '@/pages/global/msgbox.vue';
import { UserStore } from '@/store/userStore.js';
import axios from 'axios';
import { ref } from 'vue';
import { useRoute } from 'vue-router';
  const route = useRoute();
  const store = UserStore();
  let data = ref([]);  
  const id = route.params.id;
  const date = route.params.date;
  axios.get(`/api/staff/log/${id}/${date}`).then(res=>{
    if(res.data.success){ 
        data.value = res.data.data ;
        // data.value.headers = Object.keys(res.data.data[0]).map(v=>{ return  {title:v, key:v }});
      } 
      else{
          store.setMsgbox({status:false, msg:"Failed to load data"}); 
      }
  }).catch(function (error) {
      store.setMsgbox({status:false, msg:error}); 
  });  
  
</script>

<template>  
<VRow>  
  <Msgbox />
  <VCol cols="12">
    <VCard v-if="data.length>0" :title="`${data[0].staff} Transaction Logs`">  
      <VCardText>  
        <VTable >
          <thead>
            <tr>
              <th class="text-uppercase"> Date </th> 
              <th> Type</th>
              <th> Meeting No</th>
              <th>Amount</th>
              <th>Currency</th>
              <th>Method</th>
            </tr>
          </thead>

          <tbody>
            <tr v-for="val, index in data"  :key="val.id" >
              <td >{{ val.date }}   </td>
              <td class="text-center"> {{ val.type }} </td>
              <td class="text-center"> <router-link :to="`/meeting/view/${val.Meeting_id}`"> {{ val.Meeting_no }} </router-link></td>
              <td class="text-center"> {{ val.total }} </td>
              <td class="text-center"> {{ val.currency }} </td> 
              <td class="text-center"> {{ val.method }} </td> 
            </tr>
          </tbody>
        </VTable>
      </VCardText> 
      <!-- back btn -->
      <VCardText>  
          <router-link to="/staff" >
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
