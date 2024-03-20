<script setup>
  import Msgbox from '@/pages/global/msgbox.vue';
import { UserStore } from '@/store/userStore.js';
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import Info from './info.vue';
import meeting from './meeting.vue';
import Payments from './payments.vue';
  const store = UserStore(); 
  const router = useRouter(); 
  let company = store.company_details ? JSON.parse(store.company_details) : ''

  const filter_data = ref({
    // customers_id: '',
    // customers_name: '',
    staff_id: '',
    staff: '',
    date: '',
    total_meeting: 0,
    total_payments: 0
  })


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
    filter_data.value.staff_id = filter_data.value.staff.value 
    filter_data.value.staff = filter_data.value.staff.title
  }
  const filter_fn = ()=>{
    // console.log(filter_data.value)
    // console.log(staff.value)
  }

  const navigationTab = ref('info')
</script>
<template>
  
  <VRow>
    <VCol cols="12">
      <Msgbox />  
    </VCol>
    <VCol>
      <VCard title="Manage">
        <VRow class="mx-5 my-5">
          <VCol cols="12" md="3">
            <VAutocomplete 
              :items="staff"
              label="staff"
              v-model="filter_data.staff"
              @input="e=>staff_search(e)"
              @update:model-value="staff_update"
              return-object
            />
          </VCol>
           
          <VCol cols="12" md="3">
            <VTextField
              type="date"
              label="Date"
              v-model="filter_data.date"
            /> 
          </VCol>

          <VCol cols="12" md="3">  
            <VBtn 
              class="d-flex"   
              style="height:60px"
              variant="tonal"
              @click="filter_fn"
            >
              Open 
            </VBtn>   
          </VCol>
          <VCol cols="12">
            <VTabs v-model="navigationTab"> 
              <VTab
                key="info"
                value="info"
              >
                Summary 
              </VTab>
              <!-- <VTab
                key="reports"
                value="reports"
              >
                reports 
              </VTab> -->
              <VTab
                key="meeting"
                value="meeting"
              >
                meeting ({{ filter_data.total_meeting }})
              </VTab>
              <VTab
                key="payments"
                value="payments"
              >
                Payments ({{ filter_data.total_payments }})
              </VTab>
              <VTab
                key="return_items"
                value="return_items"
              >
                Return Items
              </VTab>
              
            </VTabs>
      
            <VDivider />
      
            <!-- tabs content -->
            <VWindow v-model="navigationTab"> 
              <VWindowItem
                key="info"
                value="info" 
                >  
                  <Info :data="filter_data"/>
              </VWindowItem>
              <!-- <VWindowItem
                key="reports"
                value="reports" 
                >  
                  <Reports />
              </VWindowItem> -->
              <VWindowItem
                key="meeting"
                value="meeting" 
                >  
                  <meeting :data="filter_data"/>
              </VWindowItem>
              <VWindowItem
                key="payments"
                value="payments" 
                >  
                  <Payments :data="filter_data"/>
              </VWindowItem>
              <VWindowItem
                key="return_items"
                value="return_items" 
                >  
                   
              </VWindowItem>
               
            </VWindow>
          </VCol>  
        </VRow>  
      </VCard>
    </VCol>

  </VRow>

</template>
