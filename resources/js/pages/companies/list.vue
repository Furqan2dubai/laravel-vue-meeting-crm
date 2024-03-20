
<script setup>
import Msgbox from '@/pages/global/msgbox.vue';
import { UserStore } from '@/store/userStore.js';
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
const router = useRouter();
const store = UserStore();
 
let data = ref(); 
           
    axios.get("/api/companies").then(res=>{
        if(res.data.success){ 
        data.value = res.data.data 
        } 
        else{
            store.setMsgbox({status:false, msg:"Failed to load data"}); 
        }
    }).catch(function (error) {
        store.setMsgbox({status:false, msg:error}); 
    }); 
 
    const edit = (data)=>{
      router.push({path: '/companies/edit/'+data.id})
    }; 
    
    const remove = (id, index)=>{  
      if(confirm("Are you sure")){
        axios.delete("/api/companies/"+id).then(res=>{
        if(res.data.success){ 
            data.value.splice(index, 1);   
            store.setMsgbox({status:true, msg:"Successfully Removed"});
        }  
        }).catch(function (error) {
            store.setMsgbox({status:false, msg:"Failed to remove"});
        });  
      }
    };
</script>

<template>  
<VRow>  
  <Msgbox /> 
  <VCol cols="12">
    <VCard title="Companies" >  
      <VBtn 
        class="ml-auto addBtn" 
        @click="router.push({path:'/companies/add'})"
        >
        Add 
      </VBtn>  
      <VTable >
        <thead>
          <tr>
            <th class="text-uppercase"> Name </th> 
            <th> Tel</th>
            <th>payable</th>
            <th>receivable</th>
            <th>action</th>
          </tr>
        </thead>

        <tbody>
          <tr
            v-for="val, index in data"
            :key="val.id"
          >
            <td ><router-link :to="`/companies/view/${val.id}`" >{{ val.name }} </router-link>   </td>
            <td class="text-center"> {{ val.tel }} </td>
            <td class="text-center"> {{ val.payable }} </td>
            <td class="text-center"> {{ val.receivable }} </td>
            <td class="text-center"> 
              <VCardText class="py-3 px-4" > 
                  <VIcon size="30" color="primary" icon="bx-edit"  @click="edit(val)"/>
                
                  <VIcon size="30" color="error" icon="bx-trash" @click="remove(val.id, index)"/>
              </VCardText>
            </td>
          </tr>
        </tbody>
      </VTable> 
    </VCard>
  </VCol>  
  
</VRow>
  
</template>
