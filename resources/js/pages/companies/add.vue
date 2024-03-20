
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
  address: '', 
  tax_no: '', 
  receivable: 0,
  payable: 0,
  logo:''
};
let form = ref({ ...intialValues })


const add = ()=>{
  axios.post("/api/companies", form.value).then(res=>{
  if(res.data.success){   
    store.setMsgbox({status:true, msg:"Sucessfully Added"}); 
    Object.assign(form.value, intialValues); 
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
      <VCard title="Add Company">
        <VCardText>
          <VForm @submit.prevent="add"  > 
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
                  v-model="form.tax_no"
                  label="Tax Number"
                  placeholder="E174" 
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
                  v-model="form.payable"
                  label="Payable"
                  placeholder="0"
                  type="number"
                />
              </VCol>
 
              <VCol
                cols="12"
                md="4"
              >
                <VTextField
                  v-model="form.receivable"
                  label="Receivable"
                  placeholder="0"
                  type="number"
                />
              </VCol>

              <VCol
                cols="12"
                md="4"
              >
                <VTextarea
                  v-model="form.address"
                  label="Address"
                  placeholder="New York"
                />
              </VCol>
<!-- 
              <VCol
                cols="12"
                md="4"
              >
                <VFileInput 
                  v-model="form.logo"
                  label="Company Logo" 
                /> 
              </VCol> -->
              

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
                  @click="router.push({path:'/companies/'})"
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
