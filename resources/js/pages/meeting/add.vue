
<script setup>
import FileUpload from '@/pages/global/file_upload.vue';
import Msgbox from '@/pages/global/msgbox.vue';
import { UserStore } from '@/store/userStore.js';
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
const store = UserStore(); 
const router = useRouter(); 
let company = store.company_details ? JSON.parse(store.company_details) : ''
const tax_type = ref({type:'exclusive', color:'secondary'});
 
 
let intialValues = { 
  Meeting_no: store.last_Meeting_no, 
  Meeting_datetime: store.today,
  status: 'Active', 
  customer_id: '',
  customer_name: '',
  company_id: company.id || '',
  company_name: company.name || '',
  staff: '',
  staff_id: '',
  note: '',
  agenda: '',
  added_by: store.user_id
};
let Meeting = ref({ ...intialValues })

const companies = ref([])
let company_search = (e)=>{ 
  let input = (e.target.value)
  if(input.length>1){
    axios.post("/api/search/companies", {
      field: 'name', keyword: input
    }).then(res=>{
      if(res.data.success){    
        companies.value = res.data.data.map(e=>{return {title:e.name, value:e.id}}) 
      } 
      else{
          store.setMsgbox({status:false, msg:"Failed to load companies data"}); 
      }
    }).catch(function (error) {
        store.setMsgbox({status:false, msg:error}); 
    }); 
  } 
}

const company_update = () => { 
  Meeting.value.company_id = Meeting.value.company_name.value  
  Meeting.value.company_name = Meeting.value.company_name.title
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
          store.setMsgbox({status:false, msg:"Failed to load staff data"}); 
      }
    }).catch(function (error) {
        store.setMsgbox({status:false, msg:error}); 
    }); 
  } 
}

const staff_update = () => { 
  Meeting.value.staff_id = Meeting.value.staff.value 
  Meeting.value.staff = Meeting.value.staff.title
}

const customers = ref([])
let customer_search= (e)=>{ 
  let input = (e.target.value)
  if(input.length>1){
    axios.post("/api/search/customers", {
      field: 'name', keyword: input
    }).then(res=>{
      if(res.data.success){    
        customers.value = res.data.data.map(e=>{
          return {
            title:e.name, 
            value:e.id, 
            region_id: e.region_id, 
            region_name: e.region_name,
            staff_id: e.staff_id, 
            staff: e.staff
          }
        }) 
      } 
      else{
          store.setMsgbox({status:false, msg:"Failed to load customers data"}); 
      }
    }).catch(function (error) {
        store.setMsgbox({status:false, msg:error}); 
    }); 
  } 
}

const customer_update = () => { 
  Meeting.value.staff = Meeting.value.customer_name.staff 
  Meeting.value.staff_id = Meeting.value.customer_name.staff_id
  Meeting.value.region_name = Meeting.value.customer_name.region_name 
  Meeting.value.region_id = Meeting.value.customer_name.region_id
  Meeting.value.customer_id = Meeting.value.customer_name.value 
  Meeting.value.customer_name = Meeting.value.customer_name.title
}

  
//  Add Functionality
const add = ()=>{  
  const submit_data = {
    Meeting: Meeting.value
  }; 

  const config = {
      headers: {
          'content-type': 'multipart/form-data'
      }
  }
  let data = new FormData(); 
  data.append('form', JSON.stringify(submit_data)); 
  Array.from(files.value).forEach(file => {  
    data.append('upload_files[]', file);
  });

  axios.post("/api/meeting", data, config).then(res=>{
  if(res.data.success){   
    store.setMsgbox({status:true, msg:"Sucessfully Added"}); 
    Object.assign(Meeting.value, intialValues); 
    
    store.setMeetingNo(Meeting.value.Meeting_no) 
    router.push({path:"/meeting/view/"+ res.data.Meeting_id})
    // Object.assign(items.value, intialValuesItems);  
  } 
  else{
      store.setMsgbox({status:false, msg:"Failed to load data"}); 
  }
  }).catch(function (error) {
      store.setMsgbox({status:false, msg:error}); 
  }); 
}


const navigationTab = ref('ITEM ONE')

const files = ref([])
const get_files = (v)=>{
  files.value =  v; 

}
</script>

<template>
  <VForm @submit.prevent="add" enctype="multipart/form-data">
  <VRow>  
    <Msgbox />  
    <VCol cols="12">
      <!-- 👉 Multiple Column -->
      <VCard title="Add Meeting">
        <VTabs   v-model="navigationTab">
          <VTab
            key="Meeting"
            value="Meeting"
          >
            Meeting  
          </VTab>
          
          <VTab
            key="files"
            value="files"
          >
            files ({{ files.length }})
          </VTab>
        </VTabs>

        <VDivider />
        <VWindow v-model="navigationTab">
          <VWindowItem
            key="Meeting"
            value="Meeting"
            > 
            <VCardText>  
              <VRow> 
                <VCol
                  cols="12"
                  md="4"
                >
                  <VAutocomplete 
                    v-model="Meeting.company_name"
                    label="Company" 
                    :items="companies" 
                    @input="e=>company_search(e)"
                    @update:model-value="company_update"
                    return-object
                  />
                </VCol>

                <VCol
                  cols="12"
                  md="4"
                >
                  <VSelect
                    v-model="Meeting.status"
                    label="Status" 
                    :items="['Active', 'Canceled', 'Pending']"
                  />
                </VCol>

                
                <VCol
                  cols="12"
                  md="4"
                >
                  <VTextField
                    v-model="Meeting.agenda"
                    label="Agenda"
                    placeholder="HR Interview" 
                  />
                </VCol>

                <VCol
                  cols="12"
                  md="4"
                >
                  <VTextField
                    v-model="Meeting.Meeting_no"
                    label="Meeting No"
                    placeholder="INV 1200" 
                  />
                </VCol>
  
                <VCol
                  cols="12"
                  md="4"
                >
                  <VTextField
                    v-model="Meeting.Meeting_datetime"
                    label="Meeting Date"
                    type="datetime-local"
                  />
                </VCol> 
  
                <VCol
                  cols="12"
                  md="4"
                >
                  <VAutocomplete
                    v-model="Meeting.customer_name"
                    label="Customer" 
                    :items="customers"
                    @input="e=>customer_search(e)"
                    @update:model-value="customer_update"
                    return-object
                  />
                </VCol>
  
                <VCol
                  cols="12"
                  md="4"
                >
                  <VAutocomplete
                    v-model="Meeting.staff"
                    label="Staff"
                    placeholder="Arnold"
                    :items="staff"
                    @input="e=>staff_search(e)"
                    @update:model-value="staff_update"
                    return-object
                  />
                </VCol>

                <VCol
                  cols="12"
                  md="8"
                >
                  <VTextarea
                    v-model="Meeting.note"
                    label="Note"
                    placeholder="Remarks"  
                  />
                </VCol>
                
              </VRow> 
            </VCardText>
          </VWindowItem>
          
          <VWindowItem
            key="files"
            value="files"
          > 
            <FileUpload @files="v=>get_files(v)"/>
          </VWindowItem>
        </VWindow>
         
        </VCard>
      </VCol>
    </VRow> 
      

    <VRow>   
      <VCol>
        <VCard >
          
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
              @click="router.push({path:'/meeting/'})"
            >
              Back
            </VBtn>
          </VCol>
        </VCard>
      </VCol>
    </VRow>   
  </VForm>
</template>
