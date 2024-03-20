
<script setup>
import Msgbox from '@/pages/global/msgbox.vue';
import { UserStore } from '@/store/userStore.js';
import axios from 'axios';
import { reactive } from 'vue';
import { useRoute, useRouter } from 'vue-router';
const store = UserStore();
const route = useRoute();
const router = useRouter(); 
let form = reactive({
  name: '',
  email: '',
  password: '',
})
const id = route.params.id || store.user_id 
axios.get("/api/users/" + id).then(res=>{
  if(res.data.success){  
    form.name = res.data.data[0].name
    form.email = res.data.data[0].email 
    form.password = res.data.data[0].password
    } 
    else{
        store.setMsgbox({status:false, msg:"Failed to load data"}); 
    }
}).catch(function (error) {
    store.setMsgbox({status:false, msg:error}); 
}); 

const update = ()=>{ 
  axios.post("/api/users/" + id, form).then(res=>{
  if(res.data.success){   
    store.setMsgbox({status:true, msg:"Sucessfully Updated"}); 
      } 
      else{
          store.setMsgbox({status:false, msg:"Failed to load data"}); 
      }
  }).catch(function (error) {
      store.setMsgbox({status:false, msg:error}); 
  }); 
} 
if(id){
}
</script>

<template>
  
  <VRow>  
    <Msgbox />  
    <VCol cols="12">
      <!-- 👉 Multiple Column -->
      <VCard title="Edit User">
        <VCardText>
          <VForm @submit.prevent="update"> 
            <VRow> 
              <VCol
                cols="12"
                md="4"
              >
                <VTextField
                  v-model="form.name"
                  label="Name"
                  placeholder="John" 
                />
              </VCol>
 
              <VCol
                cols="12"
                md="4"
              >
                <VTextField
                  v-model="form.email"
                  label="Email"
                  placeholder="johndoe@email.com"
                />
              </VCol>
 
              <VCol
                cols="12"
                md="4"
              >
                <VTextField
                  v-model="form.password"
                  label="Password"
                  type="password"
                  messages="Keep empty if you want to keep current password"
                  placeholder="Keep empty if you want to keep current password"
                  value=""
                />
              </VCol>

              <VCol
                cols="12"
                class="d-flex gap-4"
              >
                <VBtn type="submit">
                  Update
                </VBtn>

                <VBtn
                  type="button"
                  color="secondary"
                  variant="tonal"
                  @click="router.push({path:'/users/'})"
                >
                  Back
                </VBtn>
              </VCol>
            </VRow>
          </VForm>
        </VCardText>
      </VCard>
    </VCol>
  </VRow> 
</template>
