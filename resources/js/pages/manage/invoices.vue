<script setup>
import { UserStore } from '@/store/userStore.js';
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
const props = defineProps(['data'])
 
  const store = UserStore(); 
  const router = useRouter();  

  const filter = ref(props.data);
  
  const data = ref([]);
  let page = ref(1);
  let total = ref(0);
  const load_data = ()=>{  
    if(filter.value.date=="" || filter.value.staff_id==""){
      return false;
    }
    axios.post("/api/get_data/meeting/"+page.value, {
        field1: 'staff_id', 
        keyword1: filter.value.staff_id,
        date: filter.value.date
    }).then(res=>{
      if(res.data.success){     
        data.value = data.value.concat(res.data.data)
        if(res.data.total){
          total.value = res.data.total;
          filter.value.total_meeting = res.data.total;
        } 
        total.value = total.value - 25;
        
        page.value = page.value + 1; 
      } 
      else{
          store.setMsgbox({status:false, msg:"Failed to load meeting data"}); 
      }
    }).catch(function (error) {
        store.setMsgbox({status:false, msg:error}); 
    });  
  }    
  onMounted(() => load_data());
  onUpdated(() => { 
    filter.value.total_meeting = 0;
    page.value = 1;
    total.value = 0;
    data.value = [];
    load_data() ;
  }); 
  
</script>
<template >   
  <VRow > 
    <VCol cols="12"> 
      <VTable v-if="data && filter" :key="filter">
        <thead>
          <tr >
            <th class="text-left"> Customer </th> 
            <th class="text-center"> Region </th> 
            <th class="text-center"> Meeting No </th> 
            <th class="text-center"> Amount </th> 
            <th class="text-center"> Note </th> 
          </tr>
        </thead>

        <tbody>
          <tr
            v-for="val, index in data"
            :key="index"
          > 
            <td class="text-left" > 
              <a :href="`customers/view/${ val.customer_id }`" target="_blank"> {{ val.customer_name }} </a>
            </td>
            <td class="text-center" > {{ val.region_name }} </td>
            <td class="text-center" > 
              <a :href="`meeting/view/${ val.id }`" target="_blank"> {{ val.Meeting_no }} </a>
            </td>
            <td class="text-center" > {{ val.total }} </td> 
            <td class="text-center" > {{ val.note }} </td> 
          </tr>
        </tbody>
      </VTable> 
    </VCol> 
    <VCol cols="auto" class=" mx-auto" v-if="total>0">
      <VBtn 
          id="loadmore"
          type="button"
          color="primary"
          variant="tonal"
          @click="load_data"
        >
          Load More ({{ total }} left)
      </VBtn> 
    </VCol>
  </VRow>
  <p class="ms-5" style="visibility: hidden;">
    Page 1 - Data of {{ filter.staff }} on {{ filter.date }}
  </p>

</template>
