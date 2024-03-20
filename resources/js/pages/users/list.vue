
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
    axios.get("/api/users/page/"+page.value).then(res=>{
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
      } 
      else{
        store.setMsgbox({status:false, msg:"Failed to load data"}); 
      }
    }).catch(function (error) {
        store.setMsgbox({status:false, msg:error}); 
    }); 
    
  }

  load_data()
 
    const edit = (data)=>{
      router.push({path: '/users/edit/'+data.id})
    }; 
    
    const remove = (id, index)=>{  
      if(confirm("Are you sure")){
        axios.delete("/api/users/"+id).then(res=>{
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
    <VCard title="Users" >  
      <VBtn 
        class="ml-auto addBtn" 
        @click="router.push({path:'/users/add'})"
        >
        Add 
      </VBtn>  
      <VTable >
        <thead>
          <tr>
            <th class="text-uppercase"> Name </th> 
            <th> Email</th> 
            <th>action</th>
          </tr>
        </thead>

        <tbody>
          <tr
            v-for="val, index in data"
            :key="val.id"
          >
            <td ><router-link :to="`/users/view/${val.id}`" >{{ val.name }} </router-link>   </td>
            <td class="text-center"> {{ val.email }} </td> 
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
