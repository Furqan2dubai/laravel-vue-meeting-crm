
<script setup>
import Msgbox from '@/pages/global/msgbox.vue';
import { UserStore } from '@/store/userStore.js';
import axios from 'axios';
import { reactive } from 'vue';
import { useRouter } from 'vue-router';
const store = UserStore();
// const route = useRoute();
const router = useRouter(); 
let intialValues = {
  name: '',
  email: '',
  password: '',
  added_by: store.user_id
};
let form = reactive({ ...intialValues })


const add = ()=>{
  axios.post("/api/users", form).then(res=>{
  if(res.data.success){   
    store.setMsgbox({status:true, msg:"Sucessfully Added"}); 
    Object.assign(form, intialValues); 
  } 
  else{
      store.setMsgbox({status:false, msg:"Failed to load data"}); 
  }
  }).catch(function (error) {
      store.setMsgbox({status:false, msg:error}); 
  }); 
}
</script>

<template>
  
  <VRow>  
    <Msgbox />  
    <VCol cols="12">
      <!-- 👉 Multiple Column -->
      <VCard title="Add User">
        <VCardText>
          <VForm @submit.prevent="add"> 
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
                />
              </VCol>
 
            

              <VCol
                cols="12"
                class="d-flex gap-4"
              >
                <VBtn type="submit">
                  Add
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
