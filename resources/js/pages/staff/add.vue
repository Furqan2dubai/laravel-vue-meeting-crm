
<script setup>
import Msgbox from '@/pages/global/msgbox.vue';
import { UserStore } from '@/store/userStore.js';
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
const store = UserStore();
// const route = useRoute();
const router = useRouter(); 
let intialValues = {
  name: '',
  tel: '',
  email: '',
  details: '',
  staff_no: '',
  added_by: store.user_id
};
let form = ref({ ...intialValues }) 


const add = ()=>{
  axios.post("/api/staff", {staff:form.value}).then(res=>{
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
      <VCard title="Add staff">
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
                  v-model="form.tel"
                  label="Contact No"
                  placeholder="+971588901743"
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
                  v-model="form.staff_no"
                  label="staff No"
                  placeholder="Arnold007"
                />
              </VCol>
 
              

              <VCol
                cols="12"
                md="4"
              >
                <VTextarea
                  v-model="form.details"
                  label="Address"
                  placeholder="New York"
                />
              </VCol>

              

              <VCol
                cols="12"
                class="d-flex gap-4"
              >
                <VBtn
                  type="submit" 
                  variant="tonal" 
                >
                  <span class="d-none d-sm-block">Add</span>
                  <VIcon
                    icon="bx-refresh"
                    class="d-sm-none"
                  />
                </VBtn> 

                <VBtn
                  type="button"
                  color="secondary"
                  variant="tonal"
                  @click="router.push({path:'/staff/'})"
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
