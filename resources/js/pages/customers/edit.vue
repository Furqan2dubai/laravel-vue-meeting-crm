
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
  staff: '',
  staff_id: '',
  postcode: '',
  address: '',
  state: '',
  city: '',
})
const id = route.params.id

axios.get("/api/customers/" + id).then(res=>{
  if(res.data.success){ 
    form.value = res.data.data 
    // form.value.name = res.data.data[0].name
    // form.value.tel = res.data.data[0].tel
    // form.value.email = res.data.data[0].email
    // form.value.details = res.data.data[0].details
    // form.value.staff = res.data.data[0].staff
    // form.value.staff_id = res.data.data[0].staff_id
    // form.value.region_name = res.data.data[0].region_name
    // form.value.region_id = res.data.data[0].region_id
    } 
    else{
        store.setMsgbox({status:false, msg:"Failed to load data"}); 
    }
}).catch(function (error) {
    store.setMsgbox({status:false, msg:error}); 
}); 

const update = ()=>{ 
  axios.post("/api/customers/" + id, form.value).then(res=>{
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

const staff = ref([])
let staff_search = (e)=>{ 
  let input = (e.target.value)
  if(input.length>1){
    axios.post("/api/search/staff", {
      field: 'name', keyword: input
    }).then(res=>{
      if(res.data.success){    
        staff.value = res.data.data.map(e=>{return {title:e.name, value:e.id}}) 
      } 
      else{
          store.setMsgbox({status:false, msg:"Failed to load Meeting data"}); 
      }
    }).catch(function (error) {
        store.setMsgbox({status:false, msg:error}); 
    }); 
  } 
}
const staff_update = () => { 
  form.value.staff_id = form.value.staff.value 
  form.value.staff = form.value.staff.title
}

</script>

<template>
  
  <VRow>  
    <Msgbox />  
    <VCol cols="12">
      <!-- 👉 Multiple Column -->
      <VCard title="Edit Customer">
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
                <VAutocomplete
                  v-model="form.staff"
                  label="staff"
                  placeholder="Search From Your staff"
                  :items="staff"
                  @input="e=>staff_search(e)"
                  @update:model-value="staff_update"
                  return-object
                />
              </VCol>
              <VCol
                cols="12"
                md="4"
              >
                <VTextField
                  v-model="form.city"
                  label="City"
                  placeholder="City" 
                />
              </VCol>

              <VCol
                cols="12"
                md="4"
              >
                <VTextField
                  v-model="form.state"
                  label="State"
                  placeholder="state" 
                />
              </VCol>

              <VCol
                cols="12"
                md="4"
              >
                <VTextField
                  v-model="form.postcode"
                  label="Postcode"
                  placeholder="Postcode" 
                />
              </VCol>

              <VCol
                cols="12"
                md="4"
              >
                <VTextField
                  v-model="form.country"
                  label="Country"
                  placeholder="Country" 
                />
              </VCol>
              <VCol
                cols="12"
                md="6"
              >
                <VTextarea
                  v-model="form.address"
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
                  @click="router.push({path:'/customers/'})"
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
