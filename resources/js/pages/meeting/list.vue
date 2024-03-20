
<script setup>
import Msgbox from '@/pages/global/msgbox.vue';
import { UserStore } from '@/store/userStore.js';
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter();
const store = UserStore();
let data = ref([]); 
let page = ref(1);
let total = ref(0);
const load_data = ()=>{  
  axios.get("/api/meeting/page/"+page.value).then(res=>{
    if(res.data.success){   
     data.value = data.value.concat(res.data.data)
      if(res.data.total){
        total.value = res.data.total;
      }
      else{
        total.value = total.value - 25;
      }
      page.value = page.value + 1; 
      // document.getElementById("loadmore").scrollIntoView();
      if(res.data.data.length>0){
        store.setMeetingNo(res.data.data[0].Meeting_no)   
      }
    } 
    else{
      store.setMsgbox({status:false, msg:"Failed to load data"}); 
    }
  }).catch(function (error) {
      // store.setMsgbox({status:false, msg:error}); 
  }); 
  
}

load_data()
 
    const edit = (id)=>{
      router.push({path: '/meeting/edit/'+id})
    }; 
    
    const remove = (id, index)=>{  
      if(confirm("Are you sure")){
        axios.delete("/api/meeting/"+id).then(res=>{
        if(res.data.success){ 
            data.value.splice(index, 1);   
            store.setMsgbox({status:true, msg:"Successfully Removed"});
        }  
        }).catch(function (error) {
            store.setMsgbox({status:false, msg:"Failed to remove"});
        });  
      }
    };

    // const print = (id, index)=>{  
    //   router.push({path: '/meeting/view/'+id})
    // };

    let navigationTab = 'active';

    
</script>

<template>  
<VRow>  
  <Msgbox /> 
  <VCol cols="12">
    <VCard title="Meeting List" >  
      <VBtn 
        class="ml-auto addBtn" 
        @click="router.push({path:'/meeting/add'})"
        >
        Add 
      </VBtn>  
      <VTabs   v-model="navigationTab">
        <VTab
          key="active"
          value="active"
        >
          All
        </VTab>
        <VTab
          key="draft"
          value="draft"
        >
          Pending 
        </VTab>
        <VTab
          key="canceled"
          value="canceled"
        >
          Canceled 
        </VTab>
      </VTabs>

      <VDivider />
      <VWindow>
        <VWindowItem
          key="active"
          value="active"
        > 
          <!-- <h1>Active</h1> -->
        </VWindowItem>
      </VWindow>
      <VTable >
        <thead>
          <tr>
            <th class="text-uppercase"> Agenda</th> 
            <th> Customer </th>
            <th>Staff</th>
            <th> Date/Time</th>
            <th>Status</th>
            <th>action</th>
          </tr>
        </thead>

        <tbody>
          <tr
            v-for="val, index in data"
            :key="val.id"  
          >
            <td ><router-link :to="`/meeting/view/${val.id}`" >{{ val.agenda }} </router-link>   </td>
            <td class="text-center"> {{ val.customer_name }} </td>
            <td class="text-center"> {{ val.staff }} </td>
            <td class="text-center"> {{ val.meeting_datetime }} </td>
            <td class="text-center"> {{ val.status }} </td>
            <td class="text-center"> 
              <VCardText class="py-3 px-4" >  
                <VIcon size="30" color="primary" icon="bx-edit"  @click="edit(val.id)"/>
                <VIcon size="30" color="error" icon="bx-trash" @click="remove(val.id, index)"/>
              </VCardText>
            </td>
          </tr>
        </tbody>
      </VTable>  

    </VCard>
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
  
</template>
