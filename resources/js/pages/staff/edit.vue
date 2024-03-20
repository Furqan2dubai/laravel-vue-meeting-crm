
<script setup>
import Msgbox from '@/pages/global/msgbox.vue';
import { UserStore } from '@/store/userStore.js';
import axios from 'axios';
import { ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
const store = UserStore();
const route = useRoute();
const router = useRouter(); 
let form = ref({
  name: '',
  tel: '',
  email: '',
  details: '',
  staff_no: ''
})
const id = route.params.id

axios.get("/api/staff/" + id).then(res=>{
  if(res.data.success){  
    form.value.name = res.data.data.staff.name
    form.value.tel = res.data.data.staff.tel
    form.value.email = res.data.data.staff.email
    form.value.details = res.data.data.staff.details
    form.value.staff_no = res.data.data.staff.staff_no 
    } 
    else{
        store.setMsgbox({status:false, msg:"Failed to load data"}); 
    }
}).catch(function (error) {
    store.setMsgbox({status:false, msg:error}); 
}); 
 



const update = ()=>{ 
  axios.post("/api/staff/" + id, {staff:form.value}).then(res=>{
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
</script>

<template>
  
  <VRow>  
    <Msgbox />  
    <VCol cols="12">
      <!-- 👉 Multiple Column -->
      <VCard title="Edit staff">
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
                  <span class="d-none d-sm-block">Update</span>
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
